@extends('layouts.admin')
@section('title', 'Formulario prospecto')

@inject('m_agreement', 'App\Models\Agreement')
@inject('product', 'App\Models\Product')
@inject('user', 'App\Models\User')

@section('content')
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block-head nk-block-head-lg wide-sm">
                            <div class="nk-block-head-content">

                                <h3 class="nk-block-title page-title">Notificaciones</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item active"><a
                                                    href="/panel/email-notification">Notificaciones</a></li>
                                        </ul>
                                    </nav>
                                    <p class="text-muted mt-1"><small>Listado de las notificaciones generadas por el
                                            sistema.</small></p>
                                </div>

                            </div>

                        </div><!-- .nk-block-head -->
                        <div class="nk-block nk-block-lg ">
                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <div class="preview-block">
                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <form id="notificationForm" action="{{ route('email-notification.store') }}" method="POST">
                                            @csrf
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="form-label"></label>
                                                <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="notification_new_request" id="notification_new_request" value="1" {{ Auth()->user()->notification_new_request == '1' || Auth()->user()->notification_new_request == 1 ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="notification_new_request">Nueva Solicitud </label>
                                                        </div>
                                                </div>
                                                <small class="d-block">Se crea una nueva solicitud</small>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group"><label class="form-label"></label>
                                                <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="notification_credit_delivered" id="notification_credit_delivered" value="1" {{ Auth()->user()->notification_credit_delivered == '1' || Auth()->user()->notification_credit_delivered == 1 ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="notification_credit_delivered">Credito entregado </label>
                                                    </div>
                                                </div>
                                                <small class="d-block">Se entrega un crédito.</small>
                                            </div>
                                           
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group"><label class="form-label"></label>
                                                <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="fondos_agregados_exito" id="fondos_agregados_exito" value="1"  disabled checked>
                                                        <label class="custom-control-label" for="fondos_agregados_exito">Fondos agregados con éxito </label>
                                                    </div>
                                                </div>
                                                <small class="d-block">Confirmación de que los fondos fueron agregados y están listos para ser prestados.</small>
                                            </div>
                                           
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group"><label class="form-label"></label>
                                                <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="fondos_retirados_exito" id="fondos_retirados_exito" value="1"  disabled checked>
                                                        <label class="custom-control-label" for="fondos_retirados_exito">Fondos retirados con éxito </label>
                                                    </div>
                                                </div>
                                                <small class="d-block">Confirmación de que los fondos fueron retirados y depositados a tu cuenta bancaria.</small>
                                            </div>
                                            
                                            

                                            <div class="col-12 mt-3">
                                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                    <li>
                                                        <button type="submit" class="btn btn-primary" id="btnSave">Guardar</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


