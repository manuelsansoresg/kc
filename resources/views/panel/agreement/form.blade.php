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
                                                <input type="text" name="data[name]" id="agreement-name" class="form-control">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Descripcion</label>
                                            <div class="form-control-wrap">
                                              
                                                <textarea name="data[description]" id="agreement-description" cols="30" rows="4" class="form-control"></textarea>
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
                                                        <option value="{{ $key }}"> {{ $get_status }} </option>
                                                    @endforeach
                                                </select>
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