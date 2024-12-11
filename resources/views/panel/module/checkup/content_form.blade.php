@extends('layouts.admin')
@section('title', 'Formulario financiera')
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
                                    
                                    <h3 class="nk-block-title page-title">{!! $title!!}</h3>
                                    <div class="nk-block-des text-soft">
                                        <nav>
                                            <ul class="breadcrumb">
                                                {!!  $breadcrumb !!}
                                            </ul>
                                        </nav>
                                        
                                    </div>

                                    <hr>
                                    
                                    <div id="content-legend-kc-down-bank" class="py-2" style="display: none">
                                        <div class="alert alert-primary " role="alert">
                                            Nota: El dinero se depositará a la cuenta registrada en máximo un día habil
                                          </div>
                                    </div>
                                    <div id="content-legend"></div>
                                    <p>* Campos obligatorios</p>
                                    <div class="row gy-4">
                                        {!! $form !!}
                                        <input type="hidden" id="id_rel" value="{{ $id_rel }}">
                                    </div>

                                    
                                    
                                
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-none d-md-block offset-md-1">
                            <div class="card">
                                <div class="card-body">
                                    <span>
                                        <span class="fw-bold">NOMBRE :</span> {{ $credit->client->id }} - {{ $credit->client->name }} {{ $credit->client->last_name }} {{ $credit->client->second_last_name }}
                                        <br> <span class="fw-bold">RFC :</span>  {{ $credit->client->rfc }}
                                        <br><span class="fw-bold">Organización :</span>  {{ $credit->client->agreement->name }}
                                        <br><span class="fw-bold">Tel :</span> : {{ $credit->client->cellphone }}
                                        <br><br>
                                        <span class="fw-bold">Producto :</span> SOD
                                        <br><span class="fw-bold">Monto :</span> SOD
                                        <br><span class="fw-bold">Plazo :</span> SOD
                                        <br><span class="fw-bold">Pago :</span> SOD
                                        <br><span class="fw-bold">Periodicidad :</span> SOD
                                        <br><span class="fw-bold">Tipo de crédito :</span> SOD
                                        <br><span class="fw-bold">Compra cartera :</span> SOD
                                        <br><span class="fw-bold">Promotor :</span> SOD
                                        <br><span class="fw-bold">Origen :</span> SOD
                                        <br><span class="fw-bold">Etiquetas :</span> SOD
                                        <br><span class="fw-bold">Ultimo comentario :</span> SOD
                                        <hr>
                                        <span class="fw-bold"> Documentos:</span>
                                        <br><a href="">- INE <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        <br><a href="">- Nómina <i class="fa-solid fa-arrow-up-right-from-square"></i></a>

                                        <hr>
                                        <br>

                                        <br><a href="">Ver crédito <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        <br><a href="">Ver cliente <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        <br><a href="">Chatear con cliente <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                        
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@include('panel.action.modal.modal_reference')
@include('panel.action.modal.modalkyc')
@endsection
