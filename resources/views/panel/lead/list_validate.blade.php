@if ($lead->cellphone_validated == 1)
<p >Validación Prospecto (celular) / {{ $lead->cellphone }} /<span class="text-primary"> OK </span></p>
@endif

@if ($lead->rfc_validated == true)
<p >Validación Prospecto (rfc) / {{ $lead->rfc}} /<span class="text-primary"> OK </span></p>
@endif

@if ($financialProduct->name == 'Salario On-Demand')
    @if ($clientPerson->sod_active != 0)
        
    @if ($clientPerson->sod_active == 1)
        <p>Validación Crédito Preautorizado / SOD Activo / <span class="text-danger"> <br>FAIL: Prospecto No tiene un Salario On-Demand activo</p> 
            @else
                <p>Validación Crédito Preautorizado / SOD Activo / <span class="text-danger"> <br>FAIL: Prospecto No tiene un Salario On-Demand activo</p>
    @endif

    @endif
    @if ($getSodName == null)
        <p>Validación Crédito Preautorizado / SOD en rango de fechas permitidas / <span class="text-danger"> <br>FAIL: Solicitud fuera del rango de fechas </span> <p>
        @else
        <p>Validación Crédito Preautorizado / SOD en rango de fechas permitidas / <span class="text-primary"> <br>OK: Solicitud dentro del rango de fechas </span> <p>
    @endif
@endif

@if ($lead->tramit_type != null)
    {!!  $validateSod['message'] !!}
    
@endif
