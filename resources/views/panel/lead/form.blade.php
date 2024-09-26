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
                                                                   
                                                                    <select class="form-select js-select2" name="data[agreement_id]" id="lead-agreement" onchange="organizationChange(null, null, null, null)"  data-search="on" disabled>
                                                                        <option></option>
                                                                      
                
                                                                        @foreach ($agreements as $agreement)
                                                                            <option value="{{ $agreement->id }}">{{ $agreement->name }}</option>
                                                                        @endforeach
                                                                        <option value="0">Otro</option>
                                                                    </select>
                                                                </div>
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
                
                                                        <hr class="preview-hr">

                                                        <span class="preview-title-lg overline-title">Servicio KC</span>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Servicio KC</label>
                                                                <p class="small">Servicio que desea el prospecto</p>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-select js-select2" name="data[product_id]" onchange="productChange(null)" id="lead-product-id"  data-search="on">
                                                                        @if ($lead_id == null)
                                                                            <option value="">Escribe para buscar</option>
                                                                        @endif
                                                                        @foreach ($products as $product)
                                                                            <option value="{{ $product->id }}">{{ $product->alias }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="col-md-6" id="content-tipo-credito" style="display: none">
                                                            <div class="form-group">
                                                                <label class="form-label">Tipo de crédito que desea el prospecto</label>
                                                                <p class="small">Categoría de crédito</p>
                                                                <div class="form-control-wrap">
                                                                    @php
                                                                        $type_products = config('financial_enums.type_products');
                                                                    @endphp
                                                                    <select name="data[tipo_credito]" id="tipo_credito" class="form-control">
                                                                        @foreach ($type_products as $key => $type_product)
                                                                            <option value="{{$key}}">{{ $type_product }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                        </div> --}}

                                                       

                                                       

                                                        <div class="col-md-6" id="content-producto-financiero" style="display: none">
                                                            <div class="form-group">
                                                                <label class="form-label">Producto financiero</label>
                                                                <p class="small">Elige el producto financiero que desea el prospecto</p>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-select js-select2" name="data[applied_financial_product]" id="applied_financial_product">
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6" id="content-tipo_tramite" style="display: none">
                                                            <div class="form-group">
                                                                <label class="form-label">Tipo de trámite</label>
                                                                <p class="small">Elige el tipo de trámite que desea el prospecto</p>
                                                                <div class="form-control-wrap">
                                                                   <select class="form-control" name="data[applied_loan_type]" id="applied_loan_type">
                                                                    @foreach ($loan_type as $key=> $loan_type)
                                                                        <option value="{{ $key }}"> {{ $loan_type }} </option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        
                                                        <div class="col-md-6" id="content-financial_product_id" style="display: none">
                                                            <div class="form-group">
                                                                <label class="form-label">Productos financieros actuales</label>
                                                                <p class="small">Elige el producto financiero que desea el prospecto</p>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-select select2multiple" name="products[]" id="lead-financial-product-id" multiple="multiple"  data-search="on">
                                                                        <option value="">Escribe para buscar</option>
                                                                        @foreach ($financial_products as $financial_product)
                                                                            <option value="{{ $financial_product->id }}">{{ $financial_product->commercial_name}} - {{ $financial_product->alias }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6" id="content-importe-solicitado" style="display: none">
                                                            <div class="form-group">
                                                                <label class="form-label">Importe solicitado</label>
                                                                <p class="small">Cantidad de dinero que necesita el prospecto</p>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[importe_solicitado]" id="importe_solicitado">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6" id="content-ingreso-mensual" >
                                                            <div class="form-group">
                                                                <label class="form-label">Ingreso mensual</label>
                                                                <p class="small">Neto aproximado</p>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[income]" id="income">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6" id="content-banco_nomina" >
                                                            <div class="form-group">
                                                                <label class="form-label">Banco nómina </label>
                                                                <p class="small">Banco en el que recibe su nómina</p>
                                                                <div class="form-control-wrap">
                                                                    <select name="data[bank_id]" id="bank_id" class="form-control">
                                                                        <option value="">Seleccione una opción</option>
                                                                        @foreach ($banks as $bank)
                                                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <div class="col-md-6" id="content-consulta-buro-credito" style="display: none">
                                                            <div class="form-group">
                                                                <label class="form-label">Consulta buró de crédito</label>
                                                                <p class="small">Seleccionar si el prospecto desea consulta en el buró</p>
                                                                <div class="form-control-wrap">
                                                                    <select name="data[consulta_buro]" id="consulta_buro" class="form-control">
                                                                        <option value="">Seleccione una opción</option>
                                                                        <option value="1">Sí</option>
                                                                        <option value="0">No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $status_si_no = config('enums.status_si_no');
                                                        @endphp
                                                        <div class="col-md-6" id="content-aval-o-garantia" style="display: none">
                                                            <div class="form-group">
                                                                <label class="form-label">Aval o garantía</label>
                                                                <p class="small">Selecciona si el prospecto proporcionaría aval o garantía</p>
                                                                <div class="form-control-wrap">
                                                                    <select name="data[aval_o_garantia]" id="aval_o_garantia" class="form-control">
                                                                        @foreach ($status_si_no as $key_aval_garantia => $aval_garantia)
                                                                            <option value="{{ $key_aval_garantia }}">{{ $aval_garantia }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr class="preview-hr">
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
                
                                                        <input type="hidden" id="lead_id" name="lead_id" value="{{ $lead_id }}">
                                                        <input type="hidden" id="isValidateCellphone"  value="false">
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
