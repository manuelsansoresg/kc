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
                                            <li class="breadcrumb-item active"><a href="/panel/lead">{{ $title }}</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-body">
                                <table id="dt-lead-dinamic-archive" class="display nowrap nk-tb-list nk-tb-ulist dataTable no-footer" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Fecha</th>
                                            <th>Producto</th>
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
    <input type="hidden" id="module_id"  value="{{ $module_id }}">
    @include('panel.modal.note')
    @include('panel.lead.modal.advisor')
    @include('panel.modal.archive')
@endsection
