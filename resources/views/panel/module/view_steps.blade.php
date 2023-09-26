@extends('layouts.admin')
@section('title', 'Etapas')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-head-content">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-9">
                                        <h3 class="nk-block-title page-title">Etapas</h3>
                                        <div class="nk-block-des text-soft">
                                            <nav>
                                                <ul class="breadcrumb">
                                                    @if ($breadcrumb == null)
                                                        <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                                        <li class="breadcrumb-item "><a href="/panel/kc-check-up">KC - Check
                                                                up</a>
                                                        <li class="breadcrumb-item active">Etapas</li>
                                                    @else
                                                        {!! $breadcrumb !!}
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


                        </div>

                    </div>
                    <div class="nk-block nk-block-lg">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-9">
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner">
                                            <div class="row text-secondary d-none d-md-flex">
                                                <div class="col-12 col-md-1">#</div>
                                                <div class="col-12 col-md-3">Etapa</div>
                                                <div class="col-12 col-md-3">Estatus</div>
                                                <div class="col-12 col-md-3">Progreso</div>
                                                <div class="col-12 col-md-1"></div>
                                            </div>
                                            @if ($list_steps != null)

                                                @foreach ($list_steps as $key => $list_steps)
                                                    <div id="accordion" class="accordion">
                                                        <div class="accordion-item">
                                                            <a href="#" class="accordion-head"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#accordion-item-{{ $key }}">
                                                                <div class="row text-secondary">

                                                                    <div class="col-12 col-md-1"> {!! $list_steps['name'] !!}</div>
                                                                    <div class="col-12 col-md-3">{{ $list_steps['step'] }}</div>
                                                                    <div class="col-12 col-md-3">{{ $list_steps['status'] }}</div>
                                                                    <div class="col-12 col-md-3">{!! $list_steps['progress'] !!}</div>
                                                                    <div class="col-12 col-md-1"></div>
                                                                </div>
                                                                @if ($list_steps['status'] != 'En espera')
                                                                    <span class="accordion-icon"></span>
                                                                @endif
                                                            </a>
                                                            <div class="accordion-body collapse {{ $list_steps['status'] == 'En curso' ? 'show' : '' }}"
                                                                id="accordion-item-{{ $key }}"
                                                                data-bs-parent="#accordion">
                                                                <div class="accordion-inner">
                                                                    @php
                                                                        $indice = $key + 1;
                                                                        $list_actions = $indice > 0 ? (new $actionStrategy())->listActionByStep($history_id, $indice) : null;
                                                                    @endphp
                                                                    @if ($list_steps['status'] == 'En espera')
                                                                            <p>En espera de concluir las etapas en curso</p>
                                                                    @else
                                                                    <div class="table-responsive">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Acción</th>
                                                                                    <th class="d-none d-md-flex">Asunto</th>
                                                                                    <th>Estatus</th>
                                                                                    <th class="d-none d-md-flex">Deadline</th>
                                                                                    <th class="d-none d-md-flex">Responsable</th>
                                                                                    <th></th>
                                                                                </tr>
                                                                            </thead>

                                                                            @if ($list_actions != null)
                                                                                @foreach ($list_actions as $list_actions)
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>{!! $list_actions['name'] !!}</td>
                                                                                            <td class="d-none d-md-flex">{{ $list_actions['subject'] }}
                                                                                            </td>
                                                                                            <td>{{ $list_actions['status'] }}
                                                                                            </td>
                                                                                            <td class="d-none d-md-flex">{!! $list_actions['deadline'] !!}</td>
                                                                                            <td class="d-none d-md-flex">{{ $list_actions['advisor'] }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @if (isset($list_actions['link']))
                                                                                                    <a href="{{ $list_actions['link'] }}"
                                                                                                        class="btn btn-primary">Abrir</a>
                                                                                                @endif
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                @endforeach
                                                                            @endif
                                                                        </table>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
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
        </div>
    </div>
    <input type="hidden" id="history_id" value="{{ $history_id }}">
    <input type="hidden" id="model" value="{{ $model }}">
    <input type="hidden" id="refresh-dt" value="dt-lead">
@endsection
