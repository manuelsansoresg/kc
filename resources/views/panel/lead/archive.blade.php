@extends('layouts.admin')
@section('title', 'Archivo')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Archivo</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item">Archivo</li>
                                            <li class="breadcrumb-item active"><a href="/panel/lead">Prospecto</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-body">
                                <table id="dt-lead-archive" class="nowrap nk-tb-list nk-tb-ulist" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th data-priority="1">Nombre</th>
                                            <th>Fecha</th>
                                            <th>Servicio KC</th>
                                            <th>Origen</th>
                                            <th>Motivo</th>
                                            <th>Asesor</th>
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
    @include('panel.modal.note')
    @include('panel.lead.modal.advisor')
    @include('panel.modal.archive')
@endsection
