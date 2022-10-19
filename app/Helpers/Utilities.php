<?php
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
        $year           = substr($format_date, 6, 4);
        
        $new_date =$day.$month.'-'.$year_hour;

        if ($is_time == false) {
            $new_date =$day.$month.'-'.$year;
        }
        return $new_date;
    }
}


if (!function_exists('deadline')) {
    function deadline($date_init, $max_hour, $percent, $color)
    {
        $date_init = strtotime($date_init);//fecha inicial
        $date_fin = strtotime(date('Y-m-d H:i:s'));//fecha de cierre
        $hour = abs($date_init - $date_fin)/3600;
        $rest = 0;
        if ($hour < $max_hour) {
            $rest_hour   = explode('.', $max_hour - $hour);
            $rest       = isset($rest_hour[0])? $rest_hour[0] : $rest_hour;
        }

        //dd($max_hour, $hour, $rest);
        $lbl_hour   = '';
        $color      = 'success';

        $lbl_hour = '- '.$rest.' Horas';
        if ($percent === 100) {
            $lbl_hour = 'Concluido';
            $color      = 'success';
        } else {
            if ($rest == 0) { //*deadline end
                $lbl_hour = 'Vencido';
                $color      = 'danger';
            } else {
                if ($hour > 5) {
                    $color = ($hour >= $max_hour) ? 'danger' : 'warning';
                }
            }
        }

        $data = array('hour' => $hour, 'color' => $color, 'lbl_hour' => $lbl_hour);
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