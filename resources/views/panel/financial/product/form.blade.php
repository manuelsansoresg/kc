@extends('layouts.admin')
@section('title', 'Formulario productos')


@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block-head nk-block-head-lg wide-sm">
                            <div class="nk-block-head-content">

                                <h3 class="nk-block-title page-title">Producto</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item "> <a href="/panel/tag">Financiera</a> </li>
                                            <li class="breadcrumb-item "> <a
                                                    href="/panel/financial/{{ $financial_id }}/edit?tab=productos">Formulario</a>
                                            </li>
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
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab"
                                                        href="#tabInfoProduct">Info de producto</a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $product_id != null ? '#tabInfoCredit' : '#' }}">Info del
                                                        crédito</a> </li>

                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $product_id != null ? '#tabRequisitos' : '#' }}">Requisitos</a>
                                                </li>

                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $product_id != null ? '#tabComision' : '#' }}">Comisiones</a>
                                                </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $product_id != null ? '#tabContract' : '#' }}">Contrato</a>
                                                </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $product_id != null ? '#tabRate' : '#' }}">Calificación
                                                        KC</a>
                                                </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $product_id != null ? '#tabChart' : '#' }}">Gráficas</a>
                                                </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $product_id != null ? '#tabTramite' : '#' }}">Trámite</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content">

                                                <div class="tab-pane active" id="tabInfoProduct">
                                                    @php
                                                        $list_status = config('enums.status');
                                                        $type_products = config('financial_enums.type_products');
                                                        $name = $financial_product != null ? $financial_product->name : '';
                                                        $alias = $financial_product != null ? $financial_product->alias : '';
                                                        $type_product_id = $financial_product != null ? $financial_product->type_product_id : '';
                                                        $status = $financial_product != null ? $financial_product->status : '';
                                                        $bank_id = $financial_product != null ? $financial_product->bank_id : '';
                                                        $consulta_buro = $financial_product != null ? $financial_product->consulta_buro : null;
                                                        $is_vincular_banco = $financial_product != null ? $financial_product->is_vincular_banco : null;
                                                        $aval_o_garantia = $financial_product != null ? $financial_product->aval_o_garantia : null;
                                                    @endphp
                                                    <form method="post" id="frm-product-info" action="">
                                                        <div class="row gy-4">
                                                            @csrf
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">*Nombre
                                                                        del
                                                                        producto</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="name"
                                                                            class="form-control"
                                                                            value="{{ $name }}">
                                                                        <label id="product-name-unique-error" class="error"
                                                                            style="display: none"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Alias
                                                                        del
                                                                        producto</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="alias"
                                                                            class="form-control"
                                                                            value="{{ $alias }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Tipo de
                                                                        producto</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="type_product_id" id=""
                                                                            class="form-select">
                                                                            @foreach ($type_products as $key => $type_products)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $type_product_id == $key ? ' selected' : '' }}>
                                                                                    {{ $type_products }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Regulación</label>
                                                                    <div class="form-control-wrap">
                                                                        <ul
                                                                            class="custom-control-group g-3 align-center flex-wrap">
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        id="regulacion_active"
                                                                                        name="regulacion" value="1"
                                                                                        {{ $financial_product != null && $financial_product->regulacion == 1 ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="regulacion_active">No regulado
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        id="regulacion_pending"
                                                                                        name="regulacion" value="2"
                                                                                        {{ $financial_product != null && $financial_product->regulacion === 2 ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="regulacion_pending">CONDUSEF</label>
                                                                                </div>
                                                                            </li>

                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        id="regulacion_pending2"
                                                                                        name="regulacion" value="3"
                                                                                        {{ $financial_product != null && $financial_product->regulacion === 3 ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="regulacion_pending2">PROFECO</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Opción para tramitar</label>
                                                                    <div class="form-control-wrap">
                                                                        <ul
                                                                            class="custom-control-group g-3 align-center flex-wrap">
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        id="is_tramitar_active"
                                                                                        name="is_tramitar" value="1"
                                                                                        {{ ($financial_product != null && $financial_product->is_tramitar == 1) || ($financial_product != null && $financial_product->is_tramitar == null) ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="is_tramitar_active">Sí
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        id="is_tramitar_pending"
                                                                                        name="is_tramitar" value="0"
                                                                                        {{ $financial_product != null && $financial_product->is_tramitar === 0 ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="is_tramitar_pending">No</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">&nbsp;</div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Vincular banco</label>
                                                                    <div class="form-control-wrap">
                                                                        <ul
                                                                            class="custom-control-group g-3 align-center flex-wrap">
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        onclick="showBank(true)"
                                                                                        id="vincular_banco_active"
                                                                                        name="is_vincular_banco"
                                                                                        value="1"
                                                                                        {{ $is_vincular_banco == 1 ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="vincular_banco_active">Sí
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        onclick="showBank(false)"
                                                                                        id="vincular_banco_pending"
                                                                                        name="is_vincular_banco"
                                                                                        value="0"
                                                                                        {{ $is_vincular_banco === 0 || $is_vincular_banco === null ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="vincular_banco_pending">No</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" id="content-bank"
                                                                style="{{ $is_vincular_banco == 1 ? 'display: block' : 'display: none' }}">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Banco</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="bank_id" id=""
                                                                            class="form-select">
                                                                            <option value="">Selecciona una opción
                                                                            </option>
                                                                            @foreach ($banks as $bank)
                                                                                <option value="{{ $bank->id }}"
                                                                                    {{ $bank->id == $bank_id ? ' selected' : '' }}>
                                                                                    {{ $bank->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Consulta buro</label>
                                                                    <div class="form-control-wrap">
                                                                        <ul
                                                                            class="custom-control-group g-3 align-center flex-wrap">
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        id="consulta_buro_active"
                                                                                        name="consulta_buro"
                                                                                        value="1"
                                                                                        {{ $consulta_buro == 1 || $consulta_buro === null ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="consulta_buro_active">Sí
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        id="consulta_buro_pending"
                                                                                        name="consulta_buro"
                                                                                        value="0"
                                                                                        {{ $consulta_buro === 0 ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="consulta_buro_pending">No</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Estatus</label>
                                                                    <div class="form-control-wrap">
                                                                        <select class="form-select" name="status"
                                                                            id="frm-register-action-state">
                                                                            @foreach ($list_status as $key => $list_status)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $status == $key ? ' selected' : '' }}>
                                                                                    {{ $list_status }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Aval o garantía</label>
                                                                    <div class="form-control-wrap">
                                                                        <ul
                                                                            class="custom-control-group g-3 align-center flex-wrap">
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        id="aval_o_garantia_active"
                                                                                        name="aval_o_garantia"
                                                                                        value="1"
                                                                                        {{ $aval_o_garantia == 1 ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="aval_o_garantia_active">Sí
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio"
                                                                                        class="custom-control-input"
                                                                                        id="aval_o_garantia_pending"
                                                                                        name="aval_o_garantia"
                                                                                        value="0"
                                                                                        {{ $aval_o_garantia === 0 ? 'checked' : null }}>
                                                                                    <label class="custom-control-label"
                                                                                        for="aval_o_garantia_pending">No</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <input type="hidden" id="financial_id" name="financial_id"
                                                                value="{{ $financial_id }}">
                                                            <input type="hidden" id="product_id" name="product_id"
                                                                value="{{ $product_id }}">
                                                            <input type="hidden" name="is_required" value="true">
                                                            <div class="col-12">
                                                                <ul
                                                                    class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                    <li>
                                                                        <button class="btn btn-primary">Guardar</button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tabInfoCredit">
                                                    @php
                                                        $colateral_products = config('financial_enums.colateral_products');
                                                        $periodicity_products = config('financial_enums.periodicity_products');
                                                        $interes_rates = config('financial_enums.interes_rates');
                                                        $principal_pays = config('financial_enums.principal_pays');

                                                        $collateral_id = $financial_product != null ? $financial_product->collateral_id : '';
                                                        $periodicity_id = $financial_product != null ? $financial_product->periodicity_id : '';
                                                        $max_credit_amount = $financial_product != null ? $financial_product->max_credit_amount : '';

                                                        $min_deadline_month = $financial_product != null ? $financial_product->min_deadline_month : '';
                                                        $max_deadline_month = $financial_product != null ? $financial_product->max_deadline_month : '';
                                                        $type_interest = $financial_product != null ? $financial_product->type_interest : '';
                                                        $pay_form = $financial_product != null ? $financial_product->pay_form : '';
                                                        $annual_int_rate_iva = $financial_product != null ? $financial_product->annual_int_rate_iva : '';
                                                        $real_cat = $financial_product != null ? $financial_product->real_cat : '';
                                                        $principal_pay = $financial_product != null ? $financial_product->principal_pay : '';
                                                        $resolution_time_hours = $financial_product != null ? $financial_product->resolution_time_hours : '';
                                                        $delivery_time_hours = $financial_product != null ? $financial_product->delivery_time_hours : '';
                                                        $moratorium_int_rate_vat = $financial_product != null ? $financial_product->moratorium_int_rate_vat : '';
                                                        $min_loan_amount = $financial_product != null ? $financial_product->min_loan_amount : '';
                                                        $means_channels_of_disposal = $financial_product != null ? $financial_product->means_channels_of_disposal : '';
                                                        $coverage = $financial_product != null ? $financial_product->coverage : '';
                                                        $purpose_of_loan = $financial_product != null ? $financial_product->purpose_of_loan : '';
                                                        $minimum_interest_rate = $financial_product != null ? $financial_product->minimum_interest_rate : '';
                                                    @endphp
                                                    <form method="post" id="frm-financial-buro" action="">
                                                        <div class="row gy-4">
                                                            @csrf
                                                            <span class="preview-title-lg overline-title"> Características
                                                            </span>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Colateral (Garantía)</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="collateral_id" id=""
                                                                            class="form-select">
                                                                            @foreach ($colateral_products as $key => $colateral_product)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $status == $key ? ' selected' : '' }}>
                                                                                    {{ $colateral_product }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Periodicidad</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="periodicity_id[]"
                                                                            id="product_periodicity_id"
                                                                            class="form-select select2multiple"
                                                                            multiple="multiple" data-search="on">
                                                                            @foreach ($periodicity_products as $key => $periodicity_product)
                                                                                <option value="{{ $key }}">
                                                                                    {{ $periodicity_product }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Monto
                                                                        máximo de crédito</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="max_credit_amount"
                                                                            class="form-control"
                                                                            value="{{ $max_credit_amount }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Monto
                                                                        minimo del crédito</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="min_loan_amount"
                                                                            class="form-control"
                                                                            value="{{ $min_loan_amount }}">
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Plazo
                                                                        mínimo en meses</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="min_deadline_month"
                                                                            class="form-control"
                                                                            value="{{ $min_deadline_month }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Plazo
                                                                        máximo en meses</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="max_deadline_month"
                                                                            class="form-control"
                                                                            value="{{ $max_deadline_month }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Tipo
                                                                        de interés</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="type_interest" id=""
                                                                            class="form-select">
                                                                            @foreach ($interes_rates as $key => $interes_rate)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $type_interest == $key ? ' selected' : '' }}>
                                                                                    {{ $interes_rate }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Tasa
                                                                        de interés mínima anual con IVA</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="minimum_interest_rate"
                                                                            step="0.01" min="0"
                                                                            class="form-control"
                                                                            value="{{ $minimum_interest_rate }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">tasa
                                                                        de interés máxima anual con IVA</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="annual_int_rate_iva"
                                                                            class="form-control"
                                                                            step="0.01" min="0"
                                                                            value="{{ $annual_int_rate_iva }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Medio
                                                                        de pago</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="principal_pay[]"
                                                                            id="product-principal_pay"
                                                                            class="form-select select2multiple"
                                                                            multiple="multiple" data-search="on">
                                                                            @foreach ($principal_pays as $key => $principal_pays)
                                                                                <option value="{{ $key }}">
                                                                                    {{ $principal_pays }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Tiempo de resolución en
                                                                        horas</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="resolution_time_hours"
                                                                            class="form-control"
                                                                            value="{{ $resolution_time_hours }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Tiempo de entrega en
                                                                        horas</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="delivery_time_hours"
                                                                            class="form-control"
                                                                            value="{{ $delivery_time_hours }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Tasa
                                                                        de interés moratoria con IVA</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number"
                                                                            name="moratorium_int_rate_vat"
                                                                            class="form-control"
                                                                            step="0.01" min="0"
                                                                            value="{{ $moratorium_int_rate_vat }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Medios y canales de
                                                                        disposición</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text"
                                                                            name="means_channels_of_disposal"
                                                                            class="form-control"
                                                                            value="{{ $means_channels_of_disposal }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Cobertura</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="coverage"
                                                                            class="form-control"
                                                                            value="{{ $coverage }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Destino del crédito</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="purpose_of_loan"
                                                                            class="form-control"
                                                                            value="{{ $purpose_of_loan }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-md-6 mt-3">
                                                                        <span class="preview-title-lg overline-title">
                                                                            Alcance o beneficios <a onclick="modalComplementary(1)"
                                                                                class="mt-n2 btn btn-outline-primary float-end">Agregar</a>
                                                                        </span>
                                                                        <div class="form-group">
                                                                            <div class="form-control-wrap">
                                                                                <select name="alcance_beneficios[]"
                                                                                    class="form-select select2multiple"
                                                                                    id="alcance_beneficios"
                                                                                    multiple="multiple" data-search="on">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-3">
                                                                        <span class="preview-title-lg overline-title">
                                                                            Restricciones o exclusiones <a onclick="modalComplementary(2)"
                                                                                class="mt-n2 btn btn-outline-primary float-end">Agregar</a>
                                                                        </span>
                                                                        <div class="form-group">
                                                                            <div class="form-control-wrap">
                                                                                <select name="restriccion_exclusion[]"
                                                                                    class="form-select select2multiple"
                                                                                    id="restriccion_exclusion"
                                                                                    multiple="multiple" data-search="on">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-5">
                                                                        <span class="preview-title-lg overline-title">
                                                                            Programas de educacion financiera <a
                                                                                onclick="modalComplementary(3)"
                                                                                class="mt-n2 btn btn-outline-primary float-end">Agregar</a>
                                                                        </span>
                                                                        <div class="form-group">
                                                                            <div class="form-control-wrap">
                                                                                <select
                                                                                    name="programa_educacion_financiera[]"
                                                                                    class="form-select select2multiple"
                                                                                    id="programa_educacion_financiera"
                                                                                    multiple="multiple" data-search="on">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mt-5">
                                                                        <span class="preview-title-lg overline-title">
                                                                            Referencias corporativas <a onclick="modalComplementary(4)"
                                                                                class="mt-n2 btn btn-outline-primary float-end">Agregar</a>
                                                                        </span>
                                                                        <div class="form-group">
                                                                            <div class="form-control-wrap">
                                                                                <select name="referencia_comparativa[]"
                                                                                    class="form-select select2multiple"
                                                                                    id="referencia_comparativa"
                                                                                    multiple="multiple" data-search="on">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <input type="hidden" id="financial_id" name="financial_id"
                                                                value="{{ $financial_id }}">
                                                            <input type="hidden" id="product_id" name="product_id"
                                                                value="{{ $product_id }}">
                                                            <input type="hidden" name="is_required" value="false">
                                                            <div class="col-12">
                                                                <ul
                                                                    class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                    <li>
                                                                        <button class="btn btn-primary">Guardar</button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tabRequisitos">
                                                    <form method="post" id="frm-financial-requisitos" action="">
                                                        @csrf
                                                        <div class="col-12">
                                                            <span class="preview-title-lg overline-title"> Solicitante
                                                            </span>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Tipo de persona</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" name="tipo_persona"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->tipo_persona : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Edad</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" name="edad"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->edad : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Antiguedad
                                                                            laboral</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text"
                                                                                name="antiguedad_laboral"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->antiguedad_laboral : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Antiguedad
                                                                            residencial</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text"
                                                                                name="antiguedad_residencial"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->antiguedad_residencial : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Ingreso minimo
                                                                            mensual</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" name="ingreso_minimo"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->ingreso_minimo : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Buen historial
                                                                            crediticio</label>
                                                                        <div class="form-control-wrap">
                                                                            <ul
                                                                                class="custom-control-group g-3 align-center flex-wrap">
                                                                                <li>
                                                                                    <div
                                                                                        class="custom-control custom-radio">
                                                                                        <input type="radio"
                                                                                            class="custom-control-input"
                                                                                            id="buen_historial_crediticio_active"
                                                                                            name="buen_historial_crediticio"
                                                                                            value="1"
                                                                                            {{ @$financial_product->buen_historial_crediticio == 1 ? 'checked' : null }}>
                                                                                        <label class="custom-control-label"
                                                                                            for="buen_historial_crediticio_active">Sí
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                <li>
                                                                                    <div
                                                                                        class="custom-control custom-radio">
                                                                                        <input type="radio"
                                                                                            class="custom-control-input"
                                                                                            id="buen_historial_crediticio_pending"
                                                                                            name="buen_historial_crediticio"
                                                                                            value="0"
                                                                                            {{ @$financial_product->buen_historial_crediticio === 0 ? 'checked' : null }}>
                                                                                        <label class="custom-control-label"
                                                                                            for="buen_historial_crediticio_pending">No</label>
                                                                                    </div>
                                                                                </li>

                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Aval o garantía</label>
                                                                        <div class="form-control-wrap">
                                                                            <ul
                                                                                class="custom-control-group g-3 align-center flex-wrap">
                                                                                <li>
                                                                                    <div
                                                                                        class="custom-control custom-radio">
                                                                                        <input type="radio"
                                                                                            class="custom-control-input"
                                                                                            id="aval_garantia_active"
                                                                                            name="aval_garantia"
                                                                                            value="1"
                                                                                            {{ @$financial_product->aval_garantia == 1 ? 'checked' : null }}>
                                                                                        <label class="custom-control-label"
                                                                                            for="aval_garantia_active">Sí
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                <li>
                                                                                    <div
                                                                                        class="custom-control custom-radio">
                                                                                        <input type="radio"
                                                                                            class="custom-control-input"
                                                                                            id="aval_garantia_pending"
                                                                                            name="aval_garantia"
                                                                                            value="0"
                                                                                            {{ @$financial_product->aval_garantia == 0 ? 'checked' : null }}>
                                                                                        <label class="custom-control-label"
                                                                                            for="aval_garantia_pending">No</label>
                                                                                    </div>
                                                                                </li>

                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Recibir sueldo en cuenta
                                                                            de nómina</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text"
                                                                                name="recibir_sueldo_nomina"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->recibir_sueldo_nomina : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <span class="preview-title-lg overline-title"> Documentos
                                                            </span>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Identificación oficial
                                                                            vigente</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text"
                                                                                name="identificacion_oficial_vig"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->identificacion_oficial_vig : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Comprobante de
                                                                            domicilio</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text"
                                                                                name="comprobante_domicilio"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->comprobante_domicilio : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Comprobante de
                                                                            ingresos</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text"
                                                                                name="comprobante_ingresos"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->comprobante_ingresos : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="frm-product-name">Documentacion
                                                                            complementaria</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text"
                                                                                name="doc_complementaria"
                                                                                class="form-control"
                                                                                value="{{ $financial_product != null ? $financial_product->doc_complementaria : null }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="financial_id"
                                                            value="{{ $financial_id }}">
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product_id }}">

                                                        <div class="col-12 mt-3">
                                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                <li>
                                                                    <button class="btn btn-primary">Guardar</button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </form>


                                                </div>
                                                <div class="tab-pane" id="tabComision">
                                                    @php
                                                        $perc_opening_commission = $financial_product != null ? $financial_product->perc_opening_commission : '';
                                                        $means_pay_arrangements = config('financial_enums.means_pay_arrangements');
                                                        $means_pay_arrangement_id = $financial_product != null ? $financial_product->means_pay_arrangement_id : '';
                                                        $life_insurance_commission_perc = $financial_product != null ? $financial_product->life_insurance_commission_perc : '';
                                                        $means_pay_life_insurance_id = $financial_product != null ? $financial_product->means_pay_life_insurance_id : '';
                                                        $unemploy_insurance_commission_perc = $financial_product != null ? $financial_product->unemploy_insurance_commission_perc : '';
                                                        $means_pay_unemploy_insurance_id = $financial_product != null ? $financial_product->means_pay_unemploy_insurance_id : '';
                                                        $unrecognized_transactions_or_charges = $financial_product != null ? $financial_product->unrecognized_transactions_or_charges : '';
                                                        $administration_or_account_management = $financial_product != null ? $financial_product->administration_or_account_management : '';
                                                        $drawdown_of_receivables = $financial_product != null ? $financial_product->drawdown_of_receivables : '';
                                                        $non_payment = $financial_product != null ? $financial_product->non_payment : '';
                                                        $collection_costs = $financial_product != null ? $financial_product->collection_costs : '';
                                                        $inv_formalization_expenses = $financial_product != null ? $financial_product->inv_formalization_expenses : '';
                                                        $prepayment_prepaid = $financial_product != null ? $financial_product->prepayment_prepaid : '';
                                                        $late_or_untimely_pay = $financial_product != null ? $financial_product->late_or_untimely_pay : '';
                                                        $statement_reprint = $financial_product != null ? $financial_product->statement_reprint : '';
                                                        $rep_of_means_of_disposal = $financial_product != null ? $financial_product->rep_of_means_of_disposal : '';
                                                    @endphp
                                                    <form method="post" id="frm-financial-comision" action="">
                                                        <div class="row gy-4">
                                                            @csrf
                                                            <div class="col-12">
                                                                <span class="preview-title-lg overline-title">Costos de
                                                                    contratación <a
                                                                        onclick="modalProductComision({{ @$financial_product->id }}, 1)"
                                                                        class="btn btn-outline-primary  float-end">Agregar</a>
                                                                </span>
                                                                <div id="content-costo-contratacion"></div>
                                                            </div>

                                                            <div class="col-12"><span
                                                                    class="preview-title-lg overline-title">Comisiones <a
                                                                        onclick="modalProductComision({{ @$financial_product->id }}, 2)"
                                                                        class="btn btn-outline-primary float-end">Agregar</a>
                                                                </span>
                                                                <div id="comisiones"></div>
                                                            </div>



                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tabContract">
                                                    @php
                                                        $reca = $financial_product != null ? $financial_product->reca : '';
                                                        $num_reca = $financial_product != null ? $financial_product->num_reca : '';
                                                        $allows_prepayments = $financial_product != null ? $financial_product->allows_prepayments : '';
                                                        $prepayment_procedure = $financial_product != null ? $financial_product->prepayment_procedure : '';
                                                        $allows_early_term_contract = $financial_product != null ? $financial_product->allows_early_term_contract : '';
                                                        $procedure_early_term_contract = $financial_product != null ? $financial_product->procedure_early_term_contract : '';
                                                        $type_signatures = config('financial_enums.type_signatures');
                                                        $type_signature_id = $financial_product != null ? $financial_product->type_signature_id : '';
                                                        $query_credit = $financial_product != null ? $financial_product->query_credit : '';

                                                        $abusive_clause1 = $financial_product != null ? $financial_product->abusive_clause1 : '';
                                                        $abusive_clause2 = $financial_product != null ? $financial_product->abusive_clause2 : '';
                                                        $abusive_clause3 = $financial_product != null ? $financial_product->abusive_clause3 : '';
                                                        $abusive_clause4 = $financial_product != null ? $financial_product->abusive_clause4 : '';
                                                        $abusive_clause5 = $financial_product != null ? $financial_product->abusive_clause5 : '';
                                                        $abusive_clause6 = $financial_product != null ? $financial_product->abusive_clause6 : '';
                                                        $abusive_clause7 = $financial_product != null ? $financial_product->abusive_clause7 : '';
                                                        $abusive_clause8 = $financial_product != null ? $financial_product->abusive_clause8 : '';
                                                        $abusive_clause9 = $financial_product != null ? $financial_product->abusive_clause9 : '';
                                                        $abusive_clause10 = $financial_product != null ? $financial_product->abusive_clause10 : '';
                                                        $abusive_clause11 = $financial_product != null ? $financial_product->abusive_clause11 : '';
                                                        $abusive_clause12 = $financial_product != null ? $financial_product->abusive_clause12 : '';
                                                        $abusive_clause13 = $financial_product != null ? $financial_product->abusive_clause13 : '';
                                                    @endphp
                                                    <form method="post" id="frm-financial-contact" action="">
                                                        <div class="row gy-4">
                                                            @csrf
                                                            <div class="col-12"><span
                                                                    class="preview-title-lg overline-title">registro de
                                                                    contrato de adhesión</span></div>
                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">RECA</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="reca1" name="reca"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $reca == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label" for="reca1">Sí
                                                                            &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="reca2" name="reca"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $reca == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="reca2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Número RECA</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="num_reca"
                                                                            class="form-control"
                                                                            value="{{ $num_reca }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12"><span
                                                                    class="preview-title-lg overline-title">Pagos
                                                                    anticipados (Abono a capital)</span></div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Permite pagos
                                                                        anticipados</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="allows_prepayments1"
                                                                            name="allows_prepayments"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $allows_prepayments == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="allows_prepayments1">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="allows_prepayments2"
                                                                            name="allows_prepayments"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $allows_prepayments == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="allows_prepayments2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Procedimiento pagos
                                                                        anticipados</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="prepayment_procedure"
                                                                            class="form-control"
                                                                            value="{{ $prepayment_procedure }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12"><span
                                                                    class="preview-title-lg overline-title">Terminación
                                                                    aticipada de contrato</span></div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Permite
                                                                        terminación anticipada</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio"
                                                                            id="allows_early_term_contract1"
                                                                            name="allows_early_term_contract"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $allows_early_term_contract == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="allows_early_term_contract1">Sí &nbsp;
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio"
                                                                            id="allows_early_term_contract2"
                                                                            name="allows_early_term_contract"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $allows_early_term_contract == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="allows_early_term_contract2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Fórmula de pago
                                                                        (contrato)</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="pay_form"
                                                                            class="form-control"
                                                                            value="{{ $pay_form }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Procedimiento terminación
                                                                        anticipada</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number"
                                                                            name="procedure_early_term_contract"
                                                                            class="form-control"
                                                                            value="{{ $procedure_early_term_contract }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12"><span
                                                                    class="preview-title-lg overline-title">Otros</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Tipo
                                                                        de firma</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="type_signature_id" id=""
                                                                            class="form-select">
                                                                            @foreach ($type_signatures as $key => $type_signature)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $type_signature_id == $key ? ' selected' : '' }}>
                                                                                    {{ $type_signature }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Consulta de
                                                                        buró de crédito</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="query_credit1"
                                                                            name="query_credit"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $query_credit == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="query_credit1">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="query_credit2"
                                                                            name="query_credit"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $query_credit == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="query_credit2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="col-12"><span
                                                                    class="preview-title-lg overline-title">Clausulas
                                                                    abusivas</span></div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece como
                                                                        causal de vencimiento anticipado del crédito, la
                                                                        cancelación de la cuenta de depósito en la que el
                                                                        acreditado recibe su nómina.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause11" type="radio"
                                                                            name="abusive_clause1"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause1 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause11">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause12"
                                                                            name="abusive_clause1"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause1 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause12">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece como
                                                                        causal de vencimiento anticipado del crédito, que el
                                                                        acreditado termine con la relación laboral existente
                                                                        al momento de la firma.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause21" type="radio"
                                                                            name="abusive_clause2"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause2 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause21">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause22"
                                                                            name="abusive_clause2"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause2 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause22">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece que
                                                                        la acreditación del pago será hasta el momento en
                                                                        que el patrón realice la transferencia de los
                                                                        recursos a la Institución Financiera, sin señalar un
                                                                        plazo cierto para tal acreditación.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause31" type="radio"
                                                                            name="abusive_clause3"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause3 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause31">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause32"
                                                                            name="abusive_clause3"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause3 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause32">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece que
                                                                        la Institución Financiera unilateralmente podrá
                                                                        realizar modificaciones a la forma de pago
                                                                        establecida en el Contrato de Adhesión.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause41" type="radio"
                                                                            name="abusive_clause4"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause4 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause41">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause42"
                                                                            name="abusive_clause4"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause4 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause42">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Prohíbe en
                                                                        general la contratación de cualquier otro tipo de
                                                                        crédito durante la vigencia del contrato o limiten
                                                                        la movilidad del crédito.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause51" type="radio"
                                                                            name="abusive_clause5"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause5 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause51">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause52"
                                                                            name="abusive_clause5"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause5 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause52">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Traslada al
                                                                        Usuario obligaciones que no deriven de manera
                                                                        directa del contrato celebrado, sino que corresponda
                                                                        cumplir a la Institución Financiera por actos o
                                                                        requisitos establecidos por la Secretaría de
                                                                        Hacienda y Crédito Público, el Banco de México, la
                                                                        Comisión Nacional Bancaria y de Valores y cualquier
                                                                        otra autoridad.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause61" type="radio"
                                                                            name="abusive_clause6"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause6 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause61">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause62"
                                                                            name="abusive_clause6"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause6 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause62">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece el
                                                                        cargo de adeudos vencidos en cuentas de depósito,
                                                                        sin que se indique el plazo en el que se realizará
                                                                        el cargo ni el saldo por el cual se hará el
                                                                        cargo.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause71" type="radio"
                                                                            name="abusive_clause7"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause7 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause71">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause72"
                                                                            name="abusive_clause7"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause7 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause72">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece la
                                                                        autorización irrevocable para cargar las
                                                                        parcialidades del crédito en cualquier cuenta de
                                                                        nómina o de depósito a nombre del Usuario contratada
                                                                        con otra Institución Financiera.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause81" type="radio"
                                                                            name="abusive_clause8"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause8 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause81">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause82"
                                                                            name="abusive_clause8"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause8 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause82">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece que
                                                                        el acreditado debe avisar con antelación a la
                                                                        Institución Financiera la realización de un pago
                                                                        anticipado total o parcial del crédito.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause91" type="radio"
                                                                            name="abusive_clause9"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause9 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause91">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause92"
                                                                            name="abusive_clause9"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause9 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause92">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece que
                                                                        los pagos anticipados o adelantados se aplican a
                                                                        discreción de la Institución Financiera.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause101" type="radio"
                                                                            name="abusive_clause10"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause10 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause101">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause102"
                                                                            name="abusive_clause10"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause10 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause102">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Restringe o
                                                                        limite la disposición de saldos existentes en las
                                                                        cuentas de depósito que el acreditado tenga abiertas
                                                                        con la Institución Financiera, mientras el crédito
                                                                        esté vigente, excepto cuando los recursos
                                                                        depositados en la cuenta se hubiesen otorgado en
                                                                        garantía.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause111" type="radio"
                                                                            name="abusive_clause11"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause11 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause111">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause112"
                                                                            name="abusive_clause11"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause11 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause112">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece que
                                                                        la acreditación del pago con cheque sería hasta el
                                                                        momento en que la Institución Financiera dé por
                                                                        cumplido el pago, sin determinar una fecha
                                                                        cierta.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause121" type="radio"
                                                                            name="abusive_clause12"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause12 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause121">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause122"
                                                                            name="abusive_clause12"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause12 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause122">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece como
                                                                        causal de vencimiento anticipado el incumplimiento
                                                                        de otros créditos celebrados con un tercero ajeno al
                                                                        grupo financiero.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause131" type="radio"
                                                                            name="abusive_clause13"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $abusive_clause13 == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause131">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="abusive_clause132"
                                                                            name="abusive_clause13"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $abusive_clause13 == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="abusive_clause132">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" id="financial_id"
                                                                name="financial_id" value="{{ $financial_id }}">
                                                            <input type="hidden" id="product_id" name="product_id"
                                                                value="{{ $product_id }}">
                                                            <input type="hidden" name="is_required" value="false">
                                                            <div class="col-12">
                                                                <ul
                                                                    class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                    <li>
                                                                        <button class="btn btn-primary">Guardar</button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tabRate">
                                                    <form method="post" id="frm-financial-rate" action="">
                                                        <div class="row gy-4">
                                                            @csrf
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="rate_kc">Calificación KC</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="rate_kc"
                                                                            id="rate_kc" class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->rate_kc : null }}"
                                                                            step="0.01" max="5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_cat">CAT</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="rate_cat"
                                                                            id="rate_cat" class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->rate_cat : null }}"
                                                                            step="0.01" max="5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="rate_comision">Comisiones</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="rate_comision"
                                                                            id="rate_comision" class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->rate_comision : null }}"
                                                                            step="0.01" max="5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="rate_deadline">Plazo</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="rate_deadline"
                                                                            id="rate_deadline" class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->rate_deadline : null }}"
                                                                            step="0.01" max="5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="rate_contract">Contrato</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="rate_contract"
                                                                            id="rate_contract" class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->rate_contract : null }}"
                                                                            step="0.01" max="5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="rate_privacity">Privacidad de datos</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="rate_privacity"
                                                                            id="rate_privacity" class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->rate_privacity : null }}"
                                                                            step="0.01" max="5">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="financial_id"
                                                                name="financial_id" value="{{ $financial_id }}">
                                                            <input type="hidden" id="product_id" name="product_id"
                                                                value="{{ $product_id }}">
                                                            <input type="hidden" name="is_required" value="false">
                                                            <div class="col-12">
                                                                <ul
                                                                    class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                    <li>
                                                                        <button class="btn btn-primary">Guardar</button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                                <div class="tab-pane" id="tabChart">
                                                    <form method="post" id="frm-financial-chart" action="">
                                                        <div class="row gy-4">
                                                            @csrf
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_kc">Costo anual
                                                                        total real</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number"
                                                                            name="chart_costo_anual_total"
                                                                            class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->chart_costo_anual_total : null }}"
                                                                            step="any">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Comisión x
                                                                        apertura</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="chart_comision_apertura1" type="radio"
                                                                            name="chart_comision_apertura"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $financial_product != null && $financial_product->chart_comision_apertura == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="chart_comision_apertura1">Sí &nbsp;
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="chart_comision_apertura2"
                                                                            name="chart_comision_apertura"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $financial_product != null && $financial_product->chart_comision_apertura == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="chart_comision_apertura2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_kc">Plazo
                                                                        máximo</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="chart_plazo_maximo"
                                                                            class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->chart_plazo_maximo : null }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="rate_kc">Capital</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="chart_capital"
                                                                            class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->chart_capital : null }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="rate_kc">Interes</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="chart_interes"
                                                                            class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->chart_interes : null }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="rate_kc">Comisiónes</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="chart_comision"
                                                                            class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->chart_comision : null }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_kc">IVA</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="chart_iva"
                                                                            class="form-control"
                                                                            value="{{ $financial_product != null ? $financial_product->chart_iva : null }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="financial_id"
                                                                name="financial_id" value="{{ $financial_id }}">
                                                            <input type="hidden" id="product_id" name="product_id"
                                                                value="{{ $product_id }}">
                                                            <input type="hidden" name="is_required" value="false">
                                                            <div class="col-12">
                                                                <ul
                                                                    class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                    <li>
                                                                        <button class="btn btn-primary">Guardar</button>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tabTramite">
                                                    <form method="post" id="frm-financial-tramite" action="">
                                                        <div class="row gy-4">
                                                            @csrf
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="rate_kc">Describe el proceso del trámite</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control ckeditor" name="proceso_tramite" id="tramite-proceso_tramite" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" 
                                                            name="financial_id" value="{{ $financial_id }}">
                                                            <input type="hidden"  name="product_id"
                                                                value="{{ $product_id }}">
                                                            <div class="col-12">
                                                                <ul
                                                                    class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                    <li>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('panel.modal.product_fees')
    {{-- modal complementaryservice --}}
    <div class="modal fade" id="modal-complementary" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                        class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="title" id="title-complementary"></h5>
                    <form id="frm-complementary">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Título</label>
                                <div class="form-control-wrap">
                                    <input type="text" name="data[description]" id="product-complementary-description" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3 float-end">
                            <button class="btn btn-primary float-end">Guardar</button>
                        </div>
                        <input type="hidden" name="data[type]" id="type-complementary-service" value="">
                        <input type="hidden" name="data[product_id]" id="product-complementary-service" value="">
                        <input type="hidden" name="complementary_id" id="product-complementary-id" value="">
                    </form>
                    <div id="content-complementary">

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
