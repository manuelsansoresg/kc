@php
    $bgBadge = $status == 'En curso' &&  $status != 'Opcional' ? 'bg-warning' : 'bg-success';
    $bgBadge = $status == 'Opcional' ? 'bg-secondary' : $bgBadge;
@endphp

<span class="badge badge-dim {{ $bgBadge }}">
    <span>{{ $status }} </span>
</span>