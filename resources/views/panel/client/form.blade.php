@extends('layouts.admin')
@section('title', 'Formulario prospecto')

@inject('m_agreement', 'App\Models\Agreement')
@inject('product', 'App\Models\Product')
@inject('user', 'App\Models\User')

@section('content')


    @php
    $agreements   = $m_agreement->getAllActive();
    $products     = $product->getAll();
    $origins      = config('enums.origin');
    $advisors     = $user->getUserRole('Asesor');
    $temperatures = config('enums.temperatures');
    $user         = Auth::user();
    $types        = config('enums.type_client');
    @endphp
         <div class="nk-content">
            <div class="container-fluid">
                <div class="nk-content-inner">
                    <div class="nk-content-body">
                        <div class="components-preview wide-md mx-auto">
                            <div class="nk-block-head nk-block-head-lg wide-sm">
                                <div class="nk-block-head-content">
                                    
                                    <h3 class="nk-block-title page-title">Cliente</h3>
                                    <div class="nk-block-des text-soft">
                                        <nav>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                                <li class="breadcrumb-item">Configuración</li>
                                                <li class="breadcrumb-item active"><a href="/panel/clients">Clientes</a></li>
                                            </ul>
                                        </nav>
                                        
                                    </div>
                                   
                                </div>
                               
                            </div><!-- .nk-block-head -->
                            <div class="nk-block nk-block-lg ">
                                <p>* Campos obligatorios</p>
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                        <div class="preview-block">
                                            <div class="row gy-4">
                                                <form method="post" id="frm-client" action="">
                                                    @csrf
                                                    <div class="row gy-4">
                                                        <span class="preview-title-lg overline-title">General</span>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Celular</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[cellphone]"  id="client-cellphone" >
                                                                    <label id="cellphone-msg" class="text-danger"></label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">*Nombres</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[name]" id="client-name" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Primer apellido</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[last_name]"  id="client-last_name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Segundo apellido</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[second_last_name]"  id="client-second_last_name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Fecha de nacimiento</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="date" class="form-control" name="data[birth_date]"  id="client-birth_date">
                                                                </div>
                                                            </div>
                                                        </div>
                                                      
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">RFC</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" name="data[rfc]" minlength="10" id="client-rfc" >
                                                                    <label id="rfc-msg" class="text-danger"></label>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Email</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="email" class="form-control" name="data[email]"  id="client-email">
                                                                    <label id="email-msg" class="text-danger"></label>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                       

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Organización</label>
                                                                <div class="form-control-wrap">
                                                                   
                                                                    <select class="form-select js-select2" name="data[agreement_id]" id="client-agreement"  data-search="on">
                                                                        <option></option>
                                                                        @foreach ($agreements as $agreement)
                                                                            <option value="{{ $agreement->id }}">{{ $agreement->name }}</option>
                                                                        @endforeach
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="form-label">Status</label>
                                                                <div class="form-control-select">
                                                                    @php
                                                                        $list_status = config('enums.status');
                                                                    @endphp
                                                                    <select
                                                                        name="data[active]"
                                                                        class="form-control" 
                                                                        id="client-status" >
                                                                        @foreach ($list_status as $key => $get_status)
                                                                            <option value="{{ $key }}"> {{ $get_status }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     
                
                                                        <input type="hidden" id="client_id" name="client_id" value="{{ $client_id }}">
                                                        <div class="col-12">
                                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                <li>
                                                                    {{-- <a href="#" data-bs-dismiss="modal" class="btn btn-primary"></a> --}}
                                                                    <button class="btn btn-primary" id="btnSave">Guardar</button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .card-preview -->
                               
                            </div><!-- .nk-block -->
                           
                        </div><!-- .components-preview -->
                    </div>
                </div>
            </div>
        </div>
@endsection
