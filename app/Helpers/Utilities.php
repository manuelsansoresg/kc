<?php
if (!function_exists('formatDateNameMonth')) {
    function formatDateNameMonth($date, $is_time = true)
    {
        $monhts = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo',
                    '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
                    '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                );
        $format_date = date('d-m-Y h:i a', strtotime($date));
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
        $date_init = new DateTime($date_init);//fecha inicial
        $date_fin = new DateTime();//fecha de cierre
        $interval = $date_init->diff($date_fin);
        $hour = $interval->format('%H');
        $rest = 0;
        if ($hour < $max_hour) {
            $rest       = $max_hour - $hour;
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
        $date_init = new DateTime($date_init);//fecha inicial
        $date_fin = new DateTime();//fecha de cierre
        $interval = $date_init->diff($date_fin);
        $hour = $interval->format('%H');
        $rest = 0;
        if ($hour < $max_hour) {
            $rest       = $max_hour - $hour;
        }

        //dd($max_hour, $hour, $rest);
        $lbl_hour   = '';
        $color      = 'success';

        $lbl_hour = '- '.$rest.' Horas';
        if ($rest == 0) { //*deadline end
            $lbl_hour = 'Vencido';
            $color      = 'danger';
        } else {
            if ($hour > 18) {
                $color = ($hour >= $max_hour) ? 'danger' : 'warning';
            }
        }

        $data = array('hour' => $hour, 'color' => $color, 'lbl_hour' => $lbl_hour);
        return $data;
    }
}
