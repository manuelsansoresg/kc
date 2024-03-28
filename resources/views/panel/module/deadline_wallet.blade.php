@php
    $colors = array(1 => 'warning' , 2 => 'success' , 3 => 'danger');
    $labels = array(1 => 'Revisión' , 2 => 'Exitoso' , 3 => 'Fallido');

    $color_inf = $colors[1];
    $label = $labels[1];
    if ($transaction->operation_status != null && $transaction->operation_status == 1) {
        $color_inf = $colors[2];
        $label = $labels[2];
    } elseif ($transaction->operation_status != null && $transaction->operation_status == 0) {
        $color_inf = $colors[3];
        $label = $labels[3];
    }
@endphp

<span class="badge badge-dim bg-{{ $color_inf }}">
   
    <span>{{ $label }} </span>
</span>