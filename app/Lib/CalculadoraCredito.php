<?php

namespace App\Lib;

use App\Lib\pear\Finance;
use App\Models\CreditPayOff;
use App\Models\kaaxSidecc\Collection;

class CalculadoraCredito
{
    public function getMontoMaximo($clientPerson, $financialProduct, $tramitType)
    {
        $dias             = config('enums.periodicidad_valores')[$financialProduct->periodicity_id];
        $rate             = $financialProduct->daily_interest_rate/ 10000  * ($dias);
        $per              = $financialProduct->max_term;
        if ($tramitType == 3) { //refinanciamiento
            $pmt              = $clientPerson->payment_capacity + $clientPerson->active_discount;
        } else {
            $pmt              = $clientPerson->payment_capacity;
        }
        $max_loan_ammount = $financialProduct->max_loan_ammount;
        $finance = new Finance;
        $pagoPeriodico = $finance->presentValue($rate, $per, $pmt);
        // Verificar si el valor de $pagoPeriodico es mayor que $max_loan_ammount
        if ($pagoPeriodico > $max_loan_ammount) {

            // Redondear hacia abajo a la cifra más cercana en miles
            $pagoPeriodico = floor($pagoPeriodico / 1000) * 1000;
        } elseif ($pagoPeriodico < $max_loan_ammount) {
            // Asignar el valor de $max_loan_ammount si es menor
            $pagoPeriodico = $max_loan_ammount;
        }

        return $pagoPeriodico;

    }

    public function getMontoMaximoControlDesk($clientPerson, $financialProduct)
    {
        if ($financialProduct != null) {
            $dias             = config('enums.periodicidad_valores')[$financialProduct->periodicity_id];
            $rate             = $financialProduct->daily_interest_rate/ 10000  * ($dias);
            $per              = $financialProduct->max_term;
            $pmt = $clientPerson->payment_capacity;
            $max_loan_ammount = $financialProduct->max_loan_ammount;
            
            $finance = new Finance;
            $pagoPeriodico = $finance->presentValue($rate, $per, $pmt);
            // Verificar si el valor de $pagoPeriodico es mayor que $max_loan_ammount
            if ($pagoPeriodico > $max_loan_ammount) {
    
                // Redondear hacia abajo a la cifra más cercana en miles
                $pagoPeriodico = floor($pagoPeriodico / 1000) * 1000;
            } elseif ($pagoPeriodico < $max_loan_ammount) {
                // Asignar el valor de $max_loan_ammount si es menor
                $pagoPeriodico = $max_loan_ammount;
            }
    
            return $pagoPeriodico * -1;
        }
        return null;
    }

    public function getPayment($financialProduct, $pv, $max_term = null)
    {
        $dias = config('enums.periodicidad_valores')[$financialProduct->periodicity_id];
        $rate = $financialProduct->daily_interest_rate/ 10000  * ($dias);
        $nper = $financialProduct->max_term;
        if ($max_term != null) {
            $nper = $max_term;
        }
        $finance = new Finance;
        $payment = $finance->payment($rate, $nper, $pv);
        return $payment * -1;
    }

    public function presentValue($financialProduct, $plazo, $pmt)
    {
        $dias             = config('enums.periodicidad_valores')[$financialProduct->periodicity_id];
        $rate             = $financialProduct->daily_interest_rate/ 10000  * ($dias);
        $nper = $plazo;
        
        $finance = new Finance;
        $present = $finance->presentValue($rate, $nper, $pmt);
        return $present * -1;
    }

    public function deudaPagoTotal($lead , $financialProduct, $plazo, $monto)
    {
        //dd($lead->id);
        $getCreditPayOff = CreditPayOff::selectRaw('MAX(financial_products.daily_interest_rate) as daily_interest_rate')
    ->join('financial_products', 'financial_products.id', '=', 'credit_pay_off.financial_product_id')
    ->where('lead_id', $lead->id)
    ->first();

        $rate = $getCreditPayOff->daily_interest_rate * $plazo;
        $nper = $plazo;
        $pmt  = $monto;

        $finance = new Finance;
        $present = $finance->presentValue($rate, $nper, $pmt);
        return $present;
    }

    public function getPaymentPresentValue($tasaInteresMensual, $plazo, $monto)
    {
        $finance = new Finance;
        $payment = $finance->payment($tasaInteresMensual, $plazo, $monto);
        return $payment;
    }
}