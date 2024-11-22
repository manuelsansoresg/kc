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
                                    <div class="col-12">
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
                                                @if ($credit != null)
                                                    <a href="/panel/credit/{{ $credit->id }}">{{ $credit->id }} - {{ $client->name }} {{ $client->last_name }} <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-12">
                                            <span class="text-primary small">
                                                @if ($product != null)
                                                    {{ $product->alias }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="nk-block nk-block-lg">
                        <div class="container">
                            <div class="row ">
                                {{-- nuevo diseño --}}
                                <div class="col-12 col-md-8">
                                    <div id="accordion" class="accordion mt-2">
                                        <div class="accordion-item">
                                            <a href="#" class="accordion-head"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accordion-item-documentos">
                                                <div class="row text-secondary">

                                                    <div class="col-12 col-md-2  text-primary fw-bold fs-6 d-flex align-items-center"> Captura info 
                                                        
                                                    </div>
                                                    <div class="col-12 col-md-3 d-flex align-items-center" id="content-progress-steps"> 
                                                        <div class="project-list-progress">
                                                            <div class="progress progress-pill progress-md bg-light">
                                                                <div class="progress-bar" data-progress="40" style="width: 100%;"></div>
                                                            </div>
                                                            {{-- <div class="project-progress-percent">100%</div> --}}
                                                        </div>    
                                                    </div>
                                                    <div class="col-12 col-md-1"></div>
                                                </div>
                                                <span class="accordion-icon"></span>
                                            </a>
                                            <div class="accordion-body collapse show"
                                                id="accordion-item-documentos"
                                                data-bs-parent="#accordion">
                                                <div class="accordion-inner">
                                                    <table class="table table-borderless" style="width: 60%;">
                                                        <tr>
                                                            <td>1- Cotización BBVA</td>
                                                            <td class="align-bottom"><span class="badge bg-success">Concluido</span></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>2- Cotización Coppel</td>
                                                            <td class="align-bottom"><span class="badge bg-warning">En curso</span></td>
                                                            <td>
                                                                <a href="" class="btn btn-outline-primary btn-sm">Abrir</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>3 - Nóminas personales</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-8">
                                    <div id="accordion" class="accordion mt-2">
                                        <div class="accordion-item">
                                            <a href="#" class="accordion-head"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accordion-item-kyc">
                                                <div class="row text-secondary">

                                                    <div class="col-12 col-md-2  text-primary fw-bold fs-6 d-flex align-items-center"> Captura info 
                                                        
                                                    </div>
                                                    <div class="col-12 col-md-3 d-flex align-items-center" id="content-progress-steps"> 
                                                        <div class="project-list-progress">
                                                            <div class="progress progress-pill progress-md bg-light">
                                                                <div class="progress-bar" data-progress="0" style="width: 100%;"></div>
                                                            </div>
                                                            {{-- <div class="project-progress-percent">100%</div> --}}
                                                        </div>    
                                                    </div>
                                                    <div class="col-12 col-md-1"></div>
                                                </div>
                                                <span class="accordion-icon"></span>
                                            </a>
                                            <div class="accordion-body collapse hide"
                                                id="accordion-item-kyc"
                                                data-bs-parent="#accordion">
                                                <div class="accordion-inner">
                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <td> 1- Cotización BBVA</td>
                                                            <td><span class="badge bg-success">Concluido</span></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td> 2- Cotización Coppel</td>
                                                            <td><span class="badge bg-warning">En curso</span></td>
                                                            <td>
                                                                <a href="" class="btn btn-outline-primary btn-sm">Abrir</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> 3 - Nóminas personales </td>
                                                            <td></td>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--/ nuevo diseño --}}
                                <div class="col-12 col-md-10 mt-5 d-none">
                                    <div class="card card-bordered card-preview">
                                        <div class="card-inner">
                                            <div class="row text-secondary d-none d-md-flex">
                                                <div class="d-none d-md-flex" id="content-header-steps">
                                                    <div class="col-12 col-md-1 fw-bold">#</div>
                                                    <div class="col-12 col-md-3 fw-bold">Etapa</div>
                                                    <div class="col-12 col-md-3 fw-bold">Estatus</div>
                                                    <div class="col-12 col-md-3 fw-bold">Progreso</div>
                                                    <div class="col-12 col-md-1 fw-bold"></div>
                                                </div>
                                            </div>
                                            @if ($list_steps != null)

                                                @foreach ($list_steps as $key => $list_steps)
                                                    <div id="accordion" class="accordion mt-2">
                                                        <div class="accordion-item">
                                                            <a href="#" class="accordion-head"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#accordion-item-{{ $key }}">
                                                                <div class="row text-secondary">

                                                                    <div class="col-12 col-md-1 text-primary {{ $list_steps['status'] == 'En curso' ? 'fw-bold' : '' }}"> {!! $list_steps['name'] !!}</div>
                                                                    <div class="col-12 col-md-3 text-primary {{ $list_steps['status'] == 'En curso' ? 'fw-bold' : '' }}">{{ $list_steps['step'] }}</div>
                                                                    <div class="col-12 col-md-3 text-primary {{ $list_steps['status'] == 'En curso' ? 'fw-bold' : '' }}">{{ $list_steps['status'] }}</div>
                                                                    <div class="col-12 col-md-3" id="content-progress-steps">{!! $list_steps['progress'] !!}</div>
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
                                                                                    <th>Tarea</th>
                                                                                    <th class="d-none d-md-table-cell">Asunto</th>
                                                                                    <th>Estatus</th>
                                                                                    <th class="d-none d-md-table-cell">Deadline</th>
                                                                                    <th class="d-none d-md-table-cell">Responsable</th>
                                                                                    <th></th>
                                                                                </tr>
                                                                            </thead>

                                                                            @if ($list_actions != null)
                                                                                @foreach ($list_actions as $list_actions)
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>{!! $list_actions['name'] !!}</td>
                                                                                            <td class="d-none d-md-table-cell">{{ $list_actions['subject'] }}
                                                                                            </td>
                                                                                            <td>{!! $list_actions['status'] !!}
                                                                                            </td>
                                                                                            <td class="d-none d-md-table-cell">{!! $list_actions['deadline'] !!}</td>
                                                                                            <td class="d-none d-md-table-cell">{{ $list_actions['advisor'] }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @hasrole('Administrador')
                                                                                                    @if (isset($list_actions['link']))
                                                                                                        <a href="{{ $list_actions['link'] }}"
                                                                                                            class="">Abrir</a>
                                                                                                    @endif
                                                                                                @endhasrole
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
