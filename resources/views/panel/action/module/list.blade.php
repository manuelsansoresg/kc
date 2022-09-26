@extends('layouts.admin')
@section('title', 'Lista de acciones '.$title)
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item"><a class="pointer">ACCIONES MÓDULOS</a></li>
                                            <li class="breadcrumb-item active">{{ strtoupper($title) }}</li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="name_status" id="name_status" value="{{ $name_status }}">
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table id="dt-acctions-module" class="nowrap nk-tb-list nk-tb-ulist" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Acción</th>
                                            <th>Módulo</th>
                                            <th>Nombre</th>
                                            <th>Deadline</th>
                                            <th>Asesor</th>
                                            <th>Responsable</th>
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
    
   
@endsection
