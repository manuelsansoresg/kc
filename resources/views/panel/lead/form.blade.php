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

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
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

                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-body">
                                <form method="post" id="frm-lead" action="">
                                    @csrf
                                    <span class="preview-title-lg overline-title">Producto</span>
                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Organización</label>
                                                <div class="form-control-wrap">
                                                   
                                                    <select class="form-select js-select2" name="data[agreement_id]" id="lead-agreement"  data-search="on">
                                                        @if ($lead_id == null)
                                                            <option></option>
                                                        @endif

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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Producto</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="data[product_id]" id="lead-product-id"  data-search="on">
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
                                        <hr class="preview-hr">
                                        <span class="preview-title-lg overline-title">General</span>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Nombres</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="data[name]" id="lead-name">
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
                                                <label class="form-label">Celular</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="data[cellphone]"  id="lead-cellphone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Email</label>
                                                <div class="form-control-wrap">
                                                    <input type="email" class="form-control" name="data[email]" id="lead-email">
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="preview-hr">
                                        <span class="preview-title-lg overline-title">Origen</span>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Origen</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control js-select2" name="data[origin_id]" id="lead-origin"  data-search="on">
                                                        @if ($lead == null)
                                                        <option value="">Escribe para buscar</option>
                                                        @endif
                                                        @foreach ($origins as $key=>$origin)
                                                            <option value="{{ $key }}">{{ $origin }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Canal</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select js-select2" name="data[channel_id]" id="lead-channel"  data-search="on">
                                                        <option value="">Escribe para buscar</option>
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
                                        <span class="preview-title-lg overline-title">Servicio</span>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Tipo</label>
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
                                        </div>

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

                                        <input type="hidden" id="lead_id" name="lead_id"
                                            value="{{ $lead_id }}">
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    {{-- <a href="#" data-bs-dismiss="modal" class="btn btn-primary"></a> --}}
                                                    <button class="btn btn-primary">Guardar</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
