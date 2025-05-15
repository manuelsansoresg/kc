<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientPerson;
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
            //Transaction::setTotalCapital($getInvestor->id);
        }
    }

    public function setDataPago($creditId)
    {
        
        $getCollection = AgreementCollection::where('credit_id', $creditId)->first();

        if (!$getCollection) {
            return;
        }

        $pago_acumulado_real = $getCollection->pago_acumulado_real;
        $saldo_insoluto_real = $getCollection->saldo_insoluto_real;
        $abono_acumulado_real = $getCollection->abono_acumulado_real;
        $saldo_total_real = $getCollection->saldo_total_real;
        $status = $getCollection->status;
        $kcCreditId = $getCollection->kc_credit_id;
        $refinanciable = $getCollection->refinanciable;

        $getInvestors = InvestorsCredit::where('credit_id', $kcCreditId)->get();

        if ($getInvestors->isEmpty()) {
            return;
        }

        $investorsIds = [];

        foreach ($getInvestors as $getInvestor) {
            $investorsIds[] = $getInvestor->investor_id;
            $percentage = $getInvestor->percentage;
            $comissionRate = $getInvestor->commission_rate;

            $totalCollected = ($pago_acumulado_real * $percentage) / 100;
            $recoveredCapital = ($abono_acumulado_real * $percentage) / 100;
            $profitCollected = ($totalCollected - $recoveredCapital) / 1.16;
            $ivaCollected = $profitCollected * 0.16;
            $placedCapital = ($saldo_insoluto_real * $percentage) / 100;

            $newStatus = $placedCapital > 0 ? 2 : 0;

            InvestorsCredit::where('id', $getInvestor->id)->update([
                'total_collected' => $totalCollected,
                'placed_capital' => $placedCapital,
                'recovered_capital' => $recoveredCapital,
                'total_balance' => ($saldo_total_real * $percentage) / 100,
                'credit_status' => $status,
                'refinanciable' => $refinanciable,
                'commission_amount' => ($totalCollected * $comissionRate) / 100,
                'profit_collected' => $profitCollected,
                'iva_collected' => $ivaCollected,
                'status' => $newStatus,

            ]);
        }

        // Obtener los client_person_id afectados
        $clientPersonIds = Credit::whereIn('id', $getInvestors->pluck('credit_id'))->pluck('client_person_id');

        // Optimizar: solo una vez los InvestorsCredit activos
        $investorsCreditActive = InvestorsCredit::where('status', '<>', 0)->pluck('credit_id');

        foreach ($clientPersonIds as $clientPersonId) {
            $credits = Credit::where('client_person_id', $clientPersonId)->get();

            $hasActiveCredits = $credits->where('product_id', '!=', 3)
                ->whereIn('id', $investorsCreditActive)
                ->isNotEmpty();

            $hasActiveSodCredits = $credits->where('product_id', 3)
                ->whereIn('id', $investorsCreditActive)
                ->isNotEmpty();

            // Actualizar credit_active y sod_active
            ClientPerson::where('id', $clientPersonId)->update([
                'credit_active' => $hasActiveCredits ? 1 : 0,
                'sod_active' => $hasActiveSodCredits ? 1 : 0,
            ]);

            // Aquí integrar la actualización de los trámites permitidos
            $latestFinancialProductId = optional($credits->last())->applied_financial_product;

            if ($latestFinancialProductId) {
                self::updateTramitAllowed($clientPersonId, $latestFinancialProductId);
            }
        }

        // Actualizar los datos de los inversionistas
        $getSums = InvestorsCredit::whereIn('investor_id', $investorsIds)
            ->groupBy('investor_id')
            ->selectRaw('
                investor_id,
                SUM(placed_capital) as placed_capital,
                SUM(recovered_capital) as recovered_capital,
                SUM(total_collected) as total_collected,
                SUM(profit_collected) as profit_collected,
                SUM(commission_amount) as commission_amount,
                SUM(total_balance) as total_balance,
                SUM(iva_collected) as iva_collected
            ')
            ->get();

        foreach ($getSums as $getSum) {
            Investor::where('id', $getSum->investor_id)->update([
                'placed_capital' => $getSum->placed_capital,
                'recovered_capital' => $getSum->recovered_capital,
                'total_collected' => $getSum->total_collected,
                'profit_collected' => $getSum->profit_collected,
                'collection_commission' => $getSum->commission_amount,
                'total_balance' => $getSum->total_balance,
                'iva_collected' => $getSum->iva_collected,
            ]);

            Investor::updateInvestorData($getSum->investor_id);
        }
    }

    public function updateTramitAllowed($clientPersonId, $financialProductId)
    {
        // Obtener el cliente
        $clientPerson = ClientPerson::find($clientPersonId);
        if (!$clientPerson) {
            return false;
        }

        // Obtener el producto financiero
        $financialProduct = FinancialProduct::find($financialProductId);
        if (!$financialProduct) {
            return false;
        }

        // Inicializar valores
        $newTramitAllowed = 0;
        $additionalTramitAllowed = 0;
        $refTramitAllowed = 0;

        if ($clientPerson->credit_active == 0) {
            // No tiene créditos activos
            $newTramitAllowed = 1;
            $additionalTramitAllowed = 0;
            $refTramitAllowed = 0;
        } else {
            // Tiene créditos activos
            $newTramitAllowed = 0;

            // Evaluar si el producto permite crédito adicional
            if ($financialProduct->additional_allowed == 1) {
                $additionalTramitAllowed = 1;
            } else {
                $additionalTramitAllowed = 0;
            }

            // Evaluar si el producto permite refinanciamiento
            if ($financialProduct->refinancing_allowed == 1) {
                // Buscar créditos del cliente
                $creditIds = Credit::where('client_person_id', $clientPersonId)->pluck('id');

                // Verificar si hay al menos un crédito refinanciable
                $hasRefinanciable = InvestorsCredit::whereIn('credit_id', $creditIds)
                    ->where('refinanciable', 1)
                    ->exists();

                if ($hasRefinanciable) {
                    $refTramitAllowed = 1;
                } else {
                    $refTramitAllowed = 0;
                }
            } else {
                $refTramitAllowed = 0;
            }
        }

        // Actualizar los campos en client_person
        $clientPerson->update([
            'new_tramit_allowed' => $newTramitAllowed,
            'additional_tramit_allowed' => $additionalTramitAllowed,
            'ref_tramit_allowed' => $refTramitAllowed,
        ]);

        return true;
    }
}
