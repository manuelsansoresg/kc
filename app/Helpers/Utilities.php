<?php

use Carbon\Carbon;

if (!function_exists('formatDateNameMonth')) {
    function formatDateNameMonth($date, $is_time = true)
    {
        $monhts = array('01' => 'Ene', '02' => 'Feb', '03' => 'Mar', '04' => 'Abr', '05' => 'May',
                    '06' => 'Jun', '07' => 'Jul', '08' => 'Ago', '09' => 'Sep',
                    '10' => 'Oct', '11' => 'Nov', '12' => 'Dic'
                );
        $format_date = date('d-m-y h:i a', strtotime($date));
        $day = substr($format_date, 0, 3);
        $month  = $monhts[substr($format_date, 3, 2)];
        $year_hour           = substr($format_date, 6);
        $year           = substr($format_date, 6, 3);
        
        $new_date =$day.$month.'-'.$year_hour;

        if ($is_time == false) {
            $new_date =$day.$month.'-'.$year;
        }
        return $new_date;
    }
}


if (!function_exists('deadline')) {
    function deadline($date_init, $max_hour, $percent, $color, $show_max_hour = false)
    {

        $fecha1 = new DateTime($date_init);//fecha inicial
        $fecha2 = new DateTime(date('Y-m-d H:i:s'));//fecha de cierre
        $intervalo = $fecha1->diff($fecha2);
        $hour = $intervalo->format('%h');
        $day = $intervalo->format('%d');
        $total_hours = $intervalo->days * 24 + $intervalo->h; // Total de horas


        $lbl_hour   = '';
        $color      = 'success';
        $rest_hour = $hour - $max_hour;
        $lbl_hour = $rest_hour.' Horas';
        
        if ($percent === 100) {
            $lbl_hour = 'Concluido';
            $color      = 'success';
        } else {
            if ($total_hours > $max_hour) { //*deadline end
                $lbl_hour = 'Vencido';
                $color      = 'danger';
            } elseif ($hour == 0 && $day == 0) {
                $rest_hour = $max_hour;
            } else {
                if ($hour > 5) {
                    $color = ($hour >= $max_hour) ? 'danger' : 'warning';
                }
            }
        }
        if ($show_max_hour == true) {
            $lbl_hour = $hour;
        }

        

        if ($day > 0 && $max_hour == '24') { //validar si es 24 horas
            $lbl_hour = 'Vencido';
            $color      = 'danger';
        }

        $data = array('hour' => $hour, 'color' => $color, 'lbl_hour' => $lbl_hour, 'day' => $day);
        return $data;
    }
}

if (!function_exists('deadlineKc')) {
    function deadlineKc($date_init, $max_hour)
    {
        $date_init = strtotime($date_init);//fecha inicial
        $date_fin = strtotime(date('Y-m-d H:i:s'));//fecha de cierre
        $hour = abs($date_init - $date_fin)/3600;
        $rest = 0;
        if ($hour < $max_hour) {
            $rest_hour   = explode('.', $max_hour - $hour);
            $rest       = isset($rest_hour[0])? $rest_hour[0] : $rest_hour;
        }
        //dd($date_init, $date_fin, $max_hour, $hour, $rest);
        $lbl_hour   = '';
        $color      = 'success';

        $lbl_hour = '- '.$rest.' Horas';
        if ($rest == 0) { //*deadline end
            $lbl_hour = 'Vencido';
            $color      = 'danger';
        } else {
            if ($hour > 15) {
                $color = ($hour >= $max_hour) ? 'danger' : 'warning';
            }
        }

        $data = array('hour' => $hour, 'color' => $color, 'lbl_hour' => $lbl_hour);
        return $data;
    }
}
if (!function_exists('format_price')) {
    function format_price($price)
    {
        if (!$price || !is_numeric($price)) {
            return 0;
        }

        return number_format($price, 2, '.', ',');
    }
}

if (!function_exists('reduceDecimal')) {
    function reduceDecimal($number, $max_decimal = 2)
    {
        // Primero, verificamos si el número contiene un punto decimal
        if (strpos($number, '.') !== false) {
            // Divide el número en la parte entera y la parte decimal
            list($integerPart, $decimalPart) = explode('.', $number);
            
            // Asegurémonos de que la parte decimal no sea más larga de lo que se permite
            $decimalPart = substr($decimalPart, 0, $max_decimal);
            
            // Combina la parte entera y la parte decimal con un punto
            $newNumber = $integerPart . '.' . $decimalPart;
        } else {
            // Si no hay punto decimal, simplemente devolvemos el número original
            $newNumber = $number;
        }

        return $newNumber;
    }
}


if (!function_exists('timeRest')) {
    function timeRest($start_date, $start_time)
    {
        $now = Carbon::now();
        // Combina la fecha y la hora en un solo objeto Carbon
        $combinedDateTime = Carbon::parse($start_date . ' ' . $start_time);

        // Calcula el tiempo restante
        $diff = $combinedDateTime->diff($now);

        // Obtiene el número de días, horas, minutos y segundos restantes
        $dias = $diff->days;
        $horas = $diff->h;

        return "Faltan {$dias} días y {$horas} horas";
    }
}

