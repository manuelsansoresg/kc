<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informacion</title>
</head>
<body>
    <table class="table">
       <tbody>
        <tr>
            <td colspan="2"> <b>REQUISITOS</b> </td>
        </tr>
        <tr>
            <td>Tipo de persona</td>
            <td>{{ $requisitos['tipo_persona'] }}</td>
        </tr>
        <tr>
            <td>Edad</td>
            <td>{{ $requisitos['edad'] }}</td>
        </tr>
        <tr>
            <td>Antiguedad laboral</td>
            <td>{{ $requisitos['antiguedad_laboral'] }}</td>
        </tr>
        <tr>
            <td>Antiguedad residencial</td>
            <td>{{ $requisitos['antiguedad_residencial'] }}</td>
        </tr>
        <tr>
            <td>Ingreso minimo mensual</td>
            <td>{{ $requisitos['ingreso_minimo'] }}</td>
        </tr>
        <tr>
            <td>Buen historial crediticio</td>
            <td>{{ $requisitos['buen_historial_crediticio'] }}</td>
        </tr>
        <tr>
            <td>Aval o garantía</td>
            <td>{{ $requisitos['aval_garantia'] }}</td>
        </tr>
        <tr>
            <td>Recibir sueldo en cuenta de nómina</td>
            <td>{{ $requisitos['recibir_sueldo_nomina'] }}</td>
        </tr>
        <tr>
            <td>Identificación oficial vigente</td>
            <td>{{ $requisitos['identificacion_oficial_vig'] }}</td>
        </tr>
        <tr>
            <td>Comprobante de domicilio</td>
            <td>{{ $requisitos['comprobante_domicilio'] }}</td>
        </tr>
        <tr>
            <td>Comprobante de ingresos</td>
            <td>{{ $requisitos['comprobante_ingresos'] }}</td>
        </tr>
        <tr>
            <td>Documentacion complementaria</td>
            <td>{{ $requisitos['doc_complementaria'] }}</td>
        </tr>
       </tbody>
    </table>
   
</body>
</html>
{{-- <div class="container">
    <div class="row">
        <div class="col-12">
           
            <ul class="nav nav-tabs">
                <li class="nav-item"> <a class="nav-link {{ $section == 'requisitos' ? 'active' : null }}" data-bs-toggle="tab"
                        href="#tabRequisitos">REQUISITOS</a> 
                </li>
                <li class="nav-item"> <a class="nav-link {{ $section == 'comisiones' ? 'active' : null }}" data-bs-toggle="tab"
                        href="#tabComisiones">COMISIONES</a> 
                </li>
                <li class="nav-item"> <a class="nav-link {{ $section == 'caracteristicas' ? 'active' : null }}" data-bs-toggle="tab"
                        href="#tabCaracteristicas">CARACTERÍSTICAS</a> 
                </li>
            </ul>
            <div class="tab-content">

                <div class="tab-pane  {{ $section == 'requisitos' ? 'active' : null }}" id="tabRequisitos">
                    <div class="container">
                        <div class="row mt-3">
                            
                        </div>
                    </div>
                </div>
                <div class="tab-pane {{ $section == 'comisiones' ? 'active' : null }}" id="tabComisiones">
                    <div class="container">
                        <div class="row mt-3">
                            <div class="col-12">
                                <span class="text-primary h6">COSTOS DE CONTRATACIÓN</span>
                            </div>
                            <div class="col-12 mt-3">
                                @foreach ($fees_comision as $key => $fees)
                                    @if ($fees->type == 1)
                                        <p class="mt-1">{{ $fees->concepto }} - ${{ format_price($fees->valor) }} {{ isset(config('enums.periodicity')[$fees->periodicidad]) ? config('enums.periodicity')[$fees->periodicidad] : null }}</p>
                                    @else
                                        <p class="mt-1">{{ $fees->concepto }} - {{ $fees->porcentaje }}% {{ $fees->referencia }} {{ isset(config('enums.periodicity')[$fees->periodicidad]) ? config('enums.periodicity')[$fees->periodicidad] : null }}</p>
                                    @endif
                                    
                                @endforeach
                            </div>
                            <div class="col-12 mt-3">
                                <span class="text-primary h6">COMISIONES</span>
                            </div>
                            <div class="col-12">
                               
                                @foreach ($fees_result as $key_comision => $fees_comision)
                                    @if ($fees_comision->type == 1)
                                        <p class="mt-1">{{ $fees_comision->concepto }} - ${{ format_price($fees_comision->valor) }} {{ isset(config('enums.periodicity')[$fees_comision->periodicidad]) ? config('enums.periodicity')[$fees_comision->periodicidad] : null }}</p>
                                    @else
                                        <p class="mt-1">{{ $fees_comision->concepto }} - {{ $fees_comision->porcentaje }}% {{ $fees_comision->referencia }} {{ isset(config('enums.periodicity')[$fees_comision->periodicidad]) ? config('enums.periodicity')[$fees_comision->periodicidad] : null }}</p>
                                    @endif   
                                @endforeach
                                        
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane {{ $section == 'caracteristicas' ? 'active' : null }}" id="tabCaracteristicas">
                    <div class="container">
                        <div class="row mt-3">
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Colateral (Garantía):</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['colateral'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Periodicidad:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['periodicidad'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Monto máximo de crédito:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['max_credit_amount'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Monto minimo del crédito:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['min_loan_amount'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Plazo mínimo en meses:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['min_deadline_month'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Plazo máximo en meses:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['max_deadline_month'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Tipo de interés:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['type_interest'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Tasa de interés mínima anual con IVA:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['minimum_interest_rate'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">tasa de interés máxima anual con IVA:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['annual_int_rate_iva'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Medio de pago:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['payment'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Tiempo de resolución en horas
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['resolution_time_hours'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Tiempo de entrega en horas
                    
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['delivery_time_hours'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Tasa de interés moratoria con IVA
                    
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['moratorium_int_rate_vat'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Medios y canales de disposición
                    
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['means_channels_of_disposal'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Cobertura
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['coverage'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Destino del crédito
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['purpose_of_loan'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Alcance  o  beneficios
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['alcance_beneficios'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Restricciones o exclusiones
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['restriccion_exclusion'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Programas de educacion financiera
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['programa_educacion_financiera'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold">Referencias corporativas
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['referencia_comparativa'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    
        
</div> --}}