<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Investor;
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
        $statusMove = HistoryLog::CREDITS_DELIVERED;
        $credit_id = $credit->id;
        if ($tipo == 2) {
            $statusMove = HistoryLog::CREDIT_REJECTED;
        }
        HistoryLog::move($credit->id, $statusMove, $statusMove);
        Credit::where('id', $credit_id)->update([
            's2_credit_id' => $s2_credit_id
        ]);
        //desactivar de delivery
        HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_4, $credit_id, 1);
        //desactivate delivery
        HistoryLog::where(['id_rel' => $credit_id, 'status_id' => HistoryLog::KC_DELIVERY, 'status' => 1])
        ->update([
           'status' => 0
        ]);
    }

    public function apiSetTotalCapital($financial_product_id)
    {
        $getInvestors = Investor::where('financial_products_id', $financial_product_id)->get();
        foreach ($getInvestors as $getInvestor) {
            Transaction::setTotalCapital($getInvestor->id);
        }
    }
}
