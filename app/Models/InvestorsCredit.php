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
    ];

    public static function saveEdit($creditId)
    {
        $getCredit = Credit::find($creditId);
        if ($getCredit != null) {
            $applied_financial_product = $getCredit->applied_financial_product;
            $applied_import = $getCredit->applied_import != null ? $getCredit->applied_import : 0;
            $applied_loan_total_amount = $getCredit->applied_loan_total_amount != null ? $getCredit->applied_loan_total_amount : 0;
            
            $getFinancialProduct = FinancialProduct::find($applied_financial_product);
            $loanAvailable = $getFinancialProduct ? $getFinancialProduct->loan_available : 0;
            
            // Obtener inversionistas activos
            $getInvestors = InvestorProduct::where('financial_products_id', $applied_financial_product)->get();
            
            $totalAssigned = 0;
            $hasActiveInvestor = false;
            
            foreach ($getInvestors as $investorProduct) {
                $getInvestor = Investor::find($investorProduct->investor_id);
                if ($getInvestor && $getInvestor->loan_active == 1) {
                    $hasActiveInvestor = true;
                    $minAmount = min($loanAvailable, $applied_import);
                    $percent = $minAmount > 0 ? ($getInvestor->loan_available / $minAmount) * 100 : 0;
                    
                    $import = ($percent * $applied_import) / 100;
                    $total_credit = ($percent * $applied_loan_total_amount) / 100;
                } else {
                    $percent = 0;
                    $import = 0;
                    $total_credit = 0;
                }
                
                $dataInvestorCredit = [
                    'credit_id' => $creditId,
                    'investor_id' => $getInvestor ? $getInvestor->id : null,
                    'percentage' => $percent,
                    'import' => $import,
                    'total_credit' => $total_credit,
                    'commission_rate' => $getFinancialProduct->collection_commission_rate,
                    'status' => ($percent > 0) ? 1 : 0
                ];
                
                $existInvestorCredit = InvestorsCredit::where('credit_id', $creditId)
                    ->where(function ($query) use ($getInvestor) {
                        $query->where('investor_id', $getInvestor ? $getInvestor->id : null);
                    })->first();
                
                if ($existInvestorCredit) {
                    $existInvestorCredit->update($dataInvestorCredit);
                } else {
                    InvestorsCredit::create($dataInvestorCredit);
                }
                
                $totalAssigned += $import;
               /*  try {
                } catch (\Exception $th) {
                    // Log error
                } */
            }
            
            // Si no hay inversionistas activos, crear un registro con investor_id NULL
            if (!$hasActiveInvestor) {
                InvestorsCredit::updateOrCreate(
                    ['credit_id' => $creditId, 'investor_id' => null],
                    [
                        'percentage' => 0,
                        'import' => $applied_import,
                        'total_credit' => $applied_loan_total_amount,
                        'status' => 0
                    ]
                );
            }
            
            // Actualizar credit_active y sod_active en client_person
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
