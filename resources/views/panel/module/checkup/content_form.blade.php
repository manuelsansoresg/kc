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
                                    @if ($model == 'kc-down-wallet' && $clienteInversionista != null)
                                        
                                        <div id="content-legend-kc-down-bank" class="py-2" >
                                            <div class="alert alert-primary " role="alert">
                                                El dinero se depositará en máximo un día hábil.
                                                <br><br>Cuenta de retiro:
                                                <br>Banco: {{ $clienteInversionista->bank_name }}
                                                <br>Clabe: {{ $clienteInversionista->bank_clabe }}
                                                <br><br> Si deseas cambiar tu cuenta de retiro, comunícate con nosotros.
                                            </div>
                                        </div>
                                    @endif
                                    <div id="content-legend"></div>
                                    <p>* Campos obligatorios</p>
                                    <div class="row gy-4">
                                        {!! $form !!}
                                        <input type="hidden" id="id_rel" value="{{ $id_rel }}">
                                    </div>

                                    
                                    
                                
                                </div>
                            </div>
                        </div>
                        @if ($credit != null)
                            
                            <div class="col-md-3 d-none d-md-block offset-md-1">
                                <div class="card">
                                    <div class="card-body">
                                        <span>
                                            <span class="fw-bold">Nombre:</span> {{ $credit->client->id }} - {{ $credit->client->name }} {{ $credit->client->last_name }} {{ $credit->client->second_last_name }}
                                            <br> <span class="fw-bold">RFC:</span>  {{ $credit->client->rfc }}
                                            <br><span class="fw-bold">Organización:</span>  {{ $credit->client->agreement->name }}
                                            <br><span class="fw-bold">Tel:</span>  {{ $credit->client->cellphone }}
                                            <br><br>
                                            <span class="fw-bold">Producto:</span> {{ $product->alias }}
                                            <br><span class="fw-bold">Monto:</span> {{ format_price($credit->applied_import) }}
                                            <br><span class="fw-bold">Plazo:</span> {{ format_price($credit->applied_term) }}
                                            <br><span class="fw-bold">Pago:</span> {{ format_price($credit->applied_payment) }}
                                            <br><span class="fw-bold">Periodicidad:</span> {{ $periodicity }}
                                            <br><span class="fw-bold">Tipo de crédito:</span> {{ $tipoCredito->alias}}
                                            <br><span class="fw-bold">Compra cartera:</span> {{ format_price($credit->third_party_adjustment) }}
                                            <br><span class="fw-bold">Asesor:</span> {{ $getAsesor != null ? $getAsesor->name.' '.$getAsesor->last_name.' '.$getAsesor->second_last_name : null}}
                                            <br><span class="fw-bold">Origen:</span> {{ $origin }}
                                            <br><span class="fw-bold">Etiquetas:</span> {{ $tags }}
                                            <br><span class="fw-bold">Ultimo comentario:</span> {{ $lastComment!= null ? $lastComment->comment : null }}
                                            <hr>
                                            <span class="fw-bold"> Documentos:</span>
                                        
                                            <table class="table table-borderless">
                                                @foreach ($files as $file)
                                                <tr class="">
                                                    <td class="">
                                                        <a href="{{ asset($path.'/'.$file['name']) }}" target="_blank">{{ $file['name_template'] }}</a>
                                                    </td>

                                                </tr>
                                                @endforeach
                                            </table>

                                            <hr>
                                            <br>

                                            <br><a href="/panel/credit/{{ $credit->id }}">Ver crédito <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                            <br><a href="/panel/client/{{ $client->id }}">Ver cliente <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                            <br><a href="/https://manychat.com/fb861553/chat/">Chatear con cliente <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                            
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@include('panel.action.modal.modal_reference')
@include('panel.action.modal.modalkyc')
@endsection
