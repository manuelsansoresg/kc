@extends('layouts.admin')
@section('title', 'Etapas')
@inject('m_history', 'App\Models\HistoryLog')
@php
    use App\Strategies\Values\TemplateValues;
@endphp
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
                                                        <li class="breadcrumb-item "><a href="/panel/kc-check-up">KC - Check up</a></li>
                                                        <li class="breadcrumb-item active">Etapas</li>
                                                    @else
                                                        {!! $breadcrumb !!}
                                                    @endif
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="d-block d-md-none">
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
                            <div class="row">
                                <!-- Columna principal -->
                                <div class="col-12 col-md-8 d-md-block">
                                    @php
                                    $templateStrategy = TemplateValues::STRATEGY[$model];
                                    $totalPercent = (new $templateStrategy)->getPercent($history);
                                    $previousPercent = 100; // Iniciamos con 100
                                    @endphp

                                    @if ($list_steps != null)
                                        @foreach ($list_steps as $key => $list_step)
                                            @php
                                                $percent = (new $templateStrategy)->calculateStepAverage($history_id, $key + 1);
                                                $nameStep = $list_step['nameStep'];
                                            @endphp
                                            <div id="accordion" class="accordion mt-2">
                                                <div class="accordion-item">
                                                    <a href="#" class="accordion-head d-flex justify-content-between align-items-center text-secondary" data-bs-toggle="collapse" data-bs-target="#accordion-item-documentos-{{ $key }}">
                                                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center flex-grow-1 me-4">
                                                          <div class="text-primary fw-bold fs-6 me-md-3">
                                                            {{ $nameStep }}
                                                          </div>
                                                          <div id="content-progress-steps" class="w-100 w-md-auto mt-2 mt-md-0">
                                                            <div class="progress progress-pill progress-md bg-light">
                                                              <div class="progress-bar" style="width: {{ $percent }}%;"></div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <span class="accordion-icon" style="flex-shrink: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; margin-left: 20px;">
                                                          <!-- Ícono aquí -->
                                                        </span>
                                                      </a>
                                                    <div class="accordion-body collapse show" id="accordion-item-documentos-{{ $key }}" data-bs-parent="#accordion">
                                                        <div class="accordion-inner">
                                                            @php
                                                                $indice = $key + 1;
                                                                $list_actions = $indice > 0 ? (new $actionStrategy())->listActionByStep($history_id, $indice) : null;
                                                            @endphp
                                                            <table class="table table-borderless" >
                                                                @if ($list_actions != null)
                                                                    @foreach ($list_actions as $list_action)
                                                                        @if (($key == 0 && $percent != 100) || $previousPercent == 100)
                                                                            <tr>
                                                                                <td class="col-8">{!! $list_action['name'] !!} </td>
                                                                                
                                                                                <td class="col-4 text-end">
                                                                                    {!! $list_action['statusBadge'] !!}
                                                                                    @if ($list_action['status'] == 'En curso')
                                                                                        <a href="{{ $list_action['link'] }}" class="btn btn-outline-primary btn-sm">Abrir</a>
                                                                                    @endif
                                                                                    @if (($list_action['name'] == '1- Capturar Anverso INE' || $list_action['name'] == '2- Capturar Reverso INE') && ($list_action['status'] == 'Concluido') && $percent < 100  )
                                                                                        <a href="{{ $list_action['link'] }}" class="btn btn-outline-primary btn-sm">Revisar</a>
                                                                                    @endif
                                                                                    <a href="{{ $list_action['link'] }}" class="btn btn-outline-primary btn-sm">Abrir</a>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $previousPercent = $percent;
                                            @endphp
                                        @endforeach
                                    @endif

                                    

                                    @if ($model == 'controlDesk')
                                        @php
                                            $isFinish = (new $templateStrategy)->isFinish($history);
                                        @endphp
                                        @if ($totalPercent == 100)
                                            @if ($isFinish == true)
                                            <div class="col-12  text-end mt-5">
                                                <a onclick="finishControlDesk({{ $history->id }})" class="btn btn-outline-success">Continuar</a>
                                            </div>
                                            @else
                                            <div class="col-12  text-end mt-5">
                                                <a onclick="openModalValidateControlDesk({{  $history->id_rel }})" class="btn btn-outline-secondary">Continuar</a>
                                            </div>
                                            @endif
                                        @endif
                                    @endif
                                    @if ($model == 'delivery')
                                        @php
                                            $isFinish = (new $templateStrategy)->isFinish($history);
                                        @endphp
                                        @if ($isFinish == true)
                                            <div class="nk-block nk-block-lg">
                                                <div class="container">
                                                    <div class="row ">
                                                        <div class="col-12 col-md-8 text-end">
                                                            <a onclick="sendCreditActive({{ $history->id }})" class="btn btn-outline-success">Finalizar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                @if ($model != 'wallet' && $model != 'kc-down-wallet')
                                <!-- Columna secundaria: Card info cliente -->
                                <div class="col-md-3 d-none d-md-block offset-md-1">
                                    <div class="card">
                                        <div class="card-body">
                                            @include('panel.credit.right_bar')
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div> <!-- cierre row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="history_id" value="{{ $history_id }}">
    <input type="hidden" id="model" value="{{ $model }}">
    <input type="hidden" id="refresh-dt" value="dt-lead">
  

    <div class="modal fade" id="modalValidateControlDesk" tabindex="-1" aria-labelledby="modalValidateControlDeskLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="modalValidateControlDeskLabel">No puedes continuar</h5>
                    <p class="text-muted">Revisa las validaciones</p>
                    <div id="content-validate-control-desk"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
