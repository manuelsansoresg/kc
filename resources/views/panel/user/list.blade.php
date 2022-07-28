@extends('layouts.admin')
@section('title', 'Lista de usuarios'. $title)
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Usuarios {{ $title }}</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item">Configuración</li>
                                            <li class="breadcrumb-item"><a href="#">Usuario</a></li>
                                            <li class="breadcrumb-item active"><a href="/panel/user/administrador">{{ $title }}</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a class="btn btn-icon btn-primary" onclick="modalUser(1, null)"><em
                                        class="icon ni ni-plus"></em></a>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-body">
                                <table id="dt-admin" class="display nowrap nk-tb-list nk-tb-ulist dataTable no-footer" style="width:100%">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head">
                                            <th class="nk-tb-col"><span class="sub-text">Nombres </span></th>
                                            <th class="nk-tb-col"><span class="sub-text">Primer apellido </span></th>
                                            <th class="nk-tb-col"><span class="sub-text">Segundo apellido </span></th>
                                            <th class="nk-tb-col"><span class="sub-text">Celular </span></th>
                                            <th class="nk-tb-col"><span class="sub-text">Email </span></th>
                                            <th class="nk-tb-col"><span class="sub-text">Activo </span></th>
                                            <th class="nk-tb-col"></th>
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
    <input type="hidden" id="route_datatable" value="{{ $route }}">
    <input type="hidden" id="title" value="{{ strtolower($title) }}">
    
    @if ($route == 'cliente-persona')
        @include('panel.user.modal.form_client_persona')
        @elseif($route == 'cliente-financiera')
            @include('panel.user.modal.form_client_financiera')
        @else
            @include('panel.user.modal.form')
    @endif



    @include('panel.user.modal.form_password')
@endsection
