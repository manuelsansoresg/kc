@extends('layouts.admin')
@section('title', 'Carga de archivos')
@section('content')
@php
    $is_required = config('enums.is_required');
@endphp
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-md mx-auto">
                    <div class="nk-block-head nk-block-head-lg wide-sm">
                        <div class="nk-block-head-content">
                            
                            <h3 class="nk-block-title page-title">Acción carga</h3>
                            <div class="nk-block-des text-soft">
                                <nav>
                                    <ul class="breadcrumb">
                                        @php
                                            $title = array('newCredit' => 'KC - Check up', 'debtCredit' => 'KC - Check up', 'controlDesk' => 'KC - Control desk', 'swap' => 'KC - Swap' , 'delivery' => 'KC - Delivery');
                                            $route = array('newCredit' => 'kc-check-up', 'debtCredit' => 'kc-check-up', 'controlDesk' => 'kc-control-desk', 'swap' => 'kc-swap' , 'delivery' => 'kc-delivery');
                                        @endphp
                                        <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                        <li class="breadcrumb-item active"><a href="/panel/{{ isset($route[Request::segment(4)])? $route[Request::segment(4)] : '' }}"> {{ isset($title[Request::segment(4)])? $title[Request::segment(4)] : '' }} </a>
                                        <li class="breadcrumb-item active"><a href="/panel/template/steps/{{ Request::segment(4) }}/{{  $history->id }}/show">Etapas</a>
                                        <li class="breadcrumb-item active"><a href="/panel/template/actions/{{ Request::segment(4) }}/{{  $history->id }}/show">Tareas</a>
                                        <li class="breadcrumb-item active">Acción carga
                                        </li>
                                    </ul>
                                </nav>
                                <p class="text-dark">
                                    <small>Carga documentos del cliente persona para encontrar la mejor opción de crédito</small>
                                </p>
                            </div>
                            <div class=" d-block d-md-none">
                                <div class="col-12">
                                    <span class="text-primary overline-title small">
                                        @if ($product != null)
                                            {{ $product->alias }}
                                        @endif
                                    </span>
                                </div>
                                <div class="col-12">
                                    <span class="text-primary overline-title small">
                                        @if ($credit != null)
                                            {{ $credit->id }} - {{ $client->name }} {{ $client->last_name }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-block-head-content d-none d-md-block">
                            <div class="col-12">
                                <span class="text-primary overline-title small">
                                    @if ($product != null)
                                        {{ $product->alias }}
                                    @endif
                                </span>
                            </div>
                            <div class="col-12">
                                <span class="text-primary overline-title small">
                                    @if ($credit != null)
                                        {{ $credit->id }} - {{ $client->name }} {{ $client->last_name }}
                                    @endif
                                </span>
                            </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg py-3">
                        <p>* Campos obligatorios</p>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div class="preview-block">
                                    <div class="row gy-4">
                                        <form method="post" id="frm-action-files" action="">
                                            @foreach ($files as $key => $file)
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-user-admin-name">{{ $file['is_required'] == true ? '*' : '' }} {{ $file['name']}}</label>
                                                        <p><small>{{ $file['comment'] }}</small></p>
                                                        <div class="form-control-wrap">
                                                            <div id="{{ $key}}-dropzone-action" data-max-file-size="{{ $file['max_size']}}" data-max-files="{{ $file['max_file'] }}"  data-accepted-files="{{ $file['type']}}">
                                                                <div class="dz-message" data-dz-message> 
                                                                    <span class="dz-message-text">Arrastra y suelta el archivo</span>
                                                                    <span class="dz-message-or">o</span> 
                                                                    <span
                                                                        class="dz-message-text">Haz click para elegir</span> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row content-action-preview">
                                                    <div  id="{{ $key}}-files-action-preview" class=""></div>
                                                </div>
                                                @if ($file['is_date'] === true)
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <p><small>{{ $file['comment_date'] }}</small></p>
                                                        <div class="form-control-wrap">
                                                            <input type="text" id="{{ $key}}-date_file" 
                                                            @if (isset($file['is_required']) && $file['is_required'] == true)
                                                                required
                                                            @endif
                                                            name="date_file[{{ $key }}]" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                <hr class="preview-hr">
                                            @endforeach
                                            <input type="hidden" id="action-model" name="model" value="{{ $model }}">
                                            <input type="hidden" id="action-id_rel" name="id_rel" value="{{ $credit_id }}">
                                            <input type="hidden" id="url_redirect"value="/panel/template/steps/{{ $model }}/{{ $history->id }}/show">
                                            <input type="hidden" id="step" value="{{ isset($_GET['step']) && $_GET['step']? $_GET['step'] : null }}">
            
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
