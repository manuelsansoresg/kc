<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Investor;
use App\Models\InvestorProduct;
use App\Models\InvestorsCredit;
use App\Models\kaaxSidecc\agreementCollection;
use App\Models\Transaction;
use App\Strategies\Values\SendNotificationsValues;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    /**
     * $credit_id of kaaxclub table 
     * $s2_credit_id credit_id table sidecc
     * $tipo 1=active 2 = reject
     */
    public function activar(Credit $credit, $s2_credit_id, $tipo = 1)
    {
        $credit_id = $credit->id;
        if ($tipo == 1) {
            Credit::where('id', $credit_id)->update([
                's2_credit_id' => $s2_credit_id,
                'credit_s2_active' => 1,
            ]);
        }
        /* $statusMove = HistoryLog::CREDITS_DELIVERED;
        $credit_id = $credit->id;
        if ($tipo == 2) {
            $statusMove = HistoryLog::CREDIT_REJECTED;
        }
        HistoryLog::move($credit->id, $statusMove, $statusMove);
        Credit::where('id', $credit_id)->update([
            's2_credit_id' => $s2_credit_id
        ]);
        //desactivar de delivery
        HistoryLog::where(['id_rel' => $credit_id, 'status_id' => HistoryLog::KC_DELIVERY, 'status' => 1])
        ->update([
           'status' => 0
        ]); */
    }

    public function apiSetTotalCapital($financial_product_id)
    {
        $getInvestors = InvestorProduct::where('financial_products_id', $financial_product_id)->get();
        foreach ($getInvestors as $getInvestor) {
            Transaction::setTotalCapital($getInvestor->id);
        }
    }

    public function setDataPago($creditId)
    {
        
        $getCollection =  agreementCollection::where('credit_id', $creditId)->first();
        $pago_acumulado_real = $getCollection->pago_acumulado_real;
        $saldo_insoluto_real = $getCollection->saldo_insoluto_real;
        $abono_acumulado_real = $getCollection->abono_acumulado_real;
        $saldo_total_real = $getCollection->saldo_total_real;
        $status = $getCollection->status;

        $kcCreditId =  $getCollection->kc_credit_id;
        $getInvestors = InvestorsCredit::where('credit_id', $kcCreditId)->get();
        $investorsIds  =  array();
        foreach ($getInvestors as $getInvestor) {
            $investorsIds[] = $getInvestor->id;
            $percentage = $getInvestor->percentage;
            $totalCollected = $getInvestor->total_collected;
            $comissionRate = $getInvestor->commission_rate;
            $recoveredCapital = $getInvestor->recovered_capital;
            $profitCollected  = $getInvestor->profit_collected ;

            InvestorsCredit::where('id', $getInvestor->id)->update([
                'total_collected' => ($pago_acumulado_real * $percentage) / 100,
                'placed_capital' => ($saldo_insoluto_real * $percentage) / 100,
                'recovered_capital' => ($abono_acumulado_real * $percentage) / 100,
                'total_balance' => ($saldo_total_real * $percentage) / 100,
                'credit_status' => $status,
                'commission_amount' => ($totalCollected * $comissionRate)/100,
                'profit_collected' => ($totalCollected - $recoveredCapital)/1.16,
                'iva_collected' => $profitCollected * 0.16,
            ]);
        }

        foreach ($investorsIds as $investorsId) {
            $getSum = InvestorsCredit::selectRaw(
                'SUM(placed_capital) as placed_capital,
                SUM(recovered_capital) as recovered_capital,
                SUM(total_collected) as total_collected,
                SUM(profit_collected) as profit_collected,
                SUM(commission_amount) as commission_amount,
                SUM(total_balance) as total_balance,
                SUM(iva_collected) as iva_collected'
                        )
                        ->where('id', $investorsId)->first();
                        Investor::where('id', $investorsId)->update([
                            'placed_capital' => $getSum->placed_capital,
                            'recovered_capital' => $getSum->recovered_capital,
                            'total_collected' => $getSum->total_collected,
                            'profit_collected' => $getSum->profit_collected,
                            'collection_commission' => $getSum->commission_amount,
                            'total_balance' => $getSum->total_balance,
                            'iva_collected' => $getSum->iva_collected,
                        ]);
                        Transaction::setTotalCapital($investorsId);
        }
        
    }
}
