<?php
if (!function_exists('formatDateNameMonth')) {
    function formatDateNameMonth($date, $is_time = true)
    {
        $monhts = array('01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo',
                    '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
                    '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                );
        $format_date = date('d-m-Y H:i', strtotime($date));
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
