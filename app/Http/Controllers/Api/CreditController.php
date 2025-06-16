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
        // 1) obtengo colección
        $col = AgreementCollection::where('credit_id', $creditId)->first();
        if (!$col) return;

        // 2) obtengo todos los investors_credits de este crédito KAAX
        $ics = InvestorsCredit::where('credit_id', $col->kc_credit_id)->get();
        if ($ics->isEmpty()) return;

        // 3) recálculo en lote
        $ics->each(function($ic) use ($col) {
            $p  = $ic->percentage / 100;
            $totalCollected = $col->pago_acumulado_real * $p;
            $recoveredCapital = $col->abono_acumulado_real * $p;
            $profitCollected  = ($totalCollected - $recoveredCapital) / 1.16;
            $ivaCollected     = $profitCollected * 0.16;
            $placedCapital    = $col->saldo_insoluto_real * $p;
            $comRateNoIva     = $ic->commission_rate / 1.16;
            $commissionAmount = $totalCollected * $comRateNoIva;
            $ivaCommission    = $commissionAmount * 0.16;
            $newStatus        = $placedCapital > 1 ? 4 : ($recoveredCapital > 0 ? 5 : $ic->status);

            $ic->update([
                'total_collected'   => $totalCollected,
                'recovered_capital' => $recoveredCapital,
                'profit_collected'  => $profitCollected,
                'iva_collected'     => $ivaCollected,
                'placed_capital'    => $placedCapital,
                'commission_amount' => $commissionAmount,
                'iva_commission'    => $ivaCommission,
                'total_balance'     => $col->saldo_total_real * $p,
                'credit_status'     => $col->status,
                'refinanciable'     => $col->refinanciable,
                'status'            => $newStatus,
            ]);
        });

        // ✅ 3.1 Actualizar credits.status con el status máximo de cada crédito
        $ics->groupBy('credit_id')->each(function ($group, $creditId) {
            $maxStatus = $group->max('status');
            Credit::where('id', $creditId)->update(['status' => $maxStatus]);
        });

        // 4) Llamar flags por cada crédito afectado (sin repetir)
        $ics->pluck('credit_id')->unique()->each(function ($creditId) {
            Credit::updateClientPersonCreditFlags($creditId);
        });

        // 5) Recalcular balances de todos los inversionistas
        $ics->pluck('investor_id')->filter()->unique()
            ->each(fn($invId) => Investor::updateInvestorData($invId));
    }
  

/*     {
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
            $comissionRate = $getInvestor->commission_rate / 1.16;

            $totalCollected = ($pago_acumulado_real * $percentage) / 100;
            $recoveredCapital = ($abono_acumulado_real * $percentage) / 100;
            $profitCollected = ($totalCollected - $recoveredCapital) / 1.16;
            $ivaCollected = $profitCollected * 0.16;
            $placedCapital = ($saldo_insoluto_real * $percentage) / 100;
            $comissionAmount = ($totalCollected * $comissionRate) / 100;
            $ivaComission = $comissionAmount * 0.16;

            $newStatus = ($placedCapital > 0) ? 2 : (($recoveredCapital > 0) ? 3 : $getInvestor->status);

            InvestorsCredit::where('id', $getInvestor->id)->update([
                'total_collected' => $totalCollected,
                'placed_capital' => $placedCapital,
                'recovered_capital' => $recoveredCapital,
                'total_balance' => ($saldo_total_real * $percentage) / 100,
                'credit_status' => $status,
                'refinanciable' => $refinanciable,
                'commission_amount' => $comissionAmount,
                'profit_collected' => $profitCollected,
                'iva_collected' => $ivaCollected,
                'iva_commission' => $ivaComission,
                'status' => $newStatus,
            ]);
        }

        $clientPersonIds = Credit::whereIn('id', $getInvestors->pluck('credit_id'))->pluck('client_person_id');
        $investorsCreditActive = InvestorsCredit::where('status', '<>', 0)->pluck('credit_id');

        foreach ($clientPersonIds as $clientPersonId) {
            $credits = Credit::where('client_person_id', $clientPersonId)->get();
        
            $hasActiveCredits = $credits->where('product_id', '!=', 3)
                ->whereIn('id', $investorsCreditActive)
                ->isNotEmpty();
        
            $hasActiveSodCredits = $credits->where('product_id', 3)
                ->whereIn('id', $investorsCreditActive)
                ->isNotEmpty();
        
            $sodAmount = AgreementCollection::where('kc_client_id', $clientPersonId)
                ->where('kc_product_id', 3)
                ->sum('saldo_total_real');
        
            $activeDiscount = AgreementCollection::where('kc_client_id', $clientPersonId)
                ->where('kc_product_id', '!=', 3)
                ->where('pagado', '>', 0)
                ->sum('pagado');
        
            ClientPerson::where('id', $clientPersonId)->update([
                'credit_active'    => $hasActiveCredits ? 1 : 0,
                'sod_active'       => $hasActiveSodCredits ? 1 : 0,
                'sod_active_amount'=> $sodAmount,
                'active_discount'  => $activeDiscount,
            ]);
        
            // ✅ Llamar flags por cada crédito
            foreach ($credits as $credit) {
                Credit::updateClientPersonCreditFlags($credit->id);
            }
        }            
        
        //$latestFinancialProductId = optional($credits->last())->applied_financial_product;

        //    if ($latestFinancialProductId) {
        //        self::updateTramitAllowed($clientPersonId, $latestFinancialProductId);
        //    }
        //}

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
                SUM(iva_collected) as iva_collected,
                SUM(iva_commission) as iva_commission
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
                'iva_commission' => $getSum->iva_commission,
            ]);

            Investor::updateInvestorData($getSum->investor_id);
        }
    } */

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
