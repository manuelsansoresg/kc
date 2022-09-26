@extends('layouts.admin')
@section('title', 'Perfíl crédito')

@inject('m_lead', 'App\Models\Lead')
@inject('m_history_log', 'App\Models\HistoryLog')
@inject('m_action', 'App\Models\Action')

@php
    
    $client       = $credit->creditClientPerson;
    $agreement    = $credit->creditAgreement;
    $financial    = $credit->creditFinancial;
    $product      = $credit->creditProduct;
    $types        = config('enums.type_lead');
    $origins      = config('enums.origin');
    $channel      = $m_lead->getChanelByOrigin($credit->origin_id);
    $advisor      = $credit->creditAdvisor;
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
                            <h3 class="nk-block-title page-title"> Crédito / <strong class="text-primary small">
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
                                        
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab"
                                                    href="#tabGeneral">General</a> </li>
                                            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                    href="#tabHistorial">Historial</a> </li>
                                            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                    href="#tabActions">Acciónes</a> </li>
                                            <li class="nav-item nav-item-trigger d-xxl-none">
                                                <div class="nk-block-head-content align-self-start d-lg-none">
                                                    <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                </div>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tabGeneral">
                                                <div class="card-inner">
                                                    <div class="nk-block">
                                                        <div class="nk-block-head nk-block-head-line">
                                                            <span class="preview-title-lg overline-title">Crédito</span>
                                                        </div><!-- .nk-block-head -->
                                                        <div class="profile-ud-list">
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Financiera</span>
                                                                    <span class="profile-ud-value">
                                                                        {{ $financial !== null ? $financial->commercial_name : null }} </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Financiera tipo</span>
                                                                    <span class="profile-ud-value"> {{ (isset($types[$credit->type_id])) ? $types[$credit->type_id] : null }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Organización</span>
                                                                    <span class="profile-ud-value"> {{ $agreement !== null ? $agreement->name : null }} </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Producto</span>
                                                                    <span class="profile-ud-value"> {{ $product !== null ? $product->alias : null }}
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
                                                    <div class="nk-divider divider md"></div>

                                                    <div class="nk-block">
                                                        <div class="nk-block-head nk-block-head-line">
                                                            <span class="preview-title-lg overline-title">Cliente</span>
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
                                                    <div class="nk-divider divider md"></div>
                                                    <div class="nk-block">
                                                        <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                            <h5 class="title">Notas</h5>
                                                            
                                                            {{-- <a href="#" class="link link-sm">+ Add Note</a> --}}
                                                        </div><!-- .nk-block-head -->
                                                        <p> <a class="link pointer" onclick="modalNote({{ $credit->id }}, 'credit')">Haz click para agregar notas</a> </p>
                                                        <div id="content-note"></div>
                                                    </div><!-- .nk-block -->
                                                </div><!-- .card-inner -->
                                            </div>
                                            <div class="tab-pane" id="tabHistorial">
                                                @php
                                                    $histories = $m_history_log->getByStatus([5,6]);
                                                    $leyend_status = $m_history_log::$label_status;
                                                @endphp
                                                @foreach ($histories as $history)
                                                    
                                                <div class="user-card mt-3">
                                                    <div class="user-info">
                                                        <span class="tb-lead"> <em
                                                                class="icon ni ni-archive-fill"></em>
                                                            {{ $leyend_status[$history->status_id] }} <span
                                                                class="dot dot-success d-md-none ms-1"></span>
                                                            <p class="ms-1">
                                                                {{ formatDateNameMonth($history->created_at) }}</p>
                                                        </span>

                                                    </div>
                                                </div>
                                                    
                                                @endforeach
                                            </div>
                                            <div class="tab-pane" id="tabActions">
                                                <table id="dt-acctions-profile" class="nowrap nk-tb-list nk-tb-ulist" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Acción</th>
                                                            <th>Módulo</th>
                                                            <th>Deadline</th>
                                                            <th>Responsable</th>
                                                            <th>Estatus</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                   
                                                </table>
                                            </div>
                                          
                                        </div>
                                       
                                    </div><!-- data-list -->
                                    
                                </div><!-- .nk-block -->
                            </div>
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-toggle-body="true" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner">
                                        <div class="user-card user-card-s2">
                                            <img class="logo-profile" src="{{ asset('images/logo_solo.png') }}" alt="">
                                            <div class="user-info">
                                                <div class="badge bg-outline-light rounded-pill ucap">Cr;edito</div>
                                                <h5> {{ $client->name }} {{ $client->last_name }} {{ $client->second_last_name }} </h5>
                                                <span class="sub-text">
                                                    {{ $client->email }} <br>
                                                    {{ $product !== null ? $product->alias : null }}
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
                                        <h6 class="overline-title-alt mb-2">Otros</h6>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <span class="sub-text">Origen:</span>
                                                <span>{{ $origins[$credit->origin_id] }}</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Canal:</span>
                                                <span>{{ $channel[$credit->channel_id] }}</span>
                                            </div>
                                            <div class="col-6 d-none">
                                                <span class="sub-text">Etatus:</span>
                                              
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Asesor:</span>
                                                @if ($advisor !== null)
                                                    <span>  
                                                        {{ $advisor->name }} {{ $advisor->last_name }} {{ $advisor->second_last_name }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <h6 class="overline-title-alt mb-3">Etiquetas  </h6>
                                        <p> <a class="link pointer" onclick="modalCreditTag({{ $credit->id}})">Haz click para agregar etiquetas</a> </p>
                                        <div id="content-tag"></div>
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
    <input type="hidden" id="credit-profile-credit_id" value="{{ $credit->id }}">
    @include('panel.action.modal.form')
    @include('panel.action.modal.register_action')
    @include('panel.modal.note')
    @include('panel.credit.modal.tag')
@endsection
