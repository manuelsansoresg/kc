<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
                    $percent =  $getInvestor->loan_active == 1 ? $getInvestor->loan_available / $getFinancialProduct->loan_available: 0;
                    
                    $dataInvestorCredit = array(
                        'credit_id' => $creditId,
                        'investor_id' => $getInvestor->id,
                        
                    );
                    $existInvestorCredit              = InvestorsCredit::where($dataInvestorCredit);
                    $dataInvestorCredit['percentage'] = $percent;
                    $dataInvestorCredit['import']     = $percent * $applied_import;

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
}
