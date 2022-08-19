@extends('layouts.admin')
@section('title', 'Formulario financiera')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Financiera</h3>
                            <div class="nk-block-des text-soft">
                                <nav>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                        <li class="breadcrumb-item "> <a href="/panel/tag">Financiera</a> </li>
                                        <li class="breadcrumb-item active"> Formulario </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-body">
                            <form method="post" id="frm-financial" action="">
                                @csrf
                                @php
                                    $commercial_name = ($financial != null)? $financial->commercial_name : '';
                                    $company_name = ($financial != null)? $financial->company_name : '';
                                @endphp
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="frm-product-name">*Nombre comerial</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="commercial_name"  class="form-control" value="{{ $commercial_name}}">
                                                <label id="financial-commercial_name-unique-error" class="error"  style="display: none"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="frm-product-name">*Razón social</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="company_name"  class="form-control" value="{{ $company_name}}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" id="financial_id" name="financial_id" value="{{ $financial_id }}">
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