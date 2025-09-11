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

                                <h3 class="nk-block-title page-title">Notificaciónes</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item active"><a
                                                    href="/panel/email-notification">Notificaciónes</a></li>
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
                                        <form id="notificationForm" action="{{ route('email-notification.store') }}" method="POST">
                                            @csrf
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-control-wrap me-3">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="notification_new_request" name="notification_new_request"
                                                                    value="1" {{ $user->notification_new_request == '1' || $user->notification_new_request == 1 ? 'checked' : '' }}>

                                                                <label class="custom-control-label"
                                                                    for="notification_new_request"></label>
                                                            </div>
                                                        </div>
                                                        <label class="form-label" for="notification_new_request">Nueva
                                                            Solicitud</label>
                                                    </div>
                                                    <small class="d-block">Se crea una nueva solicitud</small>
                                                </div>
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

@section('scripts')
<script>
$(document).ready(function() {
    $('#notificationForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var submitBtn = $('#btnSave');
        
        // Deshabilitar el botón mientras se procesa
        submitBtn.prop('disabled', true).text('Guardando...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error('Error al guardar la configuración');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Error al procesar la solicitud');
                console.error('Error:', error);
            },
            complete: function() {
                // Rehabilitar el botón
                submitBtn.prop('disabled', false).text('Guardar');
            }
        });
    });
});
</script>
@endsection
