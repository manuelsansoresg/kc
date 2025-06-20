@extends('layouts.admin')
@section('title', 'KC - Control desk')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
               

                <div class="nk-block nk-block-lg">

                    <div class="row">
                        <div class="col-12 col-md-8 d-md-block ">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <h3 class="nk-block-title page-title">E3/4 - T3/7 - Cotización BBVA</h3>
                                    <a href="">{{ $credit->client->id }} - {{ $credit->client->name }} {{ $credit->client->last_name }} {{ $credit->client->second_last_name }} <i class="fa-solid fa-arrow-up-right-from-square"></i> </a>
                                    <hr>
                                   
                                    
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3 mt-3">
                                                <label for="capacidadPago" class="form-label">Capacidad de pago</label>
                                                <p class="text-muted">Escribe la capacidad de pago</p>
                                                <input type="email" class="form-control" id="capacidadPago">
                                            </div>
                                          </div>
                                       
                                          <div class="col-12 col-md-6">
                                            <div class="mb-3 mt-3">
                                                <label for="capacidadPago" class="form-label">Capacidad de pago</label>
                                                <p class="text-muted">Escribe la capacidad de pago</p>
                                                <input type="email" class="form-control" id="capacidadPago">
                                            </div>
                                          </div>
      
      
                                          <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="frm-user-admin-name">*Evidencia</label>
                                                <p class="text-muted">Adjunta evidencia de la capacidad  de pago </p>
                                                <div class="form-control-wrap">
                                                    <div class="dropzone" data-max-file-size="5" data-max-files="3">
                                                        <div class="dz-message" data-dz-message> 
                                                            <span class="dz-message-text">Arrastra y suelta el archivo</span>
                                                            <span class="dz-message-or">o</span> 
                                                            <span
                                                                class="dz-message-text">Haz click para elegir</span> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
      
                                          <div class="col-12 text-end">
                                              <a href="" class="btn btn-outline-danger">Cancelar</a>
                                              <a href="" class="btn btn-outline-primary">Guardar</a>
                                              <a href="" class="btn btn-outline-primary">Guardar y continuar</a>
                                          </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-none d-md-block offset-md-1">
                            <div class="card">
                                <div class="card-body">
                                    @include('panel.credit.right_bar')
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