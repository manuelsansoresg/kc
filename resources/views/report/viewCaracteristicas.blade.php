<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs">
                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                        href="#tabRequisitos">REQUISITOS</a> 
                </li>
                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                        href="#tabComisiones">COMISIONES</a> 
                </li>
                <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab"
                        href="#tabCaracteristicas">CARACTERÍSTICAS</a> 
                </li>
            </ul>
            <div class="tab-content">

                <div class="tab-pane" id="tabRequisitos">
                </div>
                <div class="tab-pane" id="tabComisiones">
                </div>

                <div class="tab-pane active" id="tabCaracteristicas">
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
        {{-- <div class="col-12">
            <span
            class="preview-title-lg overline-title text-primary ">CARACTERÍSTICAS</span>
        </div> --}}
        
</div>