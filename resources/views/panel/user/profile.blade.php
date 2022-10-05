@extends('layouts.admin')
@section('title', 'Perfíl cliente persona')

@inject('m_lead', 'App\Models\Lead')
@inject('m_history_log', 'App\Models\HistoryLog')
@inject('m_action', 'App\Models\Action')
@inject('m_notification', 'App\Models\Notification')
@php
    $notifications = $m_notification->getMyNotifications();
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
                            <h3 class="nk-block-title page-title"> Usuario / <strong class="text-primary small">
                                    {{ $user->name }} {{ $user->last_name }} {{ $user->second_last_name }} </strong>
                            </h3>
                            <div class="nk-block-des text-soft">
                                <ul class="list-inline">
                                    <li>ID: <span class="text-base"> {{ $user->id }} </span></li>
                                    <li>Creado: <span class="text-base"> {{ formatDateNameMonth($user->created_at) }} </span></li>
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
                                            <li class="nav-item"> <a class="nav-link {{ (isset($_GET['tab']))? '' : 'active' }}" data-bs-toggle="tab"
                                                    href="#tabGeneral">General</a> </li>
                                            <li class="nav-item"> <a class="nav-link {{ (isset($_GET['tab']) && $_GET['tab'] == 'notification')? 'active' : '' }}" data-bs-toggle="tab"
                                                    href="#tabNotification">Notificaciones</a> </li>
                                           
                                            <li class="nav-item nav-item-trigger d-xxl-none">
                                                <div class="nk-block-head-content align-self-start d-lg-none">
                                                    <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                </div>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ (isset($_GET['tab']))? '' : 'active' }}" id="tabGeneral">
                                                <div class="card-inner">
                                                    <div class="nk-block">
                                                        <div class="nk-block-head nk-block-head-line">
                                                            <span class="preview-title-lg overline-title">General</span>
                                                        </div><!-- .nk-block-head -->
                                                        <div class="profile-ud-list">
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Nombres</span>
                                                                    <span class="profile-ud-value"> {{ $user->name }} </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Primer apellido</span>
                                                                    <span class="profile-ud-value"> {{ $user->last_name }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Segundo apellido</span>
                                                                    <span class="profile-ud-value">
                                                                        {{ $user->second_last_name }} </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Celular</span>
                                                                    <span class="profile-ud-value"> {{ $user->cellphone }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Email</span>
                                                                    <span class="profile-ud-value"> {{ $user->email }} </span>
                                                                </div>
                                                            </div>
        
                                                        </div><!-- .profile-ud-list -->
                                                    </div><!-- .nk-block -->
                                                    <div class="nk-divider divider md"></div>
                                                    <div class="nk-block">
                                                        <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                            <h5 class="title"></h5>
                                                            {{-- <a href="#" class="link link-sm">+ Add Note</a> --}}
                                                        </div><!-- .nk-block-head -->
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

                                            <div class="tab-pane {{ (isset($_GET['tab']) && $_GET['tab'] == 'notification')? 'active' : '' }}" id="tabNotification">
                                                @foreach ($notifications as $notification)
                                                <div class="card mt-3">
                                                    <div class="kanban-item">
                                                        <div class="kanban-item-title">
                                                            <h6 class="title">
                                                               {{--  <em class="{{ $icons[$action->type] }}"></em>
                                                                {{ $enum_actions[$action->type] }}  --}}
                                                                {{ $notification['title']}}
                                                            </h6>
                                                        </div>
                                                        <div class="kanban-item-text">
                                                            <p>{{ $notification['body']}}</p>
                                                        </div>
                                                        
                                                        <div class="kanban-item-meta">
                                                            <ul class="kanban-item-meta-list">
                                                                
                                            
                                                            </ul>
                                                            <ul class="kanban-item-meta-list">
                                                                <li><em class="icon ni ni-calendar"></em><span>{{ $notification['created_at']->diffForHumans() }}</span>
                                                                </li>
                                                            </ul>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
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
                                                <div class="badge bg-outline-light rounded-pill ucap">
                                                    {{ Auth::user()->getRoleNames()[0]}}
                                                </div>
                                                <h5> {{ $user->name }} {{ $user->last_name }} {{ $user->second_last_name }} </h5>
                                                <span class="sub-text">
                                                    {{ $user->email }} <br>
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
                                        <h6 class="overline-title-alt mb-2">Otros</h6>
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
                                        <h6 class="overline-title-alt mb-3">Etiquetas  </h6>
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
