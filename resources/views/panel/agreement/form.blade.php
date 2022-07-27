@extends('layouts.admin')
@section('title', 'Formulario convenio')
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
                        <div class="nk-block-head-content">
                            <a href="/panel/agreement/create" class="btn btn-icon btn-primary"><em
                                    class="icon ni ni-plus"></em></a>
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
                                                    $name = ($agreement != null) ? $agreement->name : ''
                                                @endphp
                                                <input type="text" name="data[name]" id="name" class="form-control" value="{{ $name }}">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Descripcion</label>
                                            <div class="form-control-wrap">
                                                @php
                                                $description = ($agreement != null) ? $agreement->description : ''
                                            @endphp
                                                <textarea name="data[description]" id="comment" cols="30" rows="4" class="form-control">{{ $description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"><label class="form-label">Status</label>
                                            <div class="form-control-select">
                                                @php
                                                    $list_status = config('enums.status');
                                                    $status = ($agreement != null) ? $agreement->status : ''
                                                @endphp
                                                <select
                                                    name="data[status]"
                                                    class="form-control" 
                                                    id="status" >
                                                    @foreach ($list_status as $key => $get_status)
                                                        <option value="{{ $key }}" {{ ($status == $key) ? 'selected' : ''}} > {{ $get_status }} </option>
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