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
                        </div><!-- .nk-block-head -->
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered card-preview">
                                <div class="card-inner">
                                    <div class="preview-block">
                                        <div class="row gy-4">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab"
                                                        href="#tabGeneral">General</a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $financial_id != null ? '#tabDataPrivacy' : '#' }}">Privacidad
                                                        de datos</a> </li>

                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $financial_id != null ? '#tabBuro' : '#' }}">Buró</a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $financial_id != null ? '#tabBilling' : '#' }}">Datos
                                                        facturación</a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="{{ $financial_id != null ? '#tabProduct' : '#' }}">Productos</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">

                                                @php
                                                    $contries = config('financial_enums.countries');
                                                    $sectors = config('financial_enums.sector');
                                                    $regulator = config('financial_enums.regulator');
                                                    $list_status = config('enums.status');
                                                @endphp
                                                <div class="tab-pane active" id="tabGeneral">
                                                    @php
                                                        $commercial_name = $financial != null ? $financial->commercial_name : '';
                                                        $company_name = $financial != null ? $financial->company_name : '';
                                                        $date_of_update = $financial != null ? $financial->date_of_update : '';
                                                        $country_id = $financial != null ? $financial->country_id : '';
                                                        $sector_id = $financial != null ? $financial->sector_id : '';
                                                        $regulator_id = $financial != null ? $financial->regulator_id : '';
                                                        $start_of_operations = $financial != null ? $financial->start_of_operations : '';
                                                        $web = $financial != null ? $financial->web : '';
                                                        $email = $financial != null ? $financial->email : '';
                                                        $phone = $financial != null ? $financial->phone : '';
                                                        $comment = $financial != null ? $financial->comment : '';
                                                        $status = $financial != null ? $financial->status : '';
                                                    @endphp
                                                    <form method="post" id="frm-financial" action="">
                                                        @csrf
                                                        <div class="row gy-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">*Nombre
                                                                        comerial</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="commercial_name"
                                                                            class="form-control"
                                                                            value="{{ $commercial_name }}">
                                                                        <label id="financial-commercial_name-unique-error"
                                                                            class="error" style="display: none"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">*Razón
                                                                        social</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="company_name"
                                                                            class="form-control"
                                                                            value="{{ $company_name }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Logo</label>
                                                                    <div class="form-file">
                                                                        <input type="file" name="logo"
                                                                            class="form-file-input">
                                                                        <label class="form-file-label"
                                                                            for="customFile">Seleccione el archivo</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Fecha
                                                                        de actualización</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-left">
                                                                            <em class="icon ni ni-calendar"></em>
                                                                        </div>
                                                                        <input type="text" id="modal-action-start_date"
                                                                            name="date_of_update"
                                                                            class="form-control date-picker"
                                                                            data-date-format="yyyy-mm-dd"
                                                                            value="{{ $date_of_update }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Pais</label>
                                                                    <div class="form-control-wrap">
                                                                        <select class="form-select" name="country_id">
                                                                            @foreach ($contries as $key => $country)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $country_id == $key ? ' selected' : '' }}>
                                                                                    {{ $country }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Sector</label>
                                                                    <div class="form-control-wrap">
                                                                        <select class="form-select" name="sector_id"
                                                                            id="lead-asesor-id">
                                                                            @foreach ($sectors as $key => $sectors)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $sector_id == $key ? 'selected' : '' }}>
                                                                                    {{ $sectors }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Regulador</label>
                                                                    <div class="form-control-wrap">
                                                                        <select class="form-select" name="regulator_id"
                                                                            id="lead-asesor-id">
                                                                            @foreach ($regulator as $key => $regulator)
                                                                                <option value="{{ $key }}"
                                                                                    {{ $regulator_id == $key ? ' selected' : '' }}>
                                                                                    {{ $regulator }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Inicio de
                                                                        operaciones</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-left">
                                                                            <em class="icon ni ni-calendar"></em>
                                                                        </div>
                                                                        <input type="text" id="modal-action-start_date"
                                                                            name="start_of_operations"
                                                                            class="form-control date-picker"
                                                                            data-date-format="yyyy-mm-dd"
                                                                            value="{{ $start_of_operations }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Web</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="web"
                                                                            class="form-control"
                                                                            value="{{ $web }}">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Email</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="email" name="email"
                                                                            class="form-control"
                                                                            value="{{ $email }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Teléfono</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="phone"
                                                                            class="form-control"
                                                                            value="{{ $phone }}">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Comentario</label>
                                                                    <div class="form-control-wrap">
                                                                        <textarea name="comment" id="" cols="30" rows="10" class="form-control">{{ $comment }}</textarea>
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
                                                <div class="tab-pane" id="tabDataPrivacy">
                                                    @php
                                                        $privacy_notice = $financial != null ? $financial->privacy_notice : '';
                                                        $mkt_purposes = $financial != null ? $financial->mkt_purposes : '';
                                                        $prospecting_purposes = $financial != null ? $financial->prospecting_purposes : '';
                                                        $data_secondary_purposes = $financial != null ? $financial->data_secondary_purposes : '';
                                                        $allows_refusal_use = $financial != null ? $financial->allows_refusal_use : '';
                                                        $sensible_data = $financial != null ? $financial->sensible_data : '';
                                                        $transfer_third = $financial != null ? $financial->transfer_third : '';
                                                        $transfer_third_collection = $financial != null ? $financial->transfer_third_collection : '';
                                                        $arco_rights = $financial != null ? $financial->arco_rights : '';
                                                        $revocation_of_consent = $financial != null ? $financial->revocation_of_consent : '';
                                                        $options_to_limit_data_usage = $financial != null ? $financial->options_to_limit_data_usage : '';
                                                        $tracking_technologies = $financial != null ? $financial->tracking_technologies : '';
                                                        $holders_consent = $financial != null ? $financial->holders_consent : '';
                                                    @endphp
                                                    <form method="post" id="frm-financial-data-pricacy" action="">
                                                        @csrf
                                                        <div class="row gy-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Url</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="privacy_notice"
                                                                            class="form-control"
                                                                            value="{{ $privacy_notice }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12"></div>
                                                            <div class="col-md-4">
                                                                <div class="preview-block">
                                                                    <span class="preview-title  form-label">Permite
                                                                        negativa de uso </span>

                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="mkt_purposes1"
                                                                            name="mkt_purposes"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $mkt_purposes == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="mkt_purposes1">Sí &nbsp; </label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="mkt_purposes2"
                                                                            name="mkt_purposes"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $mkt_purposes == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="mkt_purposes2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Fines
                                                                        de prospección </span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="prospecting_purposes1"
                                                                            name="prospecting_purposes"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $prospecting_purposes == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="prospecting_purposes1">Sí &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="prospecting_purposes2"
                                                                            name="prospecting_purposes"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $prospecting_purposes == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="prospecting_purposes2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Datos
                                                                        para fines secundarios </span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="data_secondary_purposes1"
                                                                            name="data_secondary_purposes"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $data_secondary_purposes == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="data_secondary_purposes1">Sí
                                                                            &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="data_secondary_purposes2"
                                                                            name="data_secondary_purposes"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $data_secondary_purposes == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="data_secondary_purposes2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Permite negativa
                                                                        de uso </span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="allows_refusal_use1"
                                                                            name="allows_refusal_use"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $allows_refusal_use == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="allows_refusal_use1">Sí &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="allows_refusal_use2"
                                                                            name="allows_refusal_use"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $allows_refusal_use == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="allows_refusal_use2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Datos
                                                                        sensibles </span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="sensible_data1"
                                                                            name="sensible_data"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $sensible_data == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="sensible_data1">Sí &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="sensible_data2"
                                                                            name="sensible_data"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $sensible_data == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="sensible_data2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Transferencia a
                                                                        terceros</span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="transfer_third1"
                                                                            name="transfer_third"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $transfer_third == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="transfer_third1">Sí &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="transfer_third2"
                                                                            name="transfer_third"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $transfer_third == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="transfer_third2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Transferencia a
                                                                        terceros
                                                                        cobranza</span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="transfer_third_collection1"
                                                                            name="transfer_third_collection"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $transfer_third_collection == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="transfer_third_collection1">Sí
                                                                            &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="transfer_third_collection2"
                                                                            name="transfer_third_collection"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $transfer_third_collection == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="transfer_third_collection2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Derechos
                                                                        ARCO</span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="arco_rights1"
                                                                            name="arco_rights"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $arco_rights == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="arco_rights1">Sí &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="arco_rights2"
                                                                            name="arco_rights"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $arco_rights == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="arco_rights2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Revocación de
                                                                        concentimiento</span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="revocation_of_consent1"
                                                                            name="revocation_of_consent"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $revocation_of_consent == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="revocation_of_consent1">Sí &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="revocation_of_consent2"
                                                                            name="revocation_of_consent"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $revocation_of_consent == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="revocation_of_consent2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Opciones para
                                                                        limitar uso de
                                                                        datos</span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio"
                                                                            id="options_to_limit_data_usage1"
                                                                            name="options_to_limit_data_usage"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $options_to_limit_data_usage == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="options_to_limit_data_usage1">Sí
                                                                            &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio"
                                                                            id="options_to_limit_data_usage2"
                                                                            name="options_to_limit_data_usage"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $options_to_limit_data_usage == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="options_to_limit_data_usage2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Tecnologías de
                                                                        rastreo</span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="tracking_technologies1"
                                                                            name="tracking_technologies"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $tracking_technologies == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="tracking_technologies1">Sí &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="tracking_technologies2"
                                                                            name="tracking_technologies"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $tracking_technologies == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="tracking_technologies2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="preview-block"><span
                                                                        class="preview-title form-label">Concentimiento del
                                                                        titular</span>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="holders_consent1"
                                                                            name="holders_consent"
                                                                            class="custom-control-input" value="1"
                                                                            {{ $holders_consent == 1 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="holders_consent1">Sí &nbsp;</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio"><input
                                                                            type="radio" id="holders_consent2"
                                                                            name="holders_consent"
                                                                            class="custom-control-input" value="0"
                                                                            {{ $holders_consent == 0 ? 'checked' : '' }}><label
                                                                            class="custom-control-label"
                                                                            for="holders_consent2">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="is_required" value="false">
                                                            <input type="hidden" name="financial_id"
                                                                value="{{ $financial_id }}">
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
                                                <div class="tab-pane" id="tabBuro">
                                                    <form method="post" id="frm-financial-buro" action="">
                                                        @csrf
                                                        @php
                                                            $total_claims_condusef = $financial != null ? $financial->total_claims_condusef : '';
                                                            $claim_rate_per_10k = $financial != null ? $financial->claim_rate_per_10k : '';
                                                            $user_service_performance_index = $financial != null ? $financial->user_service_performance_index : '';
                                                            $total_sanctions = $financial != null ? $financial->total_sanctions : '';
                                                            $compliance_condusef_records = $financial != null ? $financial->compliance_condusef_records : '';
                                                            $condusef_evaluation_product = $financial != null ? $financial->condusef_evaluation_product : '';
                                                        @endphp
                                                        <div class="row gy-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Total
                                                                        reclamaciones CONDUSEF</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="total_claims_condusef"
                                                                            class="form-control"
                                                                            value="{{ $total_claims_condusef }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Índice de Reclamación por
                                                                        cada 10 mil contratos</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="claim_rate_per_10k"
                                                                            class="form-control"
                                                                            value="{{ $claim_rate_per_10k }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Índice de desempeño de
                                                                        atención a usuarios (Trimestral)</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number"
                                                                            name="user_service_performance_index"
                                                                            class="form-control"
                                                                            value="{{ $user_service_performance_index }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="frm-product-name">Total
                                                                        Sanciones</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" name="total_sanctions"
                                                                            class="form-control"
                                                                            value="{{ $total_sanctions }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Cumplimiento a los registros
                                                                        de CONDUSEF</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number"
                                                                            name="compliance_condusef_records"
                                                                            class="form-control"
                                                                            value="{{ $compliance_condusef_records }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Evaluación de CONDUSEF por
                                                                        producto</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number"
                                                                            name="condusef_evaluation_product"
                                                                            class="form-control"
                                                                            value="{{ $condusef_evaluation_product }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="is_required" value="false">
                                                            <input type="hidden" name="financial_id"
                                                                value="{{ $financial_id }}">
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
                                                <div class="tab-pane" id="tabBilling">
                                                    @php
                                                        $rfc = $financial != null ? $financial->rfc : '';
                                                        $tax_domicile = $financial != null ? $financial->tax_domicile : '';
                                                    @endphp
                                                    <form method="post" id="frm-financial-billing" action="">
                                                        <div class="row gy-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">RFC</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="rfc"
                                                                            class="form-control"
                                                                            value="{{ $rfc }}">
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="frm-product-name">Domicilio fiscal</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" name="tax_domicile"
                                                                            class="form-control"
                                                                            value="{{ $tax_domicile }}">
                                                                    </div>
                                                                    <input type="hidden" name="is_required"
                                                                        value="false">
                                                                    <input type="hidden" name="financial_id"
                                                                        value="{{ $financial_id }}">
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <ul
                                                                    class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                    <li>
                                                                        <button
                                                                            class="btn btn-primary">Guardar</button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tabProduct">
                                                   <div class="py-2">
                                                        <div class="float-end">
                                                            <a href="/panel/financial-product/{{ $financial_id }}/create" class="btn btn-icon btn-primary"><em
                                                                class="icon ni ni-plus"></em></a>
                                                        </div>
                                                   </div>
                                                   
                                                    <form method="post" id="frm-financial-product" action="">
                                                        <div class="row gy-4 mt-3">
                                                            
                                                            

                                                            <table id="dt-financial-product" class="nowrap nk-tb-list nk-tb-ulist" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Nombre</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                               
                                                            </table>
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
