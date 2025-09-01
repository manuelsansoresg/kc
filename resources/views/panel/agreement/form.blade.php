@extends('layouts.admin')
@section('title', 'Formulario convenio')
@inject('m_financial_product', 'App\Models\FinancialProduct')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Convenios</h3>
                            <div class="nk-block-des text-soft">
                                <nav>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                        <li class="breadcrumb-item">Configuración</li>
                                        <li class="breadcrumb-item active"><a href="/panel/agreement">Convenio</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-body">
                            <form method="post" id="frm-agreement" action="">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="frm-product-name">Nombre</label>
                                            <div class="form-control-wrap">
                                                @php
                                                    $products = $m_financial_product->getAll();
                                                @endphp
                                                <input type="text" name="data[name]" id="agreement-name" class="form-control" value="{{ isset($agreement) ? $agreement->name : '' }}">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="frm-product-name">Razón social</label>
                                            <div class="form-control-wrap">
                                              
                                                <input type="text" name="data[razon_social]" id="razon_social" class="form-control" value="{{ isset($agreement) ? $agreement->razon_social : '' }}">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Descripcion</label>
                                            <div class="form-control-wrap">
                                              
                                                <textarea name="data[description]" id="agreement-description" cols="30" rows="4" class="form-control">{{ isset($agreement) ? $agreement->description : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="frm-product-name">Productos financieros</label>
                                            <div class="form-control-wrap">
                                                <select class="form-select select2multiple" multiple="multiple" name="products[]" id="agreement-financials"   data-search="on">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"> {{ $product->commercial_name}} - {{ $product->name }} </option>
                                                @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="frm-product-name">*Vigencia</label>
                                            <div class="form-control-wrap">
                                               <input type="date" class="form-control" name="data[agreement_term]" id="agreement_term" value="{{ isset($agreement) ? $agreement->agreement_term : '' }}" required>
                                                
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
                                                    name="data[status]"
                                                    class="form-control" 
                                                    id="agreement-status" >
                                                    @foreach ($list_status as $key => $get_status)
                                                        <option value="{{ $key }}" {{ isset($agreement) && $agreement->status == $key ? 'selected' : '' }}> {{ $get_status }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label class="form-label">Esquema de fecha SOD</label>
                                            <div class="form-control-select">
                                                
                                                <select
                                                    name="data[sod_schedule_id]"
                                                    class="form-control" 
                                                    id="sod_schedule_id" >
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach ($sodNames as $sodName)
                                                        <option value="{{ $sodName->id }}" {{ isset($agreement) && $agreement->sod_schedule_id == $sodName->id ? 'selected' : '' }}> {{ $sodName->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group"><label class="form-label"></label>
                                           <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" 
                                                        class="custom-control-input" 
                                                        name="data[auto_go_ahead]" 
                                                        id="auto_go_ahead"
                                                        value="1"
                                                        {{ isset($agreement->auto_go_ahead) && $agreement->auto_go_ahead ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="auto_go_ahead">Auto Go Ahead</label>
                                                </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="agreement_id" name="agreement_id" value="{{ $agreement_id }}">
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                {{-- <a href="#" data-bs-dismiss="modal" class="btn btn-primary"></a> --}}
                                                <button class="btn btn-primary">Guardar</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection