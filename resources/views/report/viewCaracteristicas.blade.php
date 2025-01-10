<div class="container">
    <div class="row">
        <div class="col-12">
            @php
                $section = isset($_GET["section"])? $_GET["section"] : 'tramite';
            @endphp
            <ul class="nav nav-tabs">
                <li class="nav-item" id="tabTramite"> <a class="nav-link {{ $section == 'tramite' ? 'active' : null }}" data-bs-toggle="tab"
                        href="#tabTramite">TRÁMITE</a> 
                </li>
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

                <div class="tab-pane  {{ $section == 'tramite' ? 'active' : null }}" id="tabTramite">
                    <div class="container">
                        <div class="row mt-3">
                            {!! $tramite != 0 ? $tramite : null !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane  {{ $section == 'requisitos' ? 'active' : null }}" id="tabRequisitos">
                    <div class="container">
                        <div class="row mt-3">
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Tipo de persona</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['tipo_persona'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Edad</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['edad'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Antiguedad laboral</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['antiguedad_laboral'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Antiguedad residencial</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['antiguedad_residencial'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Ingreso minimo mensual</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['ingreso_minimo'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Buen historial crediticio</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['buen_historial_crediticio'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Aval o garantía</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['aval_garantia'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Recibir sueldo en cuenta de nómina</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['recibir_sueldo_nomina'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Identificación oficial vigente</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['identificacion_oficial_vig'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Comprobante de domicilio</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['comprobante_domicilio'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Comprobante de ingresos</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['comprobante_ingresos'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Documentacion complementaria</span>
                                <span class="profile-ud-value">
                                    {{ $requisitos['doc_complementaria'] }}
                                </span>
                            </div>
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
                                        <p class="mt-1">{{ $fees->concepto }} - ${{ format_price($fees->valor) }} {{ isset(config('enums.periodicity_comision')[$fees->periodicidad]) ? config('enums.periodicity_comision')[$fees->periodicidad] : null }}</p>
                                    @else
                                        <p class="mt-1">{{ $fees->concepto }} - {{ $fees->porcentaje }}% {{ $fees->referencia }} {{ isset(config('enums.periodicity_comision')[$fees->periodicidad]) ? config('enums.periodicity_comision')[$fees->periodicidad] : null }}</p>
                                    @endif
                                    
                                @endforeach
                            </div>
                            <div class="col-12 mt-3">
                                <span class="text-primary h6">COMISIONES</span>
                            </div>
                            <div class="col-12">
                               
                                @foreach ($fees_result as $key_comision => $fees_comision)
                                    @if ($fees_comision->type == 1)
                                        <p class="mt-1">{{ $fees_comision->concepto }} - ${{ format_price($fees_comision->valor) }} {{ isset(config('enums.periodicity_comision')[$fees_comision->periodicidad]) ? config('enums.periodicity_comision')[$fees_comision->periodicidad] : null }}</p>
                                    @else
                                        <p class="mt-1">{{ $fees_comision->concepto }} - {{ $fees_comision->porcentaje }}% {{ $fees_comision->referencia }} {{ isset(config('enums.periodicity_comision')[$fees_comision->periodicidad]) ? config('enums.periodicity_comision')[$fees_comision->periodicidad] : null }}</p>
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
                                <span class="profile-ud-label fw-bold text-primary">Colateral (Garantía):</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['colateral'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Periodicidad:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['periodicidad'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Monto máximo de crédito:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['max_loan_ammount'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Monto minimo del crédito:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['min_loan_amount'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Plazo mínimo en meses:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['min_deadline_month'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Plazo máximo en meses:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['max_deadline_month'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Tipo de interés:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['type_interest'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Tasa de interés mínima anual con IVA:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['minimum_interest_rate'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">tasa de interés máxima anual con IVA:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['annual_int_rate_iva'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Medio de pago:</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['payment'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Tiempo de resolución en horas
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['resolution_time_hours'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Tiempo de entrega en horas
                    
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['delivery_time_hours'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Tasa de interés moratoria con IVA
                    
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['moratorium_int_rate_vat'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Medios y canales de disposición
                    
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['means_channels_of_disposal'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Cobertura
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['coverage'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Destino del crédito
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['purpose_of_loan'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Alcance  o  beneficios
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['alcance_beneficios'] }}
                                </span>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <span class="profile-ud-label fw-bold text-primary">Restricciones o exclusiones
                                    :</span>
                                <span class="profile-ud-value">
                                    {{ $caracteristicas['restriccion_exclusion'] }}
                                </span>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- <div class="col-12">
            <span
            class="preview-title-lg overline-title text-primary ">CARACTERÍSTICAS</span>
        </div> --}}
        
</div>