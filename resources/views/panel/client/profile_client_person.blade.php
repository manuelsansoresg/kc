@extends('layouts.admin')
@section('title', 'Perfíl cliente persona')

@inject('m_lead', 'App\Models\Lead')
@inject('m_client', 'App\Models\ClientPerson')
@inject('m_history_log', 'App\Models\HistoryLog')
@inject('m_action', 'App\Models\Action')
@inject('m_file', 'App\Models\File')

@php
    use App\Strategies\Values\ValidateStagesValues;
    $credits = $client->credit;
@endphp

@section('content')
{{-- content --}}
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title"> Cliente persona / <strong class="text-primary small">
                                    {{ $client->name }} {{ $client->last_name }} {{ $client->second_last_name }} </strong>
                            </h3>
                            <div class="nk-block-des text-soft">
                                <ul class="list-inline">
                                    <li>ID: <span class="text-base"> {{ $client->id }} </span></li>
                                    <li>Creado: <span class="text-base"> {{ formatDateNameMonth($client->created_at) }} </span></li>
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
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block">
                                    <div class="nk-data data-list">
                                        @php
                                            $tab = isset($_GET["tab"])? $_GET["tab"] : null;
                                        @endphp
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"> <a class="nav-link {{ $tab == null ? 'active' : null}}" data-bs-toggle="tab"
                                                    href="#tabGeneral">General</a> </li>
                                            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                    href="#tabHistorial">Historial</a> </li>
                                            <li class="nav-item"> <a class="nav-link {{ $tab == 'credits' ? 'active' : null}}" data-bs-toggle="tab"
                                                    href="#tabCredits">Créditos</a> </li>
                                            <li class="nav-item"> <a class="nav-link {{ $tab == 'documents' ? 'active' : null}}" data-bs-toggle="tab"
                                                    href="#tabDocuments">Documentos</a> </li>
                                            <li class="nav-item nav-item-trigger d-xxl-none">
                                                <div class="nk-block-head-content align-self-start d-lg-none">
                                                    <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                </div>
                                            </li>
                                          
                                            
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $tab == null ? 'active' : null}}" id="tabGeneral">
                                                <div class="card-inner">
                                                    <div class="nk-block">
                                                        <div class="nk-block-head nk-block-head-line">
                                                            <span class="preview-title-lg overline-title text-primary">General</span>
                                                        </div><!-- .nk-block-head -->
                                                        <div class="profile-ud-list">
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Nombres</span>
                                                                    <span class="profile-ud-value"> {{ $client->name }} </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Primer apellido</span>
                                                                    <span class="profile-ud-value"> {{ $client->last_name }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Segundo apellido</span>
                                                                    <span class="profile-ud-value">
                                                                        {{ $client->second_last_name }} </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Celular</span>
                                                                    <span class="profile-ud-value"> {{ $client->cellphone }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Email</span>
                                                                    <span class="profile-ud-value"> {{ $client->email }} </span>
                                                                </div>
                                                            </div>
        
                                                        </div><!-- .profile-ud-list -->
                                                        
                                                    </div><!-- .nk-block -->
                                                    
                                                    <div class="nk-block">
                                                        <div class="profile-ud-list">
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Fecha de nacimiento</span>
                                                                    <span class="profile-ud-value">
                                                                        {{ $client !== null ? formatDateNameMonth($client->birth_date, false) : null }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="nk-divider divider md"></div>
                                                    <div class="nk-block">
                                                        <div class="nk-block-head nk-block-head-line">
                                                            <span class="preview-title-lg overline-title text-primary">LABORAL</span>
                                                        </div><!-- .nk-block-head -->
                                                        <div class="profile-ud-list">
                                                           
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Antigüedad laboral</span>
                                                                    <span class="profile-ud-value">
                                                                        {{ $client !== null ? $client->labor_old : null }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Categoría</span>
                                                                    <span class="profile-ud-value">
                                                                        {{ $client !== null ? $client->employee_category : null }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-block">
                                                      {{--   <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                            <h5 class="preview-title-lg overline-title text-primary">Notas</h5>
                                                            <a href="#" class="link link-sm">+ Add Note</a>
                                                        </div> --}}
                                                        <!-- .nk-block-head -->
                                                        {{-- @if ($notes != null)
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
                                                                      
                                                                        </div>
                                                                    </div><!-- .bq-note-item -->
                                                                </div><!-- .bq-note -->
                                                            @endforeach
                                                        @endif --}}
                                                    </div><!-- .nk-block -->
                                                </div><!-- .card-inner -->
                                            </div>
                                            <div class="tab-pane" id="tabHistorial">
                                                @php
                                                    $histories = $m_history_log->getByStatus([4], $client->id);
                                                    $leyend_status = $m_history_log::$label_status;
                                                @endphp
                                                @foreach ($histories as $history)
                                                    @if ($history->status_id === $m_history_log::LEAD_CONVERT)
                                                        <div class="user-card mt-3">
                                                            <div class="user-info">
                                                                <span class="tb-lead"> <em
                                                                        class="icon ni ni-clock"></em>
                                                                    {{ $leyend_status[$m_history_log::LEAD_CONVERT] }} <span
                                                                        class="dot dot-success d-md-none ms-1"></span>
                                                                    <p class="ms-1">
                                                                        {{ formatDateNameMonth($history->created_at) }}</p>
                                                                </span>
        
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                @endforeach
                                            </div>
                                            <div class="tab-pane {{ $tab == 'credits' ? 'active' : null}}" id="tabCredits">
                                                <table class="table table-tranx">
                                                    <thead>
                                                        <tr class="tb-tnx-head">
                                                            <th class="tb-tnx-id"><span class="">ID del crédito</span></th>
                                                            <th class="tb-tnx-info">
                                                                <span class="tb-tnx-desc d-none d-sm-inline-block">
                                                                    <span>Alias del producto</span>
                                                                </span>
                                                                
                                                            </th>
                                                            <th class="tb-tnx-id"><span class="">Fecha</span></th>
                                                            {{-- <th class="tb-tnx-amount is-alt">
                                                                <span class="tb-tnx-total">Total</span>
                                                                <span class="tb-tnx-status d-none d-md-inline-block">Status</span>
                                                            </th>
                                                             --}}
                                                             <th class="tb-tnx-action">
                                                                <span>&nbsp;</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($credits as $credit)
                                                            @php
                                                                $client_person = $m_client::find($credit->client_person_id);
                                                                $product = $credit->creditProduct;
                                                            @endphp
                                                            <tr class="tb-tnx-item">
                                                                <td class="tb-tnx-id">
                                                                   {{ $credit->id }}
                                                                </td>
                                                                <td class="tb-tnx-info">
                                                                    @if ($product !== null)
                                                                        {{ $product->alias }}
                                                                    @endif
                                                                    
                                                                </td>
                                                                
                                                                
                                                                <td>
                                                                    {{ formatDateNameMonth($credit->created_at, false) }}
                                                                </td>
                                                                <td>
                                                                    <a href="/panel/credit/{{ $credit->id }}">Abrir</a>
                                                                </td>
                                                                
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane {{ $tab == 'documents' ? 'active' : null}}" id="tabDocuments">
                                                <table class="table table-tranx">
                                                        <thead>
                                                            <tr class="tb-tnx-head">
                                                                <th class="tb-tnx-id"><span class="">Documento</span></th>
                                                                <th class="tb-tnx-info">
                                                                </th>

                                                            </tr>
                                                        </thead>
                                                @php
                                                    $files = $m_file->getFileClients($client->id);
                                                @endphp
                                                @foreach ($files as $file)
                                                @php
                                                    $parts = explode('_', $file->step);
                                                    // El primer elemento siempre será el nuevo valor de $step
                                                    $step = $parts[0];
                                                    // $task será el segundo elemento si existe, de lo contrario será null
                                                    $task = (count($parts) > 1) ? $parts[1] : null;
                                                    $path = $file->step == '3_5' || ($file->template_config_id == 4 && $file->model == 21 &&  $step == '3' ) ? 'files_upload/' : 'firma_contratos/';
                                                    
                                                @endphp
                                                 <tr>
                                                    <td><a href="{{ asset($path.$file->name) }}" target="_blank">{{ $file->name }}</a></td>
                                                    <td><a href="{{ asset($path.$file->name) }}" download>Descargar</a></td>
                                                </tr>
                                                @endforeach
                                                {{-- @if ($client->cm_agreement != null)
                                                @php
                                                    $nombre = $client->id.'-'.$client->name.' '.$client->last_name.' '.$client->second_last_name.' contrato CM.pdf';
                                                @endphp
                                                    <a href="{{ asset('firma_contratos/'.$nombre) }}" target="_blank">{{ $nombre }}</a>
                                                @endif --}}
                                                </table>
                                            </div>
                                            
                                        </div>
                                       
                                    </div><!-- data-list -->
                                    
                                </div><!-- .nk-block -->
                            </div>
                            <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner">
                                        <div class="user-card user-card-s2">
                                            <img class="logo-profile" src="{{ asset('images/logo_solo.png') }}" alt="">
                                            <div class="user-info">
                                                <div class="badge bg-outline-light rounded-pill ucap">Cliente</div>
                                                <h5> {{ $client->name }} {{ $client->last_name }} {{ $client->second_last_name }} </h5>
                                                <span class="sub-text">
                                                    {{ $client->email }} <br>
                                                   {{--  {{ $agreement->name }} --}}
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
                                    <div class="card-inner">
                                        <h6 class="overline-title-alt mb-2 text-primary">Otros</h6>
                                        <div class="row g-3 d-none">
                                            <div class="col-6">
                                                <span class="sub-text">Origen:</span>
                                                <span></span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Canal:</span>
                                                <span></span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Etatus:</span>
                                              
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Asesor:</span>
                                                <span> </span>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <h6 class="overline-title-alt mb-3 text-primary">Etiquetas  </h6>
                                        <ul class="g-1 d-none">
                                            <li class="btn-group">
                                                
                                                <a class="btn btn-xs btn-light btn-dim" href="#"> </a>
                                                <a class="btn btn-xs btn-icon btn-light btn-dim"><em class="icon ni ni-cross"></em></a>
                                            </li>
                                        </ul>
                                    </div><!-- .card-inner -->
                                </div><!-- .card-inner-group -->
                            </div><!-- card-aside -->
                        </div><!-- .card-aside-wrap -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
{{-- content --}}
    
    <input type="hidden" id="refresh-dt" value="null">
    @include('panel.action.modal.form')
    @include('panel.action.modal.register_action')
@endsection
