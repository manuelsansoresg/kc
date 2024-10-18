@extends('layouts.admin')
@section('title', 'Formulario prospecto')

@inject('m_agreement', 'App\Models\Agreement')
@inject('product', 'App\Models\Product')
@inject('user', 'App\Models\User')

@section('content')


    @php
    $agreements   = $m_agreement->getAllActive();
    $products     = $product->getAll();
    $origins      = config('enums.origin');
    $advisors     = $user->getUserRole('Asesor');
    $temperatures = config('enums.temperatures');
    $user         = Auth::user();
    $types        = config('enums.type_lead');
    @endphp
         <div class="nk-content">
            <div class="container-fluid">
                <div class="nk-content-inner">
                    <div class="nk-content-body">
                        <div class="components-preview wide-md mx-auto">
                            <div class="nk-block-head nk-block-head-lg wide-sm">
                                <div class="nk-block-head-content">
                                    
                                    <h3 class="nk-block-title page-title">Prospecto</h3>
                                    <div class="nk-block-des text-soft">
                                        <nav>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                                <li class="breadcrumb-item">Configuración</li>
                                                <li class="breadcrumb-item active"><a href="/panel/lead">Prospecto</a></li>
                                            </ul>
                                        </nav>
                                        
                                    </div>
                                   
                                </div>
                               
                            </div><!-- .nk-block-head -->
                            <div class="nk-block nk-block-lg ">
                                <p>* Campos obligatorios</p>
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                        <div class="preview-block">
                                            <div class="row gy-4">
                                                <form method="post" id="frm-lead" action="">
                                                    @csrf
                                                    <div class="row gy-4">
                                                        <span class="preview-title-lg overline-title">General</span>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Celular</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[cellphone]"  id="lead-cellphone" onchange="checkDataLeadExist(this, 'cellphone')">
                                                                    <label id="cellphone-msg" class="text-danger"></label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">*Nombres</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[name]" id="lead-name" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Primer apellido</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[last_name]"  id="lead-last_name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Segundo apellido</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[second_last_name]"  id="lead-second_last_name">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Fecha de nacimiento</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="date" class="form-control" name="data[birth_date]" id="lead-birth_date" onchange="createRfc()">
                                                                    <label id="birth_date-msg" class="text-danger"></label>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">*RFC</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[rfc]" minlength="10" id="lead-rfc"  required>
                                                                    <label id="rfc-msg" class="text-danger"></label>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                     
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Email</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="email" class="form-control" name="data[email]" id="lead-email" >
                                                                    <label id="email-msg" class="text-danger"></label>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Organización</label>
                                                                <p class="small">Institución o empresa donde labora el prospecto</p>
                                                                <div class="form-control-wrap">
                                                                   
                                                                    <select class="form-select js-select2"  id="lead-agreement" onchange="organizationChange(null, null, null, null)"  data-search="on" disabled>
                                                                        <option></option>
                                                                      
                
                                                                        @foreach ($agreements as $agreement)
                                                                            <option value="{{ $agreement->id }}">{{ $agreement->name }}</option>
                                                                        @endforeach
                                                                        <option value="0">Otro</option>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" name="data[agreement_id]" id="lead-origin-agreement" value="">
                                                            </div>
                                                            <div class="form-group" id="lead-content-agreement" style="display: none">
                                                                <label class="form-label">Otra organización</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="new_agreement" id="new_agreement">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                      
                                                        @if ($lead_id != null)
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">ID Manychat</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[manychat_id]" id="lead-manychat_id">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Prospecto válido</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="prospecto-valido" disabled>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                
                                                        

                                                       <div id="content-servicio-kc" style="display: none" class="mt-5">
                                                            <span class="preview-title-lg overline-title">Servicio KC <a href="" target="_blank" class="perfil-cliente ml-5">Perfíl del cliente</a> <i class="fas fa-external-link-alt"></i> </span>
                                                            <div class="col-12 mt-n4">
                                                                <hr class="preview-hr">
                                                            </div>
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Producto financiero</label>
                                                                        <p class="small">Servicio KC</p>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select js-select2" name="data[financial_product_id]" id="financial_product_id"  data-search="on" onchange="validateSoad()">
                                                                            
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6" id="content_tramit_type" style="display: none">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Tipo de trámite</label>
                                                                        <p class="small">&nbsp;</p>
                                                                        <div class="form-control-wrap">
                                                                            <select name="data[tramit_type]" id="tramit_type" class="form-control js-select2" data-search="on" onchange="changeTramite()"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="content-product-select" style="display: none">

                                                                <span class="preview-title-lg overline-title mt-5">Producto Preautorizado <a href="" target="_blank" class="perfil-cliente ml-5">Perfíl del cliente</a> <i class="fas fa-external-link-alt"></i> </span>
                                                                <div class="col-12 mt-n4">
                                                                    <hr class="preview-hr">
                                                                    <div id="content-error-producto-preautorizado" style="display: none">
                                                                        <span class="text-danger">No se puede realizar ningún trámite, revisa las validaciones.</span>
                                                                    </div>
                                                                    <div class="row" style="display: none" id="content-refinanciado">
                                                                        <div class="col-md-6 mt-3">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Monto máximo</label>
                                                                                
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" class="form-control" id="monto-maximo"  disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Plazo máximo</label>
                                                                                
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" class="form-control" id="plazo-maximo"  disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Periodicidad</label>
                                                                                
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" class="form-control" id="periodicidad"  disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Pago periodico</label>
                                                                                
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" class="form-control" id="pago-periodico"  disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div id="content-product"></div>
                                                                    <div class="row" id="producto-deseado" style="display: none">
                                                                        <div class="col-12 mt-5">
                                                                            <span class="preview-title-lg overline-title">Producto deseado <a href="" target="_blank" class="perfil-cliente ml-5">Perfíl del cliente</a> <i class="fas fa-external-link-alt"></i> </span>
                                                                            <div class="col-12 mt-1">
                                                                                <label for="customRange3" class="form-label">¿Cuanto deseas retirar?</label>
                                                                                <input type="range" class="form-range" min="0" max="5" step="100" id="slider">
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-12 col-md-6">$<span id="valor-minimo"></span> </div>
                                                                                <div class="col-12 col-md-6 text-start text-md-end">$<span id="valor-maximo"></span></div>
                                                                            </div>
                                                                            <div class="row mt-4">
                                                                                <div class="col-12">
                                                                                    <p class="h6">RESUMEN:</p>
                                                                                    <p>Monto a retirar : <span id="valor-slider" class="fw-bold">$15,000</span> <br>
                                                                                    Comisión : <span id="valor-comision" class="fw-bold">$46.40</span> <br>
                                                                                    Total a pagar : <span id="valor-total" class="fw-bold">$1,546</span> <br>
                                                                                    Banco : <span id="valor-banco" class="fw-bold"></span> <br>
                                                                                    Cuenta : <span id="valor-cuenta" class="fw-bold">*********12</span> <br>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                   </div>
                                                                </div>
                                                            </div>
                                                          
                                                        </div>
                                                        
                                                        <div id="product-deseado-refinanciamiento" style="display: none">

                                                            <span class="preview-title-lg overline-title mt-5">Producto deseado <a href="" target="_blank" class="perfil-cliente ml-5">Perfíl del cliente</a> <i class="fas fa-external-link-alt"></i> </span>
                                                            <div id="content-product-deseado-refinanciamiento"></div>
                                                        </div>
                                                       

                                                        <span class="preview-title-lg overline-title">Viabilidad</span>
                                                        <p class="text-primary">Este prospecto es <span class="text-viabilidad"></span>  </p>
                                                       {{--  <div class="col-md-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input" name="data[is_viability]" type="checkbox" value="1" id="is_viability">
                                                                <label class="" for="is_viability">Viabilidad como <span class="text-viabilidad"></span> </label>
                                                                
                                                            </div>
                                                        </div> --}}
                                                        <input type="hidden" name="data[is_viability]" id="is_viability">
                                                        <div class="col-md-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input" name="data[is_viability_credit]" type="checkbox" value="1" id="is_viability_credit">
                                                                <label class="" for="is_viability_credit">Viabilidad de crédito </label>
                                                                
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="isExport" name="isExport" value="false">
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-primary" onclick="saveAndExportLead()">Guardar y exportar datos</button>
                                                        </div>
                                                        
                                                        
                                                        <div class="col-md-6" id="content-comment" style="display: none">
                                                            <div class="form-group">
                                                                <label class="form-label">Comentario</label>
                                                                <p class="small">Describe la asesoría proporcionada al prospecto</p>
                                                                <div class="form-control-wrap">
                                                                    <textarea name="data[comment]" id="lead-comment" cols="5" rows="3" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                        <hr class="preview-hr">
                                                        
                                                        <span class="preview-title-lg overline-title">Origen</span>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">*Origen</label>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-control"  data-search="on" disabled>
                                                                        @if ($lead == null)
                                                                        <option value="">Escribe para buscar</option>
                                                                        @endif
                                                                        @foreach ($origins as $key=>$origin)
                                                                            <option value="{{ $key }}" {{ $lead === null && $key == 1  ? 'selected' : null }} {{ $lead != null && $lead->origin_id == $key ? 'selected' : null  }} >{{ $origin }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="data[origin_id]" value="1" id="lead-origin">
                                                                    <input type="hidden" id="lead-origin-admin">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">*Canal</label>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-select js-select2" name="data[channel_id]" id="lead-channel"  data-search="on">
                                                                        <option></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Asesor</label>
                                                                <div class="form-control-wrap">
                                                                    @if ($user->hasRole('Asesor') == true)
                                                                        <select class="form-select" name="data[asesor_id]" id="lead-asesor-id"  data-search="on" disabled>
                                                                            @foreach ($advisors as $advisor)
                                                                                <option value="{{ $advisor->id }}" {{ ($user->id == $advisor->id)? 'selected' : '' }} >{{ $advisor->name }} {{ $advisor->last_name }} {{ $advisor->second_last_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @else
                                                                        <select class="form-select js-select2" name="data[asesor_id]" id="lead-asesor-id"  data-search="on">
                                                                            <option></option>
                                                                            @foreach ($advisors as $advisor)
                                                                                <option value="{{ $advisor->id }}">{{ $advisor->name }} {{ $advisor->last_name }} {{ $advisor->second_last_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    @endif
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="preview-hr">
                                                        <span class="preview-title-lg overline-title">Atención</span>
                                                       {{--  <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Atención</label>
                                                                <p class="small"> Tipo de atención que desea el prospecto</p>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-select js-select2" name="data[type_id]" id="lead-type_id"  data-search="on">
                                                                        @if ($lead == null)
                                                                            <option value="">Escribe para buscar</option>
                                                                        @endif
                                                                        @foreach ($types as $key=>$type)
                                                                            <option value="{{ $key }}">{{ $type }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                
                                                        <hr class="preview-hr">
                                                        <span class="preview-title-lg overline-title">Etiquetas</span>
                
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Temperatura</label>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-select js-select2" name="data[temperature_id]" id="lead-temperature-id"  data-search="on">
                                                                        @foreach ($temperatures as $key=> $temperature)
                                                                            <option value="{{ $key }}">{{ $temperature}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr class="preview-hr">
                                                        <span class="preview-title-lg overline-title">Validaciónes</span>
                                                        <div id="content-validaciones"></div>
                                                        <div id="content-validaciones-soad"></div>
                                                        <div id="content-validaciones-soad-date"></div>
                                                        <div id="content-validaciones-soad-tramite"></div>
                
                                                        <input type="hidden" id="lead_id" name="lead_id" value="{{ $lead_id }}">
                                                        <input type="hidden" id="isValidateCellphone"  value="false">
                                                        <input type="hidden" name="isNew" value="{{ $isNew }}">
                                                        <input type="hidden" name="data[client_person_id]" id="client_person_id" value="{{ $clientPersonId }}">
                                                        <input type="hidden" name="data[is_free_of_active_sod]" id="is_free_of_active_sod" value="{{ $lead != null ? $lead->client_person_id : null}}">
                                                        <input type="hidden" name="data[is_sod_on_date_allowed]" id="is_sod_on_date_allowed" value="{{ $lead != null ? $lead->is_sod_on_date_allowed : null}}">
                                                        <input type="hidden" name="data[sod_max]" id="sod_max" value="{{ $lead != null ? $lead->sod_max : null}}">
                                                        <input type="hidden" name="data[sod_min]" id="sod_min" value="{{ $lead != null ? $lead->sod_min : null}}">
                                                        <input type="hidden" name="data[sod_withdraw_amount]" id="sod_withdraw_amount" value="{{ $lead != null ? $lead->sod_withdraw_amount : null}}">
                                                        <input type="hidden" name="data[sod_commision_amount]" id="sod_commision_amount" value="{{ $lead != null ? $lead->sod_commision_amount : null}}">
                                                        <input type="hidden" name="data[sod_total_payment]" id="sod_total_payment" value="{{ $lead != null ? $lead->sod_total_payment : null}}">
                                                        <div class="col-12">
                                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                <li>
                                                                    {{-- <a href="#" data-bs-dismiss="modal" class="btn btn-primary"></a> --}}
                                                                    <button class="btn btn-primary" id="btnSave">Guardar</button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-preview -->
                               
                            </div><!-- .nk-block -->
                           
                        </div><!-- .components-preview -->
                    </div>
                </div>
            </div>
        </div>
@endsection
