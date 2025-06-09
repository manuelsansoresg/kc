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
            return; // Salir si no existe o ya está bloqueado
        }
    
        $applied_financial_product = $getCredit->applied_financial_product;
        $applied_import = $getCredit->applied_import ?? 0;
        $applied_loan_total_amount = $getCredit->applied_loan_total_amount ?? 0;
    
        $getFinancialProduct = FinancialProduct::find($applied_financial_product);
        $loanAvailable = $getFinancialProduct ? $getFinancialProduct->loan_available : 0;
    
        $getInvestors = InvestorProduct::where('financial_products_id', $applied_financial_product)->get();
    
        $totalAssigned = 0;
        $hasActiveInvestor = false;
    
        foreach ($getInvestors as $investorProduct) {
            $getInvestor = Investor::find($investorProduct->investor_id);
    
            if ($getInvestor && $getInvestor->loan_active == 1) {
                $hasActiveInvestor = true;
                $maxAmount = max($loanAvailable, $applied_import);
                $percent = $loanAvailable > 0 ? ($getInvestor->loan_available / $maxAmount) * 100 : 0;
                $percent = min($percent, 100);
    
                $import = ($percent * $applied_import) / 100;
                $total_credit = ($percent * $applied_loan_total_amount) / 100;
    
                $dataInvestorCredit = [
                    'credit_id' => $creditId,
                    'investor_id' => $getInvestor->id,
                    'percentage' => $percent,
                    'import' => $import,
                    'total_credit' => $total_credit,
                    'commission_rate' => $getFinancialProduct->collection_commission_rate,
                    'status' => 1
                ];
    
                $existInvestorCredit = InvestorsCredit::where('credit_id', $creditId)
                    ->where('investor_id', $getInvestor->id)
                    ->first();
    
                if ($existInvestorCredit && $existInvestorCredit->status == 1) {
                    $existInvestorCredit->update($dataInvestorCredit);
                } elseif (!$existInvestorCredit) {
                    InvestorsCredit::create($dataInvestorCredit);
                }
    
                $totalAssigned += $import;
            }
        }
    
        if (!$hasActiveInvestor) {
            $existing = InvestorsCredit::where('credit_id', $creditId)
                ->whereNull('investor_id')
                ->first();
    
            if ($existing && $existing->status == 1) {
                $existing->update([
                    'percentage' => 0,
                    'import' => $applied_import,
                    'total_credit' => $applied_loan_total_amount,
                    'commission_rate' => $getFinancialProduct->collection_commission_rate,
                    'status' => 1
                ]);
            } elseif (!$existing) {
                InvestorsCredit::create([
                    'credit_id' => $creditId,
                    'investor_id' => null,
                    'percentage' => 0,
                    'import' => $applied_import,
                    'total_credit' => $applied_loan_total_amount,
                    'commission_rate' => $getFinancialProduct->collection_commission_rate,
                    'status' => 1
                ]);
            }
    
            $totalAssigned += $applied_import;
        }
    
        // ✅ Actualizar solo funding_capital, no funding_locked
        $getCredit->funding_capital = $totalAssigned;
        $getCredit->save();
    
        // ✅ Actualizar credit_active y sod_active
        $clientPersonId = $getCredit->client_person_id;
    
        $hasActiveCredit = InvestorsCredit::whereIn('credit_id', Credit::where('client_person_id', $clientPersonId)
            ->where('product_id', '!=', 3)->pluck('id'))
            ->whereNotIn('status', [0, 3])
            ->exists();
    
        $hasActiveSod = InvestorsCredit::whereIn('credit_id', Credit::where('client_person_id', $clientPersonId)
            ->where('product_id', '=', 3)->pluck('id'))
            ->whereNotIn('status', [0, 3])
            ->exists();
    
        ClientPerson::where('id', $clientPersonId)->update([
            'credit_active' => $hasActiveCredit ? 1 : 0,
            'sod_active' => $hasActiveSod ? 1 : 0
        ]);
    
        // ✅ Validación en mesa de control
        $statusSOD = $applied_import > $loanAvailable ? 0 : 1;
        $request = new \stdClass();
        $request->{'fondos-suficientes'} = $statusSOD;
    
        CreditsControlDesk::saveEdit($creditId, $request, 'Fondos suficientes');
    
        // ✅ Actualizar balances de inversionistas involucrados
        $investorIds = InvestorsCredit::where('credit_id', $creditId)
            ->whereNotNull('investor_id')
            ->pluck('investor_id')
            ->unique();
    
        foreach ($investorIds as $investorId) {
            Investor::updateInvestorData($investorId);
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

    /* public static function updateInvestorCredits($investorId)
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
    } */

    public static function fundPendingCredits($financialProductId)
    {
        // Obtener producto financiero y su disponibilidad
        $financialProduct = FinancialProduct::find($financialProductId);
        if (!$financialProduct || $financialProduct->loan_available <= 0) {
            return;
        }

        // Obtener créditos pendientes que:
        // - Pertenecen al producto financiero
        // - No tienen fondeo activo (inversionistas con status diferente a 1)
        // - funding_locked = 0 (no están bloqueados para fondeo)
        $pendingCredits = Credit::where('applied_financial_product', $financialProductId)
            ->where('funding_locked', 0)
            ->whereDoesntHave('investorsCredits', function ($query) {
                $query->where('status', '!=', 1);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($pendingCredits as $credit) {
            $amountRequired = $credit->applied_import;

            // Verificar si hay suficiente capital disponible
            if ($financialProduct->loan_available < $amountRequired) {
                continue;
            }

            // Fondear el crédito usando la función central
            self::saveEdit($credit->id);

            

            // Actualizar disponibilidad tras fondeo
            $financialProduct->refresh();
            if ($financialProduct->loan_available <= 0) {
                break;
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
