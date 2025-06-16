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
                                        @include('panel.credit.right_bar')
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

{{-- modal editar compra cartera --}}
<div class="modal fade" id="modal-compra-cartera-cd" tabindex="-1" aria-labelledby="modal-compra-cartera-cdLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="frm-modal-compra-cartera-cd">
            <div class="modal-header">
              <h5 class="modal-title" id="modal-compra-cartera-cd-title">Compra de cartera</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">*Saldo total</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="data[ammount]" id="compra-cartera-ammount" min="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="creditPayOffId" id="creditPayOffId" value="">
                <input type="hidden" name="credit_id"  value="{{ $id_rel }}">
                
              <button type="submit" class="btn btn-secondary">Guardar</button>
            </div>
        </form>
      </div>
    </div>
  </div>

@include('panel.action.modal.modal_reference')
@include('panel.action.modal.modalkyc')
@endsection
