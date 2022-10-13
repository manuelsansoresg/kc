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
                                                    href="/panel/financial/{{ $financial_id }}/edit?tab=productos">Formulario</a> </li>
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
                                                        href="{{ $product_id != null ? '#tabInfoCredit' : '#' }}">Info del crédito</a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $product_id != null ? '#tabComision' : '#' }}">Comisiones</a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $product_id != null ? '#tabContract' : '#' }}">Contrato</a>
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
                                                                            <label id="product-name-unique-error"
                                                                            class="error" style="display: none"></label>
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
                                                            <input type="hidden" id="financial_id" name="financial_id"
                                                            value="{{ $financial_id }}">
                                                            <input type="hidden" id="product_id" name="product_id"
                                                                value="{{ $product_id }}">
                                                            <input type="hidden" name="is_required" value="true">
                                                            <div class="col-12">
                                                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
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
                                                    @endphp
                                                    <form method="post" id="frm-financial-buro" action="">
                                                        <div class="row gy-4">
                                                            @csrf
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Colateral (Garantía)</label>
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
                                                                    <label class="form-label" for="frm-product-name">Periodicidad</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="periodicity_id" id=""
                                                                            class="form-select">
                                                                            @foreach ($periodicity_products as $key => $periodicity_product)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $periodicity_id == $key ? ' selected' : '' }}>
                                                                                    {{ $periodicity_product }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Monto máximo de crédito</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="max_credit_amount"
                                                                            class="form-control"
                                                                            value="{{ $max_credit_amount }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Plazo mínimo en meses</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="min_deadline_month"
                                                                            class="form-control"
                                                                            value="{{ $min_deadline_month }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Plazo máximo en meses</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="max_deadline_month"
                                                                            class="form-control"
                                                                            value="{{ $max_deadline_month }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Tipo de interés</label>
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
                                                                    <label class="form-label" for="frm-product-name">Fórmula de pago (contrato)</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="pay_form"
                                                                            class="form-control"
                                                                            value="{{ $pay_form }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">tasa de interes anual con IVA</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="annual_int_rate_iva"
                                                                            class="form-control"
                                                                            value="{{ $annual_int_rate_iva }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">CAT Real</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="real_cat"
                                                                            class="form-control"
                                                                            value="{{ $real_cat }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Medio de pago principal</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="principal_pay" id=""
                                                                            class="form-select">
                                                                            @foreach ($principal_pays as $key => $principal_pays)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $principal_pay == $key ? ' selected' : '' }}>
                                                                                    {{ $principal_pays }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Tiempo de resolución en horas</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="resolution_time_hours"
                                                                            class="form-control"
                                                                            value="{{ $resolution_time_hours }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Tiempo de entrega en horas</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="delivery_time_hours"
                                                                            class="form-control"
                                                                            value="{{ $delivery_time_hours }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Tasa de interés moratoria con IVA</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="moratorium_int_rate_vat"
                                                                            class="form-control"
                                                                            value="{{ $moratorium_int_rate_vat }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="financial_id" name="financial_id"
                                                            value="{{ $financial_id }}">
                                                            <input type="hidden" id="product_id" name="product_id"
                                                                value="{{ $product_id }}">
                                                            <input type="hidden" name="is_required" value="false">
                                                            <div class="col-12">
                                                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                    <li>
                                                                        <button class="btn btn-primary">Guardar</button>
                                                                    </li>
                                                                </ul>
                                                            </div>
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
                                                            <div class="col-12"><span class="preview-title-lg overline-title">Comisión por apertura</span></div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Porcentaje comisión por apertura</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="perc_opening_commission"
                                                                            class="form-control"
                                                                            value="{{ $perc_opening_commission }}">
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Medio de pago</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="means_pay_arrangement_id" id=""
                                                                            class="form-select">
                                                                            @foreach ($means_pay_arrangements as $key => $means_pay_arrangement)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $means_pay_arrangement_id == $key ? ' selected' : '' }}>
                                                                                    {{ $means_pay_arrangement }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="col-12"><span class="preview-title-lg overline-title">Seguro de vida</span></div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Porcentaje seguro de vida</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="life_insurance_commission_perc"
                                                                            class="form-control"
                                                                            value="{{ $life_insurance_commission_perc }}">
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Medio de pago</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="means_pay_life_insurance_id" id=""
                                                                            class="form-select">
                                                                            @foreach ($means_pay_arrangements as $key => $means_pay_arrangement)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $means_pay_life_insurance_id == $key ? ' selected' : '' }}>
                                                                                    {{ $means_pay_arrangement }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="col-12"><span class="preview-title-lg overline-title">Seguro de desempleo</span></div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Porcentaje seguro de desempleo</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="unemploy_insurance_commission_perc"
                                                                            class="form-control"
                                                                            value="{{ $unemploy_insurance_commission_perc }}">
                                                                    </div>
                                                                </div>
                                                            </div>    
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Medio de pago</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="means_pay_unemploy_insurance_id" id=""
                                                                            class="form-select">
                                                                            @foreach ($means_pay_arrangements as $key => $means_pay_arrangement)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $means_pay_unemploy_insurance_id == $key ? ' selected' : '' }}>
                                                                                    {{ $means_pay_arrangement }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="col-12"><span class="preview-title-lg overline-title">Otras comisiones</span></div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Aclaración improcedente de la cuenta (Movimientos o cargos no reconocidos)</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="unrecognized_transactions_or_charges"
                                                                            class="form-control"
                                                                            value="{{ $unrecognized_transactions_or_charges }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Administración o manejo de cuenta</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="administration_or_account_management"
                                                                            class="form-control"
                                                                            value="{{ $administration_or_account_management }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Disposición de crédito</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="drawdown_of_receivables"
                                                                            class="form-control"
                                                                            value="{{ $drawdown_of_receivables }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Falta de pago</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="non_payment"
                                                                            class="form-control"
                                                                            value="{{ $non_payment }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Gastos de cobranza</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="collection_costs"
                                                                            class="form-control"
                                                                            value="{{ $collection_costs }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Gastos de investigación y/o formalización</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="inv_formalization_expenses"
                                                                            class="form-control"
                                                                            value="{{ $inv_formalization_expenses }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Pago anticipado / Prepago</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="prepayment_prepaid"
                                                                            class="form-control"
                                                                            value="{{ $prepayment_prepaid }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Pago tardío o inoportuno</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="late_or_untimely_pay"
                                                                            class="form-control"
                                                                            value="{{ $late_or_untimely_pay }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Reimpresión del estado de cuenta</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="statement_reprint"
                                                                            class="form-control"
                                                                            value="{{ $statement_reprint }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Reposición de medios de disposición</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="rep_of_means_of_disposal"
                                                                            class="form-control"
                                                                            value="{{ $rep_of_means_of_disposal }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Medio de pago principal</label>
                                                                    <div class="form-control-wrap">
                                                                        <select name="means_pay_unemploy_insurance_id" id=""
                                                                            class="form-select">
                                                                            @foreach ($means_pay_arrangements as $key => $means_pay_arrangement)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $means_pay_unemploy_insurance_id == $key ? ' selected' : '' }}>
                                                                                    {{ $means_pay_arrangement }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>  --}}
                                                            <input type="hidden" id="financial_id" name="financial_id"
                                                            value="{{ $financial_id }}">
                                                            <input type="hidden" id="product_id" name="product_id"
                                                                value="{{ $product_id }}">
                                                            <input type="hidden" name="is_required" value="false">
                                                            <div class="col-12">
                                                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                    <li>
                                                                        <button class="btn btn-primary">Guardar</button>
                                                                    </li>
                                                                </ul>
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
                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">RECA</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="reca1"
                                                                            name="reca"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $reca == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="reca1">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="reca2"
                                                                            name="reca"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $reca == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="reca2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Número RECA</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="num_reca"
                                                                            class="form-control"
                                                                            value="{{ $num_reca }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12"><span class="preview-title-lg overline-title">Pagos anticipados (Abono a capital)</span></div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Permite pagos anticipados</span>

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
                                                                    <label class="form-label" for="frm-product-name">Procedimiento pagos anticipados</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="prepayment_procedure"
                                                                            class="form-control"
                                                                            value="{{ $prepayment_procedure }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12"><span class="preview-title-lg overline-title">Terminación aticipada de contrato</span></div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Permite pagos anticipados</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="allows_early_term_contract1"
                                                                            name="allows_early_term_contract"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $allows_early_term_contract == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="allows_early_term_contract1">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="allows_early_term_contract2"
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
                                                                    <label class="form-label" for="frm-product-name">Procedimiento pagos anticipados</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="procedure_early_term_contract"
                                                                            class="form-control"
                                                                            value="{{ $procedure_early_term_contract }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Medio de pago principal</label>
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
                                                                    <span class="preview-title  form-label">Consulta de buró de crédito</span>

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

                                                            <div class="col-12"><span class="preview-title-lg overline-title">Clausulas abusivas</span></div>

                                                            <div class="col-md-6">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Establece como causal de vencimiento anticipado del crédito, la cancelación de la cuenta de depósito en la que el acreditado recibe su nómina.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause11"
                                                                            type="radio"
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
                                                                    <span class="preview-title  form-label">Establece como causal de vencimiento anticipado del crédito, que el acreditado termine con la relación laboral existente al momento de la firma.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause21"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Establece que la acreditación del pago será hasta el momento en que el patrón realice la transferencia de los recursos a la Institución Financiera, sin señalar un plazo cierto para tal acreditación.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause31"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Establece que la Institución Financiera unilateralmente podrá realizar modificaciones a la forma de pago establecida en el Contrato de Adhesión.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause41"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Prohíbe en general la contratación de cualquier otro tipo de crédito durante la vigencia del contrato o limiten la movilidad del crédito.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause51"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Traslada al Usuario obligaciones que no deriven de manera directa del contrato celebrado, sino que corresponda cumplir a la Institución Financiera por actos o requisitos establecidos por la Secretaría de Hacienda y Crédito Público, el Banco de México, la Comisión Nacional Bancaria y de Valores y cualquier otra autoridad.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause61"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Establece el cargo de adeudos vencidos en cuentas de depósito, sin que se indique el plazo en el que se realizará el cargo ni el saldo por el cual se hará el cargo.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause71"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Establece la autorización irrevocable para cargar las parcialidades del crédito en cualquier cuenta de nómina o de depósito a nombre del Usuario contratada con otra Institución Financiera.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause81"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Establece que el acreditado debe avisar con antelación a la Institución Financiera la realización de un pago anticipado total o parcial del crédito.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause91"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Establece que los pagos anticipados o adelantados se aplican a discreción de la Institución Financiera.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause101"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Restringe o limite la disposición de saldos existentes en las cuentas de depósito que el acreditado tenga abiertas con la Institución Financiera, mientras el crédito esté vigente, excepto cuando los recursos depositados en la cuenta se hubiesen otorgado en garantía.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause111"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Establece que la acreditación del pago con cheque sería hasta el momento en que la Institución Financiera dé por cumplido el pago, sin determinar una fecha cierta.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause121"
                                                                            type="radio" 
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
                                                                    <span class="preview-title  form-label">Establece como causal de vencimiento anticipado el incumplimiento de otros créditos celebrados con un tercero ajeno al grupo financiero.</span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            id="abusive_clause131"
                                                                            type="radio" 
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

                                                            <input type="hidden" id="financial_id" name="financial_id"
                                                            value="{{ $financial_id }}">
                                                            <input type="hidden" id="product_id" name="product_id"
                                                                value="{{ $product_id }}">
                                                            <input type="hidden" name="is_required" value="false">
                                                            <div class="col-12">
                                                                <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
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
@endsection
