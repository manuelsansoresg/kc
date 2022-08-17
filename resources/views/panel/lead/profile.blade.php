@extends('layouts.admin')
@section('title', 'Perfíl prospecto')

@inject('m_lead', 'App\Models\Lead')
@inject('m_history_log', 'App\Models\HistoryLog')
@inject('m_action', 'App\Models\Action')

@php
    use App\Strategies\Values\ValidateStagesValues;
    $agreement    = $lead->agreementLead;
    $origins      = config('enums.origin');
    $channels     = $m_lead->getChanelByOrigin($lead->origin_id);
    $adviser      = $lead->advisorLead;
    $leadStrategy = ValidateStagesValues::STRATEGY['lead'];
    $validate     = (new $leadStrategy)->getValidate($lead->id);
    $temperatures = config('enums.temperatures');
@endphp

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"> Prospecto / <strong class="text-primary small">
                                        {{ $lead->name }} {{ $lead->last_name }} {{ $lead->second_last_name }} </strong>
                                </h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="list-inline">
                                        <li>ID: <span class="text-base"> {{ $lead->id }} </span></li>
                                        <li>Creado: <span class="text-base"> {{ formatDateNameMonth($lead->created_at) }} </span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="html/user-list-regular.html"
                                    class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em
                                        class="icon ni ni-arrow-left"></em><span>Volver</span></a>
                                <a href="html/user-list-regular.html"
                                    class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em
                                        class="icon ni ni-arrow-left"></em></a>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-aside-wrap">
                                <div class="card-inner">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab"
                                                href="#tabGeneral">General</a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                href="#tabHistorial">Historial</a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                href="#tabAction">Acciones</a> </li>
                                        <li class="nav-item nav-item-trigger d-xxl-none">
                                            <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                                        </li>
                                        {{-- <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#tabItem4">nav</a> </li> --}}
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabGeneral">
                                            <div class="card-inner">
                                                <div class="nk-block">
                                                    <div class="nk-block-head nk-block-head-line">
                                                        <span class="preview-title-lg overline-title">Producto</span>
                                                    </div><!-- .nk-block-head -->
                                                    @php
                                                        $agreement = $lead->agreementLead;
                                                        $product = $lead->productLead;
                                                    @endphp
                                                    <div class="profile-ud-list">
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Organización</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $agreement != null ? $agreement->name : '' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Producto</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $product != null ? $product->alias : '' }} </span>
                                                            </div>
                                                        </div>


                                                    </div><!-- .profile-ud-list -->
                                                </div><!-- .nk-block -->
                                                <div class="nk-block">
                                                    <div class="nk-block-head nk-block-head-line">
                                                        <hr class="preview-hr">
                                                        <span class="preview-title-lg overline-title">General</span>
                                                    </div><!-- .nk-block-head -->
                                                    <div class="profile-ud-list">
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Nombres</span>
                                                                <span class="profile-ud-value"> {{ $lead->name }} </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Primer apellido</span>
                                                                <span class="profile-ud-value"> {{ $lead->last_name }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Segundo apellido</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $lead->second_last_name }} </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Celular</span>
                                                                <span class="profile-ud-value"> {{ $lead->cellphone }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Email</span>
                                                                <span class="profile-ud-value"> {{ $lead->email }} </span>
                                                            </div>
                                                        </div>

                                                    </div><!-- .profile-ud-list -->
                                                </div><!-- .nk-block -->
                                                <div class="nk-block">
                                                    <div class="nk-block-head nk-block-head-line">
                                                        <hr class="preview-hr">
                                                        <span class="preview-title-lg overline-title">Origen</span>
                                                    </div><!-- .nk-block-head -->
                                                    <div class="profile-ud-list">
                                                        @php
                                                            $origins = config('enums.origin');
                                                            $channel = $m_lead->getChanelByOrigin($lead->origin_id);
                                                            $user = $lead->advisorLead;
                                                            $notes = $lead->leadNotes;
                                                        @endphp
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Origen</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $origins[$lead->origin_id] }} </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Canal</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $channel[$lead->channel_id] }} </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Asesor</span>
                                                                <span class="profile-ud-value"> {{ $user->name }}
                                                                    {{ $user->last_name }} {{ $user->second_last_name }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block -->
                                                <div class="nk-divider divider md"></div>
                                                <div class="nk-block">
                                                    <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                        <h5 class="title">Notas</h5>
                                                        {{-- <a href="#" class="link link-sm">+ Add Note</a> --}}
                                                    </div><!-- .nk-block-head -->
                                                    @if ($notes != null)
                                                        @foreach ($notes as $row_note)
                                                            @php
                                                                $get_note = $row_note->note;
                                                            @endphp
                                                            <div class="bq-note">
                                                                <div class="bq-note-item">
                                                                    <div class="bq-note-text">
                                                                        <p> {{ $get_note->description }}</p>
                                                                    </div>
                                                                    <div class="bq-note-meta">
                                                                        <span class="bq-note-added">Agregado el <span
                                                                                class="date">
                                                                                {{ formatDateNameMonth($get_note->created_at) }}
                                                                            </span> </span>
                                                                        {{-- <span class="bq-note-sep sep">|</span>
                                                                 <span class="bq-note-by">By <span>Softnio</span></span>
                                                                <a href="#" class="link link-sm link-danger">Delete Note</a> --}}
                                                                    </div>
                                                                </div><!-- .bq-note-item -->
                                                            </div><!-- .bq-note -->
                                                        @endforeach
                                                    @endif
                                                </div><!-- .nk-block -->
                                            </div><!-- .card-inner -->
                                        </div>
                                        <div class="tab-pane" id="tabHistorial">
                                            @php
                                                $histories = $m_history_log->getByStatus([1, 2, 3]);
                                                $leyend_status = $m_history_log::$label_status;
                                            @endphp
                                            @foreach ($histories as $history)
                                                @if ($history->status_id === $m_history_log::LEAD_ARCHIVE)
                                                    <div class="user-card mt-3">
                                                        <div class="user-info">
                                                            <span class="tb-lead"> <em
                                                                    class="icon ni ni-archive-fill"></em>
                                                                {{ $leyend_status[$m_history_log::LEAD_ARCHIVE] }} <span
                                                                    class="dot dot-success d-md-none ms-1"></span>
                                                                <p class="ms-1">
                                                                    {{ formatDateNameMonth($history->created_at) }}</p>
                                                            </span>

                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($history->status_id === $m_history_log::ADD_PROSPECT)
                                                    @php
                                                        $advisor = $history->historyLeadAdvisor;
                                                        $lead_history = $advisor->lead;
                                                    @endphp
                                                    <div class="user-card mt-3">
                                                        <div class="user-info">
                                                            <span class="tb-lead"> <em
                                                                    class="icon ni ni-forward-fill"></em>
                                                                {{ $leyend_status[$m_history_log::ADD_PROSPECT] }}
                                                                {{ $lead_history->name }} {{ $lead_history->last_name }}
                                                                {{ $lead_history->second_last_name }}
                                                                <p class="ms-1">
                                                                    {{ formatDateNameMonth($history->created_at) }}</p>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($history->status_id === $m_history_log::CREATE_PROSPECT)
                                                    @php
                                                        $lead_history = $history->historyLead;
                                                    @endphp
                                                    <div class="user-card mt-3">
                                                        <div class="user-info">
                                                            <span class="tb-lead"><em
                                                                    class="icon ni ni-user-add-fill"></em>
                                                                {{ $leyend_status[$m_history_log::CREATE_PROSPECT] }}
                                                                {{ $lead_history->name }} {{ $lead_history->last_name }}
                                                                {{ $lead_history->second_last_name }}
                                                                <p>{{ formatDateNameMonth($history->created_at) }}</p>

                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                                {{-- <div class="user-card">
                                                <div class="user-info">
                                                    <span class="tb-lead">{{ $lead->name }} <span class="dot dot-success d-md-none ms-1"></span>
                                                </span><span>{{ $lead->email }}</span>
                                                </div>
                                            </div> --}}
                                            @endforeach
                                        </div>
                                        <div class="tab-pane" id="tabAction">
                                            @php
                                                $icons = config('enums.type_icon_actions');
                                                $actions_programmed = $m_action->getByModel($lead->id, $model);
                                                $actions_completed = $m_action->getByModel($lead->id, $model, 1);
                                                $actions = config('enums.type_actions');
                                            @endphp
                                            <div class="border-bottom text-center py-3">
                                                <a class="pointer" onclick="actionModal({{ $lead->id }}, false)">Haz clic
                                                    para agregar accion</a>
                                            </div>
                                            <input type="hidden" id="id-rel-action" value="{{ $lead->id }}">
                                            <input type="hidden" id="model-action" value="{{ $model_action }}">
                                            <div class="col-12 text-center mt-3">
                                                <span class="badge rounded-pill bg-light">En curso</span>
                                            </div>
                                            <div id="content-profile-in_progress">
                                                
                                            </div>
                                            <div class="col-12 text-center mt-3">
                                                <span class="badge rounded-pill bg-light">Concluidas</span>
                                            </div>
                                            <div id="content-profile-completed">
                                                
                                            </div>
                                        </div>
                                        {{-- <div class="tab-pane" id="tabItem4">
                                        <p>contnet</p>
                                    </div> --}}
                                    </div>
                                </div><!-- .card-content -->

                            </div><!-- .card-aside-wrap -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                    {{-- left card --}}
                    <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                        <div class="card-inner-group" data-simplebar>
                            <div class="card-inner">
                                <div class="user-card user-card-s2">
                                    <img class="logo-profile" src="{{ asset('images/logo_solo.png') }}" alt="">
                                    <div class="user-info">
                                        <div class="badge bg-outline-light rounded-pill ucap">PROSPECTO</div>
                                        <h5> {{ $lead->name }} {{ $lead->last_name }} {{ $lead->second_last_name }} </h5>
                                        <span class="sub-text">
                                            {{ $lead->email }} <br>
                                            {{ $agreement->name }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- .card-inner -->
                            <div class="card-inner card-inner-sm">
                                <ul class="btn-toolbar justify-center gx-1">
                                    <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-shield-off"></em></a></li>
                                    <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-mail"></em></a></li>
                                    <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-download-cloud"></em></a></li>
                                    <li><a href="#" class="btn btn-trigger btn-icon"><em class="icon ni ni-bookmark"></em></a></li>
                                    <li><a href="#" class="btn btn-trigger btn-icon text-danger"><em class="icon ni ni-na"></em></a></li>
                                </ul>
                            </div><!-- .card-inner -->
                            <div class="card-inner d-none">
                                <div class="overline-title-alt mb-2">In Account</div>
                                <div class="profile-balance">
                                    <div class="profile-balance-group gx-4">
                                        <div class="profile-balance-sub">
                                            <div class="profile-balance-amount">
                                                <div class="number">2,500.00 <small class="currency currency-usd">USD</small></div>
                                            </div>
                                            <div class="profile-balance-subtitle">Invested Amount</div>
                                        </div>
                                        <div class="profile-balance-sub">
                                            <span class="profile-balance-plus text-soft"><em class="icon ni ni-plus"></em></span>
                                            <div class="profile-balance-amount">
                                                <div class="number">1,643.76</div>
                                            </div>
                                            <div class="profile-balance-subtitle">Profit Earned</div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card-inner -->
                            <div class="card-inner d-none">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="profile-stats">
                                            <span class="amount">23</span>
                                            <span class="sub-text">Total Order</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="profile-stats">
                                            <span class="amount">20</span>
                                            <span class="sub-text">Complete</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="profile-stats">
                                            <span class="amount">3</span>
                                            <span class="sub-text">Progress</span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card-inner -->
                            <div class="card-inner">
                                <h6 class="overline-title-alt mb-2">Otros</h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <span class="sub-text">Origen:</span>
                                        <span>{{ $origins[$lead->origin_id] }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="sub-text">Canal:</span>
                                        <span>{{ $channels[$lead->channel_id] }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="sub-text">Etatus:</span>
                                        @if ($validate['error'] === true)
                                            <span class="lead-text text-success">Valido</span>
                                            @else
                                            <span class="lead-text text-danger">Invalido</span>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <span class="sub-text">Asesor:</span>
                                        <span> {{ $adviser->name }} {{ $adviser->last_name }} </span>
                                    </div>
                                </div>
                            </div><!-- .card-inner -->
                            <div class="card-inner">
                                <h6 class="overline-title-alt mb-3">Etiquetas {{ $lead->temperature_id }} </h6>
                                <ul class="g-1">
                                    <li class="btn-group">
                                        
                                        <a class="btn btn-xs btn-light btn-dim" href="#"> {{ $temperatures[$lead->temperature_id] }} </a>
                                        <a class="btn btn-xs btn-icon btn-light btn-dim"><em class="icon ni ni-cross"></em></a>
                                    </li>
                                   {{--  <li class="btn-group">
                                        <a class="btn btn-xs btn-light btn-dim" href="#">support</a>
                                        <a class="btn btn-xs btn-icon btn-light btn-dim" href="#"><em class="icon ni ni-cross"></em></a>
                                    </li>
                                    <li class="btn-group">
                                        <a class="btn btn-xs btn-light btn-dim" href="#">another tag</a>
                                        <a class="btn btn-xs btn-icon btn-light btn-dim" href="#"><em class="icon ni ni-cross"></em></a>
                                    </li> --}}
                                </ul>
                            </div><!-- .card-inner -->
                        </div><!-- .card-inner -->
                    </div><!-- .card-aside -->
                    {{-- left card --}}
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="refresh-dt" value="null">
    @include('panel.action.modal.form')
    @include('panel.action.modal.register_action')
@endsection
