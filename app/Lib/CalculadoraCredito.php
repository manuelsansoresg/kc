<?php

namespace App\Lib;

use App\Lib\pear\Finance;

class CalculadoraCredito
{
    /**
     * 
     */
    public function getPagoQuincenal($plazo, $prestamo, $agreement_activar_promocion_iva, $agreement_tasa_i_promocion_iva, $agreement_tasa_i_iva, $agreement_periocidad_id)
    {
        //los campos de setReferenceRate vienen de sidecc de la tabla agreement
        $tasa_referencia = $this->setReferenceRate($agreement_activar_promocion_iva, $agreement_tasa_i_promocion_iva, $agreement_tasa_i_iva, $agreement_periocidad_id);
        $finance = new Finance;
        $pagoPeriodico = $finance->payment($tasa_referencia, $plazo, -$prestamo);
        return $pagoPeriodico;
    }

    public function getTasa($plazo, $descuento, $capital, $tipo_pago)
    {
        $periodicidad = config('enums.periodicidad_valores')[$tipo_pago]; //esto es de clients_job_info
        $tasa = (($this->getRate($plazo, -1 * $descuento, $capital) / $periodicidad) * 360) / 1.16 * 100;
        return $tasa;
    }

    // $tipo_pago esto es de clients_job_info
    public function getCat($tipo_pago, $capital, $comisionTotal, $descuento, $plazo)
    {
        $cat = 50;
        $cat_min = 0;
        $cat_max = 0;
        $counter = 0;

        if (isset($tipo_pago) && $tipo_pago == 1) {
            $periodsByYear = 24;
        } elseif (isset($tipo_pago) && $tipo_pago == 2) {
            $periodsByYear = 26;
        } else {
            $periodsByYear = 52;
        }

        $amount = removeDecimalToPrice($capital);
        $charge = $comisionTotal;
        $byPeriod = $descuento;
        $totalPayments = $plazo;

        do {
            $tempVal = $this->getCATValue($amount, $charge, $byPeriod, $totalPayments, $periodsByYear, $cat);
            if ($tempVal > 0) {
                $temp_cat = $cat;
                $cat = ($cat + $cat_min) / 2;
                $cat_max = $temp_cat;
            } elseif ($cat_max == 0) {
                $cat_min = $cat;
                $cat = $cat + 50;
            } else {
                $temp_cat = $cat;
                $cat = ($cat + $cat_max) / 2;
                $cat_min = $temp_cat;
            }
            $counter++;
        } while ($counter <= 25);
        //dd($cat);
        $cat = number_format($cat, 1, '.', '');
        return $cat;
    }

    private function getCATValue($total, $charge, $pay, $payments, $periods, $cat)
    {
        $i = 0;
        $value = $charge / pow((1 + ($cat / 100)), 0 / $periods);

        for ($i = 1; $i <= $payments; $i++) {
            @$value += $pay / pow((1 + ($cat / 100)), $i / $periods);
        }
        @$resTotal = $total - $value;

        return $resTotal;
    }

    private function setReferenceRate($agreement_activar_promocion_iva, $agreement_tasa_i_promocion_iva, $agreement_tasa_i_iva, $agreement_periocidad_id)
    {
        $tasa_referencia = $agreement_activar_promocion_iva == 1 ? $agreement_tasa_i_promocion_iva :   $agreement_tasa_i_iva;
        $referenceRate = $tasa_referencia / 100;
        switch ($agreement_periocidad_id) {
            case 1:
                $referenceRate = $referenceRate / 24;
                break;
            case 2:
                $referenceRate = $referenceRate / 26;
                break;
            case 3:
                $referenceRate = $referenceRate / 52;
                break;
            case 4:
                $referenceRate = $referenceRate / 12;
                break;
            default:
                $referenceRate = $referenceRate / 24;
        }

        $referenceRate = $referenceRate;
    }

    private function getRate($nper, $pmt, $pv, $fv = 0.0, $type = 0, $guess = 0.01)
    {
        try {
            // Sets default values for missing parameters
            $fv = $fv ? $fv : 0;
            $type = $type ? $type : 0;
            $guess = $guess ? $guess : 0.1;

            // Sets the limits for possible guesses to any
            // number between 0% and 100%
            $lowLimit = 0;
            $highLimit = 1;
            // Defines a tolerance of up to +/- 0.00005% of pmt, to accept
            // the solution as valid.
            $tolerance = abs(0.00000005 * $pmt);
            // Tries at most 40 times to find a solution within the tolerance.
            for ($i = 0; $i < 40; $i++) {
                // Resets the balance to the original pv.
                $balance = $pv;
                // Calculates the balance at the end of the loan, based
                // on loan conditions.
                for ($j = 0; $j < $nper; $j++) {
                    if ($type == 0) {
                        // Interests applied before payment
                        @$balance = $balance * (1 + $guess) + $pmt;
                    } else {
                        // Payments applied before insterests
                        $balance = ($balance + $pmt) * (1 + $guess);
                    }
                }
                // Returns the guess if balance is within tolerance.  If not, adjusts
                // the limits and starts with a new guess.
                @$res_balance = abs($balance + $fv);
                if ($res_balance < $tolerance) {
                    return $guess;
                } elseif ($balance + $fv > 0) {
                    // Sets a new highLimit knowing that
                    // the current guess was too big.
                    $highLimit = $guess;
                } else {
                    // Sets a new lowLimit knowing that
                    // the current guess was too small.
                    $lowLimit = $guess;
                }
                // Calculates the new guess.
                $guess = ($highLimit + $lowLimit) / 2;
            }
        } catch (\Error $e) {
            return null;
        }
        // Returns null if no acceptable result was found after 40 tries.
        return null;
    }
}