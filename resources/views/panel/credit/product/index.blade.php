@extends('layouts.admin')
@section('title', 'Lista de creditos')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                @php
                                    $section = Request::segment(3);
                                    $title = ($section == 'in_progress')? 'En curso': 'Concluidas';
                                @endphp
                                <h3 class="nk-block-title page-title">{{ $title }}</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item active">{{ $title }}</li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="/panel/financial/create" class="btn btn-icon btn-primary"><em
                                        class="icon ni ni-plus"></em></a>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table id="dt-product-credit" class="nowrap nk-tb-list nk-tb-ulist" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Producto</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
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
    <input type="hidden" id="refresh-dt" value="null">
    <input type="hidden" id="status" value="{{ $status }}">
  
@endsection
