@extends('layouts.admin')
@section('title', 'Formulario financiera')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-md mx-auto">
                    <div class="nk-block-head nk-block-head-lg wide-sm">
                        <div class="nk-block-head-content">
                            
                            <h3 class="nk-block-title page-title">{{ $title }}</h3>
                            <div class="nk-block-des text-soft">
                                <nav>
                                    <ul class="breadcrumb">
                                        @if ($breadcrumb == null)
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item active"><a href="/panel/kc-check-up">KC - Check up</a>
                                            <li class="breadcrumb-item active"><a href="/panel/template/steps/{{ Request::segment(4) }}/{{  $history->id }}/show">Etapas</a>
                                            <li class="breadcrumb-item active"><a href="/panel/template/actions/{{ Request::segment(4) }}/{{  $history->id }}/show">Acciones</a>
                                            <li class="breadcrumb-item active">Acción formulario </li>
                                        @else
                                        {!!  $breadcrumb !!}
                                        @endif
                                    </ul>
                                </nav>
                                
                            </div>
                            <div class=" d-block d-md-none">
                                <div class="col-12">
                                    <span class="text-primary overline-title small">
                                        @if ($product != null)
                                            {{ $product->alias }}
                                        @endif
                                    </span>
                                </div>
                                <div class="col-12">
                                    <span class="text-primary overline-title small">
                                        @if ($credit != null)
                                            {{ $credit->id }} - {{ $client->name }} {{ $client->last_name }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-block-head-content d-none d-md-block">
                            <div class="col-12">
                                <span class="text-primary overline-title small">
                                    @if ($product != null)
                                        {{ $product->alias }}
                                    @endif
                                </span>
                            </div>
                            <div class="col-12">
                                <span class="text-primary overline-title small">
                                    @if ($credit != null)
                                        {{ $credit->id }} - {{ $client->name }} {{ $client->last_name }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg mt-n3">
                        <p>* Campos obligatorios</p>
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div class="preview-block">
                                    <div class="row gy-4">
                                        {!! $form !!}
                                        <input type="hidden" id="id_rel" value="{{ $id_rel }}">
                                    </div>
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
