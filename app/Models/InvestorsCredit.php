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

    public function credit()
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }


    public static function removeInvestorsCreditsByProduct($financialProductId)
    {
        // 1. Buscar todos los créditos con el mismo producto financiero y que no estén bloqueados
        $relatedCreditIds = Credit::where('applied_financial_product', $financialProductId)
            ->where('funding_locked', 0)
            ->pluck('id');

        if ($relatedCreditIds->isEmpty()) {
            return true;
        }

        // ✅ 2. Obtener client_person_id de los créditos afectados
        $clientPersonIds = Credit::whereIn('id', $relatedCreditIds)
            ->pluck('client_person_id')
            ->unique();

        // ✅ 3. Eliminar los registros pending de esos créditos (status 0, 1, 2)
        self::whereIn('credit_id', $relatedCreditIds)
            ->whereIn('status', [0, 1, 2])
            ->delete();

        // ✅ 4. Actualizar banderas por cada crédito afectado
        foreach ($relatedCreditIds as $creditId) {
            Credit::updateClientPersonCreditFlags($creditId);
        }

        // ✅ 5. Obtener inversionistas relacionados
        $investorIds = InvestorProduct::where('financial_products_id', $financialProductId)
            ->pluck('investor_id')
            ->unique();

        // ✅ 6. Actualizar balances y reintentar fondeo por inversionista
        foreach ($investorIds as $investorId) {
            Investor::updateInvestorData($investorId);
        }
        InvestorsCredit::fundCredits($financialProductId);

        return true;
    }
    

    public static function fundCredits(int $financialProductId): void
    {
        $financialProduct = FinancialProduct::find($financialProductId);
        if (!$financialProduct) {
            return;
        }
    
        $availablePool = $financialProduct->loan_available;
    
        $credits = Credit::where('applied_financial_product', $financialProductId)
            ->where('funding_locked', 0)
            ->where('canceled', 0)
            ->orderBy('created_at', 'asc')
            ->get();
    
        // Eager load investors to have a stateful collection
        $investorProducts = InvestorProduct::where('financial_products_id', $financialProductId)->with('investor')->get();
        $activeInvestors = $investorProducts->map(function ($invProd) {
            return $invProd->investor;
        })->filter(function ($investor) {
            return $investor && $investor->loan_active == 1;
        });
    
        $canFund = true;
    
        foreach ($credits as $credit) {
            InvestorsCredit::where('credit_id', $credit->id)->delete();
            $amountRequired = $credit->applied_import;
            $loanTotalAmount = $credit->applied_loan_total_amount;
    
            if ($canFund && $availablePool >= $amountRequired) {
                $assignedSum = 0;
    
                // Use the stateful collection of active investor objects
                foreach ($activeInvestors as $investor) {
                    if ($investor->loan_available <= 0) { // Skip if they have no funds left
                        continue;
                    }
    
                    $maxAmount = max($availablePool, $amountRequired);
                    $percent = $availablePool > 0 ? ($investor->loan_available / $maxAmount) * 100 : 0;
                    $percent = min($percent, 100);
    
                    $import = ($percent * $amountRequired) / 100;
                    // Ensure investor does not contribute more than they have
                    $import = min($import, $investor->loan_available);
    
                    // Recalculate percentage based on the actual import amount, handling division by zero
                    $final_percent = $amountRequired > 0 ? ($import / $amountRequired) * 100 : 0;
                    $totalCredit = ($final_percent * $loanTotalAmount) / 100;
    
                    InvestorsCredit::create([
                        'credit_id'       => $credit->id,
                        'investor_id'     => $investor->id,
                        'percentage'      => $final_percent,
                        'import'          => $import,
                        'total_credit'    => $totalCredit,
                        'commission_rate' => $financialProduct->collection_commission_rate,
                        'status'          => 2,
                    ]);
    
                    // Update the local investor object's available funds for the next credit iteration
                    $investor->loan_available -= $import;
                    $assignedSum += $import;
                }
    
                $availablePool -= $assignedSum;
                $credit->funding_capital = $assignedSum; // Use assignedSum to reflect actual funded amount
                $credit->status = 2;
                $credit->save();
                $statusSOD = 1;
            } else {
                $canFund = false;
    
                InvestorsCredit::create([
                    'credit_id'       => $credit->id,
                    'investor_id'     => null,
                    'percentage'      => 0,
                    'import'          => 0,
                    'total_credit'    => 0,
                    'commission_rate' => $financialProduct->collection_commission_rate,
                    'status'          => 1,
                ]);
    
                $credit->funding_capital = 0;
                $credit->status = 1;
                $credit->save();
                $statusSOD = 0;
            }
    
            // Actualizar validación en control desk
            $request = new \stdClass();
            $request->{'fondos-suficientes'} = $statusSOD;
            CreditsControlDesk::saveEdit($credit->id, $request, 'Fondos suficientes');
    
            // ✅ ACTUALIZAR FLAGS DEL CLIENT_PERSON RELACIONADO
            Credit::updateClientPersonCreditFlags($credit->id);
        }
    
        // ✅ Recalcular balances finales tras fondeo
        $investorIds = $activeInvestors->pluck('id')->unique();
        foreach ($investorIds as $invId) {
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
