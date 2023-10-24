<div class="profile-ud-list">
@foreach ($fees as $key => $fees)

    <div class="profile-ud-item">
        <div class="profile-ud wider">
            <span class="profile-ud-label">Concepto</span>
            <span class="profile-ud-value">
                {{ $fees->concepto }}
        </div>
    </div>
    
    <div class="profile-ud-item">
        <div class="profile-ud wider">
            <span class="profile-ud-label">Periodicidad</span>
            <span class="profile-ud-value">
                {{ isset(config('enums.periodicity')[$fees->periodicidad]) ? config('enums.periodicity')[$fees->periodicidad] : null }}
        </div>
    </div>
    <div class="profile-ud-item">
        <div class="profile-ud wider">
            <span class="profile-ud-label">Moneda</span>
            <span class="profile-ud-value">
                {{ $fees->moneda == 1 ? 'Pesos' : null }}
        </div>
    </div>
    @if ($fees->type == 1)
    <div class="profile-ud-item">
        <div class="profile-ud wider">
            <span class="profile-ud-label">Valor</span>
            <span class="profile-ud-value">
                {{ $fees->valor }}
        </div>
    </div>
    @else
    <div class="profile-ud-item">
        <div class="profile-ud wider">
            <span class="profile-ud-label">Porcentaje</span>
            <span class="profile-ud-value">
                {{ $fees->porcentaje }}
        </div>
    </div>
    <div class="profile-ud-item">
        <div class="profile-ud wider">
            <span class="profile-ud-label">Referencia %</span>
            <span class="profile-ud-value">
                {{ isset(config('enums.fee_reference_percents')[$fees->referencia]) ? config('enums.fee_reference_percents')[$fees->referencia] : null }}
        </div>
    </div>
    @endif
    <div class="col-12"> 
        <hr>
    </div>
@endforeach
</div>