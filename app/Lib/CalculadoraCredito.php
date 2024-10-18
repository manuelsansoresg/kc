<?php

namespace App\Lib;

use App\Lib\pear\Finance;
use App\Models\kaaxSidecc\Collection;

class CalculadoraCredito
{
    public function getMontoMaximo($clientPerson, $financialProduct)
    {
        $dias             = config('enums.periodicidad_valores')[$financialProduct->periodicity_id];
        $rate             = $financialProduct->daily_interest_rate/ 10000  * ($dias);
        $per              = $financialProduct->max_term;
        $pmt              = $clientPerson->payment_capacity + $clientPerson->active_discount;
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

    public function getPayment($financialProduct, $pv)
    {
        $dias = config('enums.periodicidad_valores')[$financialProduct->periodicity_id];
        $rate = $financialProduct->daily_interest_rate/ 10000  * ($dias);
        $nper = $financialProduct->max_term;
        $finance = new Finance;
        $payment = $finance->payment($rate, $nper, $pv);
        return $payment;
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
}