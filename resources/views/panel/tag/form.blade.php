@extends('layouts.admin')
@section('title', 'Formulario etiquetas')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-md mx-auto">
                    <div class="nk-block-head nk-block-head-lg wide-sm">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Etiquetas</h3>
                            <div class="nk-block-des text-soft">
                                <nav>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                        <li class="breadcrumb-item "> <a href="/panel/tag">Etiquetas</a> </li>
                                        <li class="breadcrumb-item active"> Formulario </li>
                                    </ul>
                                </nav>
                            </div>
                           
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div class="preview-block">
                                    <div class="row gy-4">
                                        <form method="post" id="frm-tag" action="">
                                            @csrf
                                            @php
                                                $types    = config('enums.type_tags');
                                                $sections = config('enums.type_section');
                                            @endphp
                                            <div class="row gy-4">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">*Etiqueta</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data[name]" id="frm-tag-name" class="form-control">
                                                            <label id="frm-tag-name-unique-error" class="error"  style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">*Tipo</label>
                                                        <div class="form-control-wrap">
                                                            <select class="form-select js-select2" name="data[type_id]" id="frm-tag-type_id"   data-search="on">
                                                                @if ($tag_id == null)
                                                                    <option value="">Escribe para buscar</option>
                                                                @endif
                                                                @foreach ($types as $key => $type)
                                                                    <option value="{{ $key }}">  {{ $type }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="form-label">*Sección</label>
                                                        <div class="form-control-wrap">
                                                            <select class="form-select js-select2" name="data[section_id]" id="frm-tag-section_id"   data-search="on">
                                                                @if ($tag_id == null)
                                                                    <option value="">Escribe para buscar</option>
                                                                @endif
                                                                
                                                                @foreach ($sections as $key_section => $section)
                                                                    <option value="{{ $key_section }}"> {{ $key_section }} {{ $section }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group"><label class="form-label">Descripción</label>
                                                        <div class="form-control-select">
                                                           <textarea name="data[comment]" id="frm-tag-comment" cols="30" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"><label class="form-label">*Status</label>
                                                        <div class="form-control-select">
                                                            <select
                                                                name="data[status]"
                                                                class="form-control" 
                                                                id="frm-tag-status" >
                                                                @if ($tag_id == null)
                                                                    <option value="">Escribe para buscar</option>
                                                                @endif
            
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="tag_id" name="tag_id" value="{{ $tag_id }}">
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
                        </div><!-- .card-preview -->
                       
                    </div><!-- .nk-block -->
                   
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>
@endsection