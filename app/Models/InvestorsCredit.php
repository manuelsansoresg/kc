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

    public static function saveEdit($creditId)
    {
        $getCredit = Credit::find($creditId);
        if (!$getCredit || $getCredit->funding_locked == 1) {
            return; // Si no existe o ya está bloqueado, salimos
        }
    
        $applied_financial_product = $getCredit->applied_financial_product;
        $applied_import            = $getCredit->applied_import ?? 0;
        $applied_loan_total_amount = $getCredit->applied_loan_total_amount ?? 0;
    
        // 1) Cargar el producto financiero (ya su loan_available incluye reservas antiguas)
        $getFinancialProduct = FinancialProduct::find($applied_financial_product);
        $loanAvailable = $getFinancialProduct ? $getFinancialProduct->loan_available : 0;
    
        // 2) ELIMINAR cualquier reserva ANTERIOR para este crédito
        //    (todos los registros donde credit_id = $creditId y status = 1)
        InvestorsCredit::where('credit_id', $creditId)
            ->where('status', 1)
            ->delete();
    
        // 3) Repartir de nuevo entre inversores activos en ese producto financiero
        $getInvestors = InvestorProduct::where('financial_products_id', $applied_financial_product)
            ->get();
    
        $totalAssigned = 0;
        $hasActiveInvestor = false;
        $involvedInvestorIds = [];
    
        foreach ($getInvestors as $invProd) {
            $inv = Investor::find($invProd->investor_id);
            if (!$inv || $inv->loan_active != 1) {
                continue;
            }
    
            $hasActiveInvestor = true;
            $involvedInvestorIds[] = $inv->id;
    
            // 3.a) Calcular porcentaje en base a max(loanAvailable, applied_import)
            $maxAmount = max($loanAvailable, $applied_import);
            $percent = ($maxAmount > 0)
                ? ($inv->loan_available / $maxAmount) * 100
                : 0;
            $percent = min($percent, 100);
    
            // 3.b) Calcular cuánto aporta este inversionista
            $import = ($percent * $applied_import) / 100;
            $total_credit = ($percent * $applied_loan_total_amount) / 100;
    
            // 3.c) Crear el nuevo registro en investors_credits (status = 1)
            InvestorsCredit::create([
                'credit_id'       => $creditId,
                'investor_id'     => $inv->id,
                'percentage'      => $percent,
                'import'          => $import,
                'total_credit'    => $total_credit,
                'commission_rate' => $getFinancialProduct->collection_commission_rate,
                'status'          => 1,
            ]);
    
            $totalAssigned += $import;
        }
    
        // 4) Si NO hay ningún inversor activo, dejamos un “registro genérico” con investor_id = NULL
        if (!$hasActiveInvestor) {
            InvestorsCredit::create([
                'credit_id'       => $creditId,
                'investor_id'     => null,
                'percentage'      => 0,
                'import'          => 0,
                'total_credit'    => 0,
                'commission_rate' => $getFinancialProduct->collection_commission_rate,
                'status'          => 1,
            ]);
        }
    
        // 5) Actualizar sólo funding_capital (no bloqueamos aún)
        $getCredit->funding_capital = $totalAssigned;
        if ($totalAssigned >= $applied_import) {
            // 6) Si cubrimos TODO el applied_import, marcamos funding_locked = 1
            $getCredit->funding_locked = 1;
        }
        $getCredit->save();
    
        // 7) Actualizar credit_active / sod_active en client_person
        $clientPersonId = $getCredit->client_person_id;
        $hasActiveCredit = InvestorsCredit::whereIn('credit_id',
                Credit::where('client_person_id', $clientPersonId)
                      ->where('product_id', '!=', 3)
                      ->pluck('id')
            )
            ->where('status', 1)
            ->exists();
        $hasActiveSod = InvestorsCredit::whereIn('credit_id',
                Credit::where('client_person_id', $clientPersonId)
                      ->where('product_id', 3)
                      ->pluck('id')
            )
            ->where('status', 1)
            ->exists();
        ClientPerson::where('id', $clientPersonId)->update([
            'credit_active' => $hasActiveCredit ? 1 : 0,
            'sod_active'    => $hasActiveSod ? 1 : 0,
        ]);
    
        // 8) Enviar validación “Fondos suficientes” a mesa de control
        $statusSOD = ($applied_import > $loanAvailable) ? 0 : 1;
        $req = new \stdClass();
        $req->{'fondos-suficientes'} = $statusSOD;
        CreditsControlDesk::saveEdit($creditId, $req, 'Fondos suficientes');
    
        // 9) Finalmente, recálculo en cascada: actualizar balances de cada inversor involucrado
        $involvedInvestorIds = array_unique($involvedInvestorIds);
        foreach ($involvedInvestorIds as $invId) {
            Investor::updateInvestorData($invId);
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

    public static function fundPendingCredits($financialProductId)
    {
        // 1) Cargar el producto financiero y su pool neto
        $financialProduct = FinancialProduct::find($financialProductId);
        if (!$financialProduct || $financialProduct->loan_available <= 0) {
            return;
        }
    
        // 2) Obtener créditos “pendientes” (funding_locked = 0 y sin ningún status≠1)
        $pendingCredits = Credit::where('applied_financial_product', $financialProductId)
            ->where('funding_locked', 0)
            ->whereDoesntHave('investorsCredits', function ($q) {
                $q->where('status', '!=', 1);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    
        // 3) PRIMER PASO: borrar TODAS las reservas antiguas (status=1) de esos créditos
        $creditIds = $pendingCredits->pluck('id');
        InvestorsCredit::whereIn('credit_id', $creditIds)
            ->where('status', 1)
            ->delete();
    
        // 4) Para cada crédito “pendiente”, intentar fondear. Si no alcanza, crear registro con investor_id=null
        foreach ($pendingCredits as $credit) {
            $amountRequired = $credit->applied_import;
    
            // 4.a) Si aún hay fondos suficientes en el producto, lo fondeamos
            if ($financialProduct->loan_available >= $amountRequired) {
                // Esto internamente va a volver a crear las reservas apropiadas (saveEdit borra antiguas,
                // vuelve a repartir entre inversores y bloquea si llega al 100 %)
                self::saveEdit($credit->id);
    
                // Refrescar disponibilidad para el siguiente crédito
                $financialProduct->refresh();
                if ($financialProduct->loan_available <= 0) {
                    // Si ya no queda nada, los que falten quedarán en el else
                    continue;
                }
            }
            else {
                // 4.b) Si NO alcanza el pool para cubrir este crédito,
                // crear el registro “inversor nulo” con status=1:
    
                InvestorsCredit::updateOrCreate(
                    [
                        'credit_id'   => $credit->id,
                        'investor_id' => null,
                    ],
                    [
                        'percentage'      => 0,
                        'import'          => 0,
                        'total_credit'    => 0,
                        'commission_rate' => $financialProduct->collection_commission_rate,
                        'status'          => 1,
                    ]
                );
    
                // IMPORTANTE: No bloqueamos funding_locked aquí; 
                // si quieres bloquearlos de inmediato, descomenta la siguiente línea:
                $credit->update(['funding_locked' => 1]);
            }
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
