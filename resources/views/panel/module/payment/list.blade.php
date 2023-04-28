@extends('layouts.admin')
@section('title', 'KC- Payment')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">KC- Payment</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item active"><a href="/panel/kc-check-up">KC- Payment</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                         {{--    <div class="nk-block-head-content">
                                <a href="/panel/lead/create" class="btn btn-icon btn-primary"><em
                                        class="icon ni ni-plus"></em></a>
                            </div> --}}
                        </div>
                    </div>
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <table id="dt-payment" class="nowrap nk-tb-list nk-tb-ulist" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Producto</th>
                                            <th data-priority="1">Cliente</th>
                                            <th>Asesor</th>
                                            <th>Progreso</th>
                                            <th>En curso</th>
                                            <th>Deadline</th>
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
    <input type="hidden" id="refresh-dt" value="dt-lead">
    @include('panel.modal.note')
    @include('panel.lead.modal.advisor')
    @include('panel.modal.archive')
    @include('panel.modal.tags')
    @include('panel.modal.validate')
    @include('panel.action.modal.form')
    @include('panel.action.modal.register_action')
@endsection
