@extends('layouts.admin')
@section('title', 'Etapas')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Etapas</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            @if ($breadcrumb == null)
                                                <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                                <li class="breadcrumb-item "><a href="/panel/kc-check-up">KC- Check up</a>
                                                <li class="breadcrumb-item active">Etapas</li>
                                            @else
                                                {!!  $breadcrumb !!}
                                            @endif
                                            
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
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table id="dt-check-up-steps" class="nowrap nk-tb-list nk-tb-ulist" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Etapa</th>
                                            <th>Estatus</th>
                                            <th>Progreso</th>
                                            {{-- <th>Deadline</th> --}}
                                            <th></th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="history_id" value="{{ $history_id }}">
    <input type="hidden" id="model" value="{{ $model }}">
    <input type="hidden" id="refresh-dt" value="dt-lead">
@endsection
