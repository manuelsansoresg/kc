@inject('m_financial_product', 'App\Models\FinancialProduct')
@if ($lead->cellphone_validated == 1)
<p >Validación Prospecto (celular) / {{ $lead->cellphone }} /<span class="text-primary"> OK </span></p>
@endif

@if ($creditStatus === false)
    <p >Validación otro trámite pendiente / {{ $nombreCliente }} /<span class="text-danger"> Tiene trámites pendientes </span></p>
    @else
    <p >Validación otro trámite pendiente / {{ $nombreCliente }} /<span class="text-primary"> Sin támites pendientes </span></p>
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


@php
    $isMove = true;
    $getFinancial = $m_financial_product::find($lead->financial_product_id);
    if ($getFinancial!= null && $getFinancial->type_product_id != 3) {
        $isMove = $lead->selected_loan > 0  && $lead->selected_term > 0  ?  true : false;
    }
@endphp
@if ($isMove == false)
    
    @if ($lead->selected_loan != null)
    <p>Validar Crédito Seleccionado / Plazo seleccionado / <span class="text-primary"> Seleccionado  </span> </p>
    @else
    <p>Validar Crédito Seleccionado / Plazo seleccionado / <span class="text-danger"> Sin seleccionar  </span> </p>
    @endif

    @if ($lead->selected_term != null)
    <p>Validar Crédito Seleccionado / Importe seleccionado / <span class="text-primary"> Seleccionado  </span> </p>
    @else
    <p>Validar Crédito Seleccionado / Importe seleccionado / <span class="text-danger"> Sin seleccionar  </span> </p>
    @endif
    
@endif
