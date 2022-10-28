@extends('layouts.admin')
@section('title', 'Formulario referencias')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-md mx-auto">
                    <div class="nk-block-head nk-block-head-lg wide-sm">
                        <div class="nk-block-head-content">

                            <h3 class="nk-block-title page-title">Referencia</h3>
                            <div class="nk-block-des text-soft">
                                <nav>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                        <li class="breadcrumb-item "> <a href="/panel/tag">Financiera</a> </li>
                                        <li class="breadcrumb-item "> <a
                                                href="/panel/financial/edit?tab=productos">Formulario</a> </li>
                                        <li class="breadcrumb-item active"> Formulario Producto </li>
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
                                        <form method="post" id="frm-credit-reference" action="">
                                            <div class="row gy-4">
                                                @csrf
                                                @php
                                                    $last_name                  = $reference_id!= null ? $reference->last_name : null;
                                                    $second_lastname            = $reference_id!= null ? $reference->second_lastname : null;
                                                    $names                      = $reference_id!= null ? $reference->names : null;
                                                    $relationship               = $reference_id!= null ? $reference->relationship : null;
                                                    $relationship_time_years    = $reference_id!= null ? $reference->relationship_time_years : null;
                                                    $relationship_time_months   = $reference_id!= null ? $reference->relationship_time_months : null;
                                                    $cel_phone                  = $reference_id!= null ? $reference->cel_phone : null;
                                                    $local_phone                = $reference_id!= null ? $reference->local_phone : null;
                                                    $contact_time               = $reference_id!= null ? $reference->contact_time : null;
                                                    $postal_code                = $reference_id!= null ? $reference->postal_code : null;
                                                    $street                     = $reference_id!= null ? $reference->street : null;
                                                    $home_external_number       = $reference_id!= null ? $reference->home_external_number : null;
                                                    $home_internal_number       = $reference_id!= null ? $reference->home_internal_number : null;
                                                    $colony                     = $reference_id!= null ? $reference->colony : null;
                                                    $city                       = $reference_id!= null ? $reference->city : null;
                                                    $state                      = $reference_id!= null ? $reference->state : null;
                                                    $country                    = $reference_id!= null ? $reference->country : null;
                                                    $note                       = $reference_id!= null ? $reference->note : null;
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">*Primer apellido</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[last_name]"
                                                                class="form-control"
                                                                required
                                                                value="{{ $last_name }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">*Segundo apellido</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[second_lastname]"
                                                                class="form-control"
                                                                required
                                                                value="{{ $second_lastname }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">*Nombres</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[names]"
                                                                class="form-control"
                                                                required
                                                                value="{{ $names }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Relación</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[relationship]"
                                                                class="form-control"
                                                                value="{{ $relationship }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Años de relación</label>
                                                        <div class="form-control-wrap">
                                                            <input type="number" name="data_reference[relationship_time_years]"
                                                                class="form-control"
                                                                value="{{ $relationship_time_years }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Meses de relación</label>
                                                        <div class="form-control-wrap">
                                                            <input type="number" name="data_reference[relationship_time_months]"
                                                                class="form-control"
                                                                value="{{ $relationship_time_months }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">*Tel. Celular</label>
                                                        <div class="form-control-wrap">
                                                            <input type="number" name="data_reference[cel_phone]"
                                                                class="form-control"
                                                                required
                                                                value="{{ $cel_phone }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Tel. Fijo</label>
                                                        <div class="form-control-wrap">
                                                            <input type="number" name="data_reference[local_phone]"
                                                                class="form-control"
                                                                value="{{ $local_phone }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Horario de contacto</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[contact_time]"
                                                                class="form-control"
                                                                value="{{ $contact_time }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Código postal</label>
                                                        <div class="form-control-wrap">
                                                            <input type="number" name="data_reference[postal_code]"
                                                                class="form-control"
                                                                value="{{ $postal_code }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Calle</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[street]"
                                                                class="form-control"
                                                                value="{{ $street }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Número exterior.</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[home_external_number]"
                                                                class="form-control"
                                                                value="{{ $home_external_number }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Número interior</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[home_internal_number]"
                                                                class="form-control"
                                                                value="{{ $home_internal_number }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Colonia</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[colony]"
                                                                class="form-control"
                                                                value="{{ $colony }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Municipio</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[city]"
                                                                class="form-control"
                                                                value="{{ $city }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Estado</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[state]"
                                                                class="form-control"
                                                                value="{{ $state }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">País</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" name="data_reference[country]"
                                                                class="form-control"
                                                                value="{{ $country }}">
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="frm-product-name">Comentario</label>
                                                        <div class="form-control-wrap">
                                                            <textarea type="text" name="data_reference[note]"
                                                                class="form-control"
                                                                value="">{{ $note }}</textarea>
                                                                <label id="product-name-unique-error"
                                                                class="error" style="display: none"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                             
                                                <div class="col-12">
                                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                        <li>
                                                            <button class="btn btn-primary">Guardar</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <input type="hidden" name="history_id" id="history_id" value="{{ $history_id }}">
                                            <input type="hidden" name="reference_id" id="reference_id" value="{{ $reference_id }}">
                                        </form>

                                       
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

@endsection