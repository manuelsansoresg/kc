@extends('layouts.admin')
@section('title', 'Acciones')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Acciones/ Respuesta de módulo</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item active"><a href="/panel/kc-check-up">KC- Check up</a>
                                            <li class="breadcrumb-item active"><a href="/panel/template/steps/{{ $model }}/{{  $history->id }}/show">Etapas</a>
                                            <li class="breadcrumb-item active"><a href="/panel/template/report/{{ $model }}/{{  $history->id }}/show">Acciones</a>
                                            <li class="breadcrumb-item active"><a
                                                    href="/panel/kc-check-up">{{ $credit->id }} - REPORTE</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    
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
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="url_report" value="{{ asset('reporte/'.$credit->id ) }}">
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <span class="preview-title-lg overline-title">Reporte:</span>
                                <hr>
                                <div class="row">
                                    <div class="col-12 col-md-2">
                                        <a class="btn btn-primary" href="{{ asset('reporte/'.$history_id ) }}" target="_blank">Ver reporte</a>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <a class="pointer btn btn-primary" onclick="copyToClipBoardReport()">Copiar URL</a>
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <a class="pointer btn btn-primary" btn btn-primary>Descargar PDF</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="history_id" value="{{ $history_id }}">
    <input type="hidden" id="refresh-dt" value="dt-lead">
@endsection
