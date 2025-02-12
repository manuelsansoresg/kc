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
         // 1. Obtener información de 'collections' asociado al 'kc_credit_id'
        $getCollection = agreementCollection::where('kc_credit_id', $creditId)->first();
        $pago_acumulado_real = $getCollection->pago_acumulado_real;
        $saldo_insoluto_real = $getCollection->saldo_insoluto_real;
        $abono_acumulado_real = $getCollection->abono_acumulado_real;
        $saldo_total_real = $getCollection->saldo_total_real;
        $status = $getCollection->status;

        // 2. Obtener lista de 'credit_id' en 'investorsCredit' asociados a los créditos obtenidos de 'collections'
        $creditIds = InvestorsCredit::whereIn('credit_id', function($query) use ($creditId) {
            $query->select('credit_id')->from('collections')->where('kc_credit_id', $creditId);
        })->pluck('credit_id');

        // 3. Calcular y actualizar valores de cada 'credit_id'
        foreach ($creditIds as $credit) {
            $investorCredit = InvestorsCredit::where('credit_id', $credit)->first();
            $percentage = $investorCredit->percentage / 100;

            InvestorsCredit::where('credit_id', $credit)->update([
                'total_collected' => ($pago_acumulado_real * $percentage),
                'placed_capital' => ($saldo_insoluto_real * $percentage),
                'recovered_capital' => ($abono_acumulado_real * $percentage),
                'total_balance' => ($saldo_total_real * $percentage),
                'credit_status' => $status,
            ]);
        }

        // 4. Obtener los investorIds de los créditos actualizados y actualizar la tabla 'investors'
        $investorIds = InvestorsCredit::whereIn('credit_id', $creditIds)->pluck('investor_id');

        $getSum = InvestorsCredit::whereIn('investor_id', $investorIds)
            ->selectRaw("SUM(placed_capital) as placed_capital, SUM(recovered_capital) as recovered_capital, SUM(total_collected) as total_collected, SUM(profit_collected) as profit_collected, SUM(commission_amount) as commission_amount, SUM(total_balance) as total_balance, SUM(iva_collected) as iva_collected")
            ->first();

        Investor::whereIn('id', $investorIds)->update([
            'placed_capital' => $getSum->placed_capital,
            'recovered_capital' => $getSum->recovered_capital,
            'total_collected' => $getSum->total_collected,
            'profit_collected' => $getSum->profit_collected,
            'collection_commission' => $getSum->commission_amount,
            'total_balance' => $getSum->total_balance,
            'iva_collected' => $getSum->iva_collected,
        ]);
        
    }
}
