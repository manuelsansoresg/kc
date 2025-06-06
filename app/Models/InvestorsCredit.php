<?php

namespace App\Models;

use App\Models\kaaxSidecc\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvestorsCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_id',
        'investor_id',
        'percentage',
        'import',
        'total_collected',
        'placed_capital',
        'commission_rate',
        'commission_amount',
        'recovered_capital',
        'profit_collected',
        'total_credit',
        'status',
        'total_balance',
        'credit_status',
        'iva_collected',
        'iva_commission',
        'refinanciable',
    ];

    public static function saveEdit(int $creditId, int $financialProductId)
    {
        $credit = Credit::find($creditId);
        if (!$credit) return;

        $montoReq         = $credit->applied_import  ?? 0;
        $totalLoanAmt     = $credit->applied_loan_total_amount ?? 0;
        $fp               = FinancialProduct::find($financialProductId);
        if (!$fp) return;

        // 1) Obtener inversores activos del producto
        $inversiones = InvestorProduct::where('financial_products_id', $financialProductId)
            ->pluck('investor_id');

        $invActivos = Investor::whereIn('id', $inversiones)
            ->where('loan_active', 1)
            ->get();

        $sumLoanAvail = $invActivos->sum('loan_available');
        if ($sumLoanAvail <= 0) {
            return;
        }

        // 2) Repartir proporcionalmente entre cada inversor activo
        foreach ($invActivos as $inv) {
            $pct = $sumLoanAvail > 0
                ? ($inv->loan_available / $sumLoanAvail) * 100
                : 0;
            $pct = min($pct, 100);

            $parteImport    = ($pct * $montoReq) / 100;
            $parteTotalLoan = ($pct * $totalLoanAmt) / 100;

            self::create([
                'credit_id'       => $creditId,
                'investor_id'     => $inv->id,
                'percentage'      => $pct,
                'import'          => $parteImport,
                'total_credit'    => $parteTotalLoan,
                'commission_rate' => $fp->collection_commission_rate,
                'status'          => 1,
            ]);
        }

        // 3) Bloquear el crédito y restar applied_import del producto
        $credit->funding_locked = 1;
        $credit->save();

        $fp->loan_available = max(0, ($fp->loan_available ?? 0) - $montoReq);
        $fp->save();

        // 4) Actualizar credit_active / sod_active en ClientPerson
        $cpId = $credit->client_person_id;
        $hasActiveCredit = self::whereIn('credit_id',
            Credit::where('client_person_id', $cpId)
                  ->where('product_id', '!=', 3)
                  ->pluck('id')
        )->whereNotIn('status', [0, 3])->exists();

        $hasActiveSod = self::whereIn('credit_id',
            Credit::where('client_person_id', $cpId)
                  ->where('product_id', 3)
                  ->pluck('id')
        )->whereNotIn('status', [0, 3])->exists();

        ClientPerson::where('id', $cpId)->update([
            'credit_active' => $hasActiveCredit ? 1 : 0,
            'sod_active'   => $hasActiveSod   ? 1 : 0,
        ]);

        // 5) Mesa de control: Fondos suficientes
        $statusSOD = ($montoReq > ($sumLoanAvail)) ? 0 : 1;
        $req = new \stdClass();
        $req->{'fondos-suficientes'} = $statusSOD;
        CreditsControlDesk::saveEdit($creditId, $req, 'Fondos suficientes');

        // 6) Notificar a cada inversor involucrado para que recalcule balances
        foreach ($invActivos as $inv) {
            Investor::updateInvestorData($inv->id);
        }
    }


    public static function lockFundingIfComplete($creditId)
    {
        $credit = Credit::find($creditId);

        if (!$credit) return;

        // Solo bloquear si está totalmente fondeado
        if ($credit->funding_capital >= $credit->applied_import) {
            $credit->funding_locked = 1;
            $credit->save();
        }
    }   

    public static function updateInvestorCredits($investorId)
    {
        // Obtener los productos financieros relacionados con el inversionista
        $financialProductIds = InvestorProduct::where('investor_id', $investorId)->pluck('financial_products_id');

        if ($financialProductIds->isEmpty()) {
            return; // No hay productos financieros asociados
        }

        // Obtener los créditos relacionados con esos productos financieros
        $creditIds = Credit::whereIn('applied_financial_product', $financialProductIds)->pluck('id');

        // Ejecutar saveEdit para cada crédito
        foreach ($creditIds as $creditId) {
            self::saveEdit($creditId); // Asegúrate de ajustar la clase si saveEdit no está en la misma
        }
    }

    public static function fundPendingCredits(int $financialProductId)
    {
        // 1.a) Cargar el producto
        $fp = FinancialProduct::find($financialProductId);
        if (!$fp) return;

        // 1.b) Obtener todos los créditos “pendientes” de ese producto
        //     “Pendientes” = funding_locked = 0
        $pendientes = Credit::where('applied_financial_product', $financialProductId)
            ->where('funding_locked', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($pendientes->isEmpty()) {
            return;
        }

        $creditIds = $pendientes->pluck('id')->all();

        // 2) ¿Cuánto estaba “reservado” en esas filas antiguas status=1?
        $sumaReservada = self::whereIn('credit_id', $creditIds)
            ->where('status', 1)
            ->sum('import');

        // 3) Borrar TODAS las filas antiguas de investors_credits con status=1
        self::whereIn('credit_id', $creditIds)
            ->where('status', 1)
            ->delete();

        // 4) Pool inicial: loan_available del producto + reservas anteriores
        $available = ($fp->loan_available ?? 0) + $sumaReservada;

        // 5) Reparto FIFO:
        foreach ($pendientes as $credit) {
            $montoReq = $credit->applied_import;

            // 5.a) Si el pool alcanza para cubrir este crédito:
            if ($available >= $montoReq) {
                // – Reparte entre inversores activos
                self::saveEdit($credit->id, $financialProductId);

                // – Refrescar y recalcular “available”
                $fp->refresh();
                $available = $fp->loan_available ?? 0;

                // Si ya no queda nada, los siguientes entrarán en el caso “no alcanza”
                if ($available <= 0) {
                    continue;
                }
            }

            // 5.b) Si NO alcanza para cubrir este crédito (o el pool ya es < 0):
            self::create([
                'credit_id'       => $credit->id,
                'investor_id'     => null,
                'percentage'      => 0,
                'import'          => $credit->applied_import,
                'total_credit'    => $credit->applied_loan_total_amount,
                'commission_rate' => $fp->collection_commission_rate,
                'status'          => 1,
            ]);
            $credit->update(['funding_locked' => 1]);
        }

        // 6) Finalmente, bloquear cualquier crédito que aún esté en funding_locked=0
        $restantes = Credit::where('applied_financial_product', $financialProductId)
            ->where('funding_locked', 0)
            ->pluck('id');

        foreach ($restantes as $credId) {
            self::create([
                'credit_id'       => $credId,
                'investor_id'     => null,
                'percentage'      => 0,
                'import'          => Credit::find($credId)->applied_import,
                'total_credit'    => Credit::find($credId)->applied_loan_total_amount,
                'commission_rate' => $fp->collection_commission_rate,
                'status'          => 1,
            ]);
            Credit::where('id', $credId)->update(['funding_locked' => 1]);
        }
    }
    
    public static function setPlacedCapital($creditId)
    {
        /* $investors = InvestorsCredit::where('credit_id', $creditId)->get();
        foreach ($investors as $investor) {
            $placedCapital = $investor->total_capital  - $investor->recoverd_capital;
            Investor::where('id', $investor->id)->update([
                'placed_capital' => $placedCapital
            ]);
        } */
    }

    public static function listStatements($investorId)
    {
        $investorCredits = InvestorsCredit::where('investor_id', $investorId)->get();
        $credits = array();
        foreach ($investorCredits as $investorCredit) {
            DB::connection('kaax_sidecc');
            $percentage = $investorCredit->percentage / 100;
            $collections = Collection::select(
                    'collections.kc_credit_id as id', 'statements.fecha_pago', 'statements.tipo_de_pago',
                    'statements.pagado',
                    DB::raw("$percentage * statements.pagado AS importe")
                    )
                    ->join('statements', 'statements.credit_id', 'collections.credit_id')
                    ->where('statements.estatus_pago', 1)
                    ->where('collections.kc_credit_id', $investorCredit->credit_id)->get();
            
            foreach ($collections as $collection) {
                $credits[] = array(
                    'id' => $collection->id,
                    'fecha' => $collection->fecha_pago,
                    'tipo' => isset(config('enums.pago')[$collection->tipo_de_pago])? config('enums.pago')[$collection->tipo_de_pago] : null,
                    'importe' => $collection->importe,
                    'comision' => null,
                    'options' => null,
                );
            }        
           
        }
        return $credits;
    }

    public static function setComissionRateAndAmount($creditId)
    {
        $credit         = Credit::find($creditId);
        $financial      = FinancialProduct::where('id', $credit->applied_financial_product)->first();
        $commissionRate = $financial->collection_commission_rate;

        $getInvestors = InvestorsCredit::where('credit_id', $creditId)->get();

        foreach ($getInvestors  as $getInvestor) {
            $totalCollected = $getInvestor->total_collected;
            $commission_amount = ($commissionRate * $totalCollected) / 100;
            InvestorsCredit::where('id', $getInvestor->id)->update([
                'commission_amount' => $commission_amount,
            ]);
           
        }
    }

   

}
