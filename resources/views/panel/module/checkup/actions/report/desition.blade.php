@extends('layouts.admin')
@section('title', 'Acciones')
@inject('financial', 'App\Models\Financial')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Acciones/ Decisión</h3>
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
                                    <p class="mt-2">Selecciona la desicíon del cliente.</p>
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
                                <span class="preview-title-lg overline-title">Tramitar crédito con:</span>
                                <hr>
                                <div class="row">
                                    @php
                                        $values_type = array(1 => 1 , 2 => 2);
                                        $type = isset($_GET['type']) && $values_type[$_GET['type']] ? $_GET['type'] : 1;
                                    @endphp
                                    @if ($financials != null)
                                        @foreach ($financials as $get_financial)
                                        @php
                                            $financial = $get_financial->financial;
                                        @endphp
                                        <div class="col-12 col-md-2">
                                            <a class="pointer btn btn-primary mt-3" onclick="desition({{ $credit->id }}, {{ $financial->id }}, {{ $type }})" target="_blank">{{ $financial->commercial_name }}</a>
                                        </div>
                                        @endforeach
                                    @endif
                                   
                                  
                                    
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
