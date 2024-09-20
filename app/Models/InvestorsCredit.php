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
        'total_collected',
        'profit_collected'
    ];

    public static function saveEdit($creditId)
    {
        $getCredit = Credit::find($creditId);
        if ($getCredit != null) {
            $applied_financial_product = $getCredit->applied_financial_product;
            $applied_import            = $getCredit->applied_import;
            $getInvestors              = InvestorProduct::where('financial_products_id', $applied_financial_product)->get();
            
            
            //dd($getInvestors);
            //dd($applied_financial_product);
            foreach ($getInvestors as $getInvestors) {
                try {
                    $getInvestor = Investor::find($getInvestors->investor_id);
                    $getFinancialProduct = FinancialProduct::find($applied_financial_product);
                    $commissionRate = $getFinancialProduct->collection_commission_rate;
                    $percent =  $getInvestor->loan_active == 1 ? ($getInvestor->loan_available / $getFinancialProduct->loan_available) * 100: 0;
                    
                    $dataInvestorCredit = array(
                        'credit_id' => $creditId,
                        'investor_id' => $getInvestor->id,
                        
                    );
                    $existInvestorCredit                   = InvestorsCredit::where($dataInvestorCredit);
                    $dataInvestorCredit['percentage']      = $percent;
                    $dataInvestorCredit['import']          = ($percent * $applied_import)/ 100;
                    $dataInvestorCredit['commission_rate'] = $commissionRate;

                    if ($percent > 0 ) {
                        if ($existInvestorCredit->count() == 0) {
                            InvestorsCredit::create($dataInvestorCredit);
                        } else {
                            $existInvestorCredit->update($dataInvestorCredit);
                        }
                    }
                } catch (\Exception $th) {
                    //throw $th;
                }
                
            }
        }

    }

    public static function setPlacedCapital($creditId)
    {
        $investors = InvestorsCredit::where('credit_id', $creditId)->get();
        foreach ($investors as $investor) {
            $placedCapital = $investor->total_capital  - $investor->recoverd_capital;
            Investor::where('id', $investor->id)->update([
                'placed_capital' => $placedCapital
            ]);
        }
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
