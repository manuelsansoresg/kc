@extends('layouts.admin')
@section('title', 'Perfíl crédito')

@inject('m_lead', 'App\Models\Lead')
@inject('m_bank', 'App\Models\Bank')
@inject('mInvestorsCredit', 'App\Models\InvestorsCredit')
@inject('m_history_log', 'App\Models\HistoryLog')
@inject('m_action', 'App\Models\Action')
@inject('m_file', 'App\Models\File')
@inject('m_survey', 'App\Models\Survey')
@inject('m_kyc', 'App\Models\Kyc')
@inject('m_financial_product', 'App\Models\FinancialProduct')
@inject('m_financial', 'App\Models\Financial')
@inject('retention_period', 'App\Models\kaaxSidecc\RetentionPeriodDate')

@php
    
    $client               = $credit->creditClientPerson;
    $agreement            = $credit->creditAgreement;
    $financial            = $credit->creditFinancial;
    $financial_applied    = $credit->creditAppliedFinancial;
    $product              = $credit->creditProduct;
    $product_applied      = $credit->creditAppliedProduct;
    $types                = config('enums.type_lead');
    $origins              = config('enums.origin');
    $channel              = $m_lead->getChanelByOrigin($credit->origin_id);
    $advisor              = $credit->creditAdvisor;
    $loan_type            = config('enums.loan_type');
    $sign_type            = config('enums.sign_type');
    $periodicity          = config('enums.periodicity');
    $bank                 = $m_bank::find($credit->bank_id);
    $tipo_credito         = isset(config('financial_enums.type_products')[$credit->tipo_credito]) ? config('financial_enums.type_products')[$credit->tipo_credito]  : null;

    //TODO: hacer que al pasar de prospecto a credito cambiar el model
    $files = $m_file->getByIdRelandModel($credit->id, [$m_history_log::KC_CHECK_UP, $m_history_log::KC_CONTROL_DESK, $m_history_log::KC_CHECK_UP_DEBT_REDUCTION, $m_history_log::KC_SWAP, $m_history_log::KC_DELIVERY]);
    $path = $m_file::PATH;
    
    $status = array(
        $m_history_log::KC_CHECK_UP,
        $m_history_log::KC_CHECK_UP_DEBT_REDUCTION,
        $m_history_log::CREDIT_ARCHIVE,
        $m_history_log::CREDIT_CANCELED,
        $m_history_log::CREDIT_REJECTED,
        $m_history_log::CREDIT_IN_PROGRESS,
        $m_history_log::KC_CONTROL_DESK,
        $m_history_log::KC_CONTROL_DESK_TASK1_STEP1,
        $m_history_log::KC_CONTROL_DESK_TASK2_STEP1,
        $m_history_log::KC_CONTROL_DESK_TASK3_STEP1,
        $m_history_log::KC_CONTROL_DESK_TASK2_STEP2,
        $m_history_log::KC_CONTROL_DESK_TASK3_STEP2,
        $m_history_log::KC_DELIVERY,
        $m_history_log::CREDITS_PAID,
        $m_history_log::CREDITS_DELIVERED,
        $m_history_log::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2,
        $m_history_log::KC_CONTROL_DESK_TASK2_STEP3,
        $m_history_log::KC_CONTROL_DESK_TASK3_STEP3,
        $m_history_log::KC_CONTROL_DESK_TASK4_STEP3,
        $m_history_log::KC_CONTROL_DESK_TASK5_STEP3,
        $m_history_log::KC_CONTROL_DESK_DYNAMIC_TASK_STEP3,
        $m_history_log::KC_CONTROL_DESK_TASK1_STEP4,
        $m_history_log::KC_CONTROL_DESK_TASK2_STEP4,
        $m_history_log::KC_DELIVERY_TASK1_STEP1,
        $m_history_log::KC_DELIVERY__DYNAMIC_TASK_STEP2,
        $m_history_log::KC_DELIVERY_TASK2_STEP2,
    );
    $histories = $m_history_log->getByStatus($status, $credit->id, null);
    $leyend_status = $m_history_log::$label_status;
    $status_credit = array(
        $m_history_log::CREDIT_IN_PROGRESS,
        $m_history_log::CREDIT_CANCELED,
        $m_history_log::CREDIT_REJECTED,
        $m_history_log::CREDITS_DELIVERED,
    );
    $current_module = $m_history_log->getByStatusFirst($status_credit, $credit->id);
    $status_credit_archive = array(
        $m_history_log::KC_PAYMENT_PAID_ARCHIVE,
        $m_history_log::KC_PAYMENT_UNPAID_ARCHIVE,
        $m_history_log::KC_AFTER_MARKET_ARCHIVE,
    );
    $current_archive = $m_history_log->getByStatusFirst($status_credit_archive, $credit->id, 1);
    $credit_product = $credit->applied_financial_product != null ? $m_financial_product::where('id', $credit->applied_financial_product)->first() : null;
    $financial = $credit_product != null ? $m_financial::find($credit_product->financial_id) : null;
@endphp


{{-- 
    $m_history_log::$label_status[$current_module->status_id]
    --}}
@section('content')
    {{-- content --}}
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"> Crédito / <strong class="text-primary small">
                                        {{ $client->name }} {{ $client->last_name }} {{ $client->second_last_name }}
                                    </strong>
                                </h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="list-inline">
                                        <li>ID: <span class="text-base"> {{ $client->id }} </span></li>
                                        <li>Creado: <span class="text-base"> {{ formatDateNameMonth($client->created_at) }}
                                            </span></li>
                                    </ul>
                                </div>

                            </div>
                            <div class="nk-block-head-content">
                                <a href="html/user-list-regular.html"
                                    class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em
                                        class="icon ni ni-arrow-left"></em><span>Volver</span></a>
                                <a href="html/user-list-regular.html"
                                    class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em
                                        class="icon ni ni-arrow-left"></em></a>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card card-bordered">
                            <div class="card-aside-wrap">
                                <div class="card-inner card-inner-lg">
                                    <div class="nk-block">
                                        <div class="nk-data data-list">
                                            @php
                                                $tab = isset($_GET['tab'])?$_GET['tab'] : null;
                                            @endphp
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item"> <a class="nav-link {{ $tab == null ? 'active' : null}}" data-bs-toggle="tab"
                                                        href="#tabGeneral">General</a> </li>
                                                @hasrole('Administrador|Asesor')
                                                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                        href="#tabHistorial">Historial</a> </li>
                                                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                            href="#tabActions">Tareas</a> </li>
                                                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                            href="#tabRequest">Solicitud</a> </li>
                                                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                            href="#tabComision">Comisión</a> </li>
                                                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                            href="#tabDocs">Docs</a> </li>
                                                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                            href="#tabKyc">KYC</a> </li>

                                                    <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab"
                                                            href="#survey">Encuesta</a> </li>
                                                @endhasrole
                                               
                                                <li class="nav-item"> <a class="nav-link {{ $tab == 'pagos'? 'active' : null}}" data-bs-toggle="tab"
                                                href="#pagos">Pagos</a> </li>
                                                
                                                        <li class="nav-item nav-item-trigger d-xxl-none">
                                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1"
                                                            data-target="userAside"><em
                                                                class="icon ni ni-menu-alt-r"></em></a>
                                                    </div>
                                                </li>

                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane {{ $tab == null ? 'active' : null}}" id="tabGeneral">
                                                    <div class="card-inner">
                                                        <div class="nk-block">
                                                            <div class="nk-block-head nk-block-head-line">
                                                                <span
                                                                    class="preview-title-lg overline-title text-primary ">Crédito</span>
                                                            </div><!-- .nk-block-head -->
                                                            
                                                            <div class="profile-ud-list">
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Fecha de entrega</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ $credit !== null ? $credit->delivered_date : null }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Importe prestado</span>
                                                                        <span class="profile-ud-value">
                                                                            @php
                                                                                $investorImport = $credit->getInvestorImport();
                                                                            @endphp
                                                                            @if ($investorImport !== null)
                                                                                {{ format_price($investorImport) }}
                                                                            @else
                                                                                <span class="text-muted">No disponible</span>
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Servicio</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ $credit->creditProduct != null ? $credit->creditProduct->alias : null }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Organización</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ $credit->creditAgreement != null ? $credit->creditAgreement->name : null }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Tipo de trámite</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ $credit->tramit_type  != null && isset(config('enums.tipo_tramite')[$credit->tramit_type]) ? config('enums.tipo_tramite')[$credit->tramit_type] : null }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Estatus</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ $credit->status != null && isset(config('enums.investorsCreditsStatus')[$credit->status]) ? config('enums.investorsCreditsStatus')[$credit->status] : null }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                               
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Producto</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ $credit->creditAppliedProduct != null ? $credit->creditAppliedProduct->alias : null }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                              

                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Periodicidad</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ $credit->status != null && isset(config('enums.periodicidad_names')[$credit->applied_periodicity ]) ? config('enums.periodicidad_names')[$credit->applied_periodicity ] : null }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Capital</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ format_price($credit->applied_import)   }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Plazo</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ ($credit->applied_term)   }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Parcialidad</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ format_price($credit->applied_payment)   }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                              
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Total</span>
                                                                        <span class="profile-ud-value">
                                                                            {{ format_price($credit->applied_loan_total_amount)   }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                               
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">Tasa de interés anual</span>
                                                                        <span class="profile-ud-value">
                                                                            %{{ ($credit->applied_interest_rate)   }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                              
                                                                <div class="profile-ud-item">
                                                                    <div class="profile-ud wider">
                                                                        <span class="profile-ud-label">CAT</span>
                                                                        <span class="profile-ud-value">
                                                                            %{{ ($credit->applied_CAT)   }}
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                            </div><!-- .profile-ud-list -->
                                                        </div><!-- .nk-block -->

                                                        

                                                        
                                                        <div class="nk-divider divider md"></div>
                                                        <div class="nk-block">
                                                            <div class="nk-block-head nk-block-head-sm nk-block-between">
                                                                <h5 class="title">Notas</h5>

                                                                {{-- <a href="#" class="link link-sm">+ Add Note</a> --}}
                                                            </div><!-- .nk-block-head -->
                                                            <p> <a class="link pointer"
                                                                    onclick="modalNote({{ $credit->id }}, 'credit')">Haz
                                                                    click para agregar notas</a> </p>
                                                            <div id="content-note"></div>
                                                        </div><!-- .nk-block -->
                                                    </div><!-- .card-inner -->
                                                </div>
                                                <div class="tab-pane" id="tabHistorial">
                                                    
                                                    @foreach ($histories as $history)
                                                        <div class="user-card mt-3">
                                                            <div class="user-info">
                                                                <span class="tb-lead"> <em
                                                                        class="icon ni ni ni-clock"></em>
                                                                    {{ $leyend_status != null && isset($leyend_status[$history->status_id]) ? $leyend_status[$history->status_id] : 'Estado no definido' }} <span
                                                                        class="dot dot-success d-md-none ms-1"></span>
                                                                    <p class="ms-1">
                                                                        {{ formatDateNameMonth($history->created_at) }}</p>
                                                                </span>

                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="tab-pane" id="tabActions">
                                                    <table id="dt-acctions-profile" class="nowrap nk-tb-list nk-tb-ulist"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Acción</th>
                                                                <th>Asunto</th>
                                                                <th>Módulo</th>
                                                                <th>Deadline</th>
                                                                <th>Estatus</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>

                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="tabRequest">
                                                    <div class="nk-block-head nk-block-head-line">
                                                        <span class="preview-title-lg overline-title text-primary ">Crédito Solicitado</span>
                                                    </div>
                                                    <div class="profile-ud-list">
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Fecha</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit !== null ? formatDateNameMonth($credit->payment_capacity_period, false) : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Capacidad de pago</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit !== null ? $credit->payment_capacity : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Financiera</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $financial !== null ? $financial->commercial_name : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Producto financiero</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $product_applied !== null ? $product_applied->alias : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Tipo de trámite</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $loan_type != null && $credit->applied_loan_type != null && isset($loan_type[$credit->applied_loan_type]) ? $loan_type[$credit->applied_loan_type] : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Promoción</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit !== null ? $credit->applied_loan_discount : null }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Tipo de firma</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $sign_type != null && $credit->applied_sign_type != null && isset($sign_type[$credit->applied_sign_type]) ? $sign_type[$credit->applied_sign_type] : null }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Importe solicitado</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit !== null ? $credit->applied_import : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Plazo solcitado</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit !== null ? $credit->applied_term : null }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Periodicidad solicitada</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $periodicity != null && $credit->applied_periodicity != null && isset($periodicity[$credit->applied_periodicity]) ? $periodicity[$credit->applied_periodicity] : null }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Pago solicitado</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit !== null ? $credit->applied_payment : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Monto total del crédito</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit !== null ? $credit->applied_loan_total_amount : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Tasa de interés</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit !== null ? $credit->applied_interest_rate : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">CAT</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit !== null ? $credit->applied_CAT : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Entrevistador</span>
                                                                <span class="profile-ud-value">
                                                                    {{ isset(config('enums.interviewer')[$credit->interviewer]) ? config('enums.interviewer')[$credit->interviewer] : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                </div>
                                                <div class="tab-pane" id="tabComision">
                                                    <div class="nk-block-head nk-block-head-line">
                                                        <span class="preview-title-lg overline-title text-primary ">Crédito Solicitado</span>
                                                    </div>
                                                    <div class="profile-ud-list">
                                                        <div class="profile-ud-item">
                                                            @php
                                                                $user_financial = $credit->creditUserFinancial;
                                                                $name = $user_financial != null ? $user_financial->name.' '.$user_financial->last_name.' '.$user_financial->second_last_name :  null;
                                                            @endphp
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Usuario financiera</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $name }}
                                                                </span>
                                                            </div>
                                                          
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Comisión</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit != null ? $credit->commission : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="profile-ud-item">
                                                            <div class="profile-ud wider">
                                                                <span class="profile-ud-label">Comentario</span>
                                                                <span class="profile-ud-value">
                                                                    {{ $credit != null ? $credit->commission_note : null }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabDocs">
                                                    <table class="table table-tranx">
                                                        <thead>
                                                            <tr class="tb-tnx-head">
                                                                <th class="tb-tnx-id"><span class="">Documento</span></th>
                                                                <th class="tb-tnx-info">
                                                                </th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $nombre = null;
                                                            @endphp
                                                            @if ($credit->sod_agreement != null)
                                                                @php
                                                                    $nombre = $client->id.'-'.$client->name.' '.$client->last_name.' '.$client->second_last_name.' contrato SOD.pdf';
                                                                @endphp
                                                                <tr>
                                                                    <td><a href="{{ asset('firma_contratos/'.$nombre) }}" target="_blank">{{ $nombre }}</a></td>
                                                                    <td><a href="{{ asset('firma_contratos/'.$nombre) }}" download>Descargar</a></td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @foreach ($files as $file)
                                                            <tr class="tb-tnx-item">
                                                                <td class="tb-tnx-id">
                                                                    <a href="{{ asset($path.'/'.$file['name']) }}">{{ $file['name_template'] }}</a>
                                                                </td>
                                                                <td class="tb-tnx-info">
                                                                    @php
                                                                        $downloadName = $file['name'];
                                                                        // Si se quiere un nombre más limpio, usar name_template conservando la extensión original
                                                                        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                                                                        $baseTemplate = $file['name_template'];
                                                                        // Evita espacios problemáticos en algunos navegadores
                                                                        $safeBase = str_replace(['/', '\\'], '-', $baseTemplate);
                                                                        $suggested = $safeBase . '.' . $ext;
                                                                        // Usa el nombre sugerido si existe extensión detectada
                                                                        if (!empty($ext)) {
                                                                            $downloadName = $suggested;
                                                                        }
                                                                    @endphp
                                                                    <a href="{{ asset($path.'/'.$file['name']) }}" download="{{ $downloadName }}">Descargar</a>

                                                                </td>

                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="tabKyc">
                                                    <div class="nk-block-head nk-block-head-line">
                                                        <span class="preview-title-lg overline-title text-primary ">validar CURP</span>
                                                    </div>

                                                    <span class="preview-title-lg overline-title text-primary "></span>
                                                   <div class="container">
                                                        <div class="row">
                                                            <div class="col-12" style="overflow: auto">
                                                                {!! $m_kyc->getCollection($credit->id) !!}
                                                            </div>
                                                        </div>
                                                   </div>
                                                   <div class="nk-block-head nk-block-head-line py-3">
                                                        <span class="preview-title-lg overline-title text-primary ">validar INE</span>
                                                    </div>
                                                   <div class="container">
                                                        <div class="row">
                                                            <div class="col-12" style="overflow: auto">
                                                                {!! $m_kyc->getCollection($credit->id, 2) !!}
                                                            </div>
                                                        </div>
                                                   </div>
                                                   <div class="nk-block-head nk-block-head-line py-3">
                                                        <span class="preview-title-lg overline-title text-primary ">validar RFC</span>
                                                    </div>
                                                   <div class="container">
                                                        <div class="row">
                                                            <div class="col-12" style="overflow: auto">
                                                                {!! $m_kyc->getCollection($credit->id, 3) !!}
                                                            </div>
                                                        </div>
                                                   </div>
                                                   <div class="nk-block-head nk-block-head-line py-3">
                                                        <span class="preview-title-lg overline-title text-primary ">validar Datos laborales ISSSTE</span>
                                                    </div>
                                                   <div class="container">
                                                        <div class="row">
                                                            <div class="col-12" style="overflow: auto">
                                                                {!! $m_kyc->getCollection($credit->id, 4) !!}
                                                            </div>
                                                        </div>
                                                   </div>
                                                </div>
                                                <div class="tab-pane" id="survey">
                                                    @php
                                                        $get_survey                 = $m_survey->getQuiz($credit->id);
                                                        $enum_credit_delivery       = $get_survey != null && isset(config('enum_survey.surevey_credit_delivery')[$get_survey['surevey_credit_delivery']])? config('enum_survey.surevey_credit_delivery')[$get_survey['surevey_credit_delivery']] :  null;
                                                        $enum_kc_attention          = $get_survey != null && isset(config('enum_survey.surevey_kc_attention')[$get_survey['surevey_kc_attention']])? config('enum_survey.surevey_kc_attention')[$get_survey['surevey_kc_attention']] :  null;
                                                        $enum_financial_attention   = $get_survey != null && isset(config('enum_survey.surevey_financial_attention')[$get_survey['surevey_financial_attention']])? config('enum_survey.surevey_financial_attention')[$get_survey['surevey_financial_attention']] :  null;
                                                        $enum_recomendacion_amigos   = $get_survey != null && isset(config('enum_survey.surevey_recomendacion_amigos')[$get_survey['surevey_recomendacion_amigos']])? config('enum_survey.surevey_recomendacion_amigos')[$get_survey['surevey_recomendacion_amigos']] :  null;
                                                        $comment                    = $get_survey != null && isset($get_survey['survey_note'])? $get_survey['survey_note'] :  null;
                                                    @endphp     
                                                    <div class="nk-block">
                                                        <div class="nk-block-head nk-block-head-line">
                                                            <span
                                                                class="preview-title-lg overline-title text-primary "></span>
                                                        </div><!-- .nk-block-head -->
                                                        <div class="profile-ud-list">
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">¿Recibiste el crédito?</span>
                                                                    <span class="profile-ud-value"> {{ $enum_credit_delivery }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">Qué tan satisfecho está con la claridad y transparencia de la información que te proporcionamos?</span>
                                                                    <span class="profile-ud-value">
                                                                        @if ($enum_kc_attention != null)
                                                                            <img src="{{ asset($enum_kc_attention) }}" alt="">
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">¿Cómo calificarías la atención la financiera que te otorgó el crédito?</span>
                                                                    <span class="profile-ud-value">
                                                                        @if ($enum_financial_attention != null)
                                                                            <img src="{{ asset($enum_financial_attention) }}" alt="">
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">¿En una escala del 1 al 5 ¿Qué tan probable es que nos recomiendes con un conocido?</span>
                                                                    <span class="profile-ud-value">
                                                                        @if ($enum_recomendacion_amigos != null)
                                                                            <img src="{{ asset($enum_recomendacion_amigos) }}" alt="">
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                           
                                                            <div class="profile-ud-item">
                                                                <div class="profile-ud wider">
                                                                    <span class="profile-ud-label">¿Tienes algún comentario?</span>
                                                                    <span class="profile-ud-value">
                                                                        {{ $comment }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div><!-- .profile-ud-list -->
                                                    </div><!-- .nk-block -->
                                                </div>
                                                <div class="tab-pane {{ $tab == 'pagos' ? 'active' : null}}" id="pagos">
                                                    <div class="col-12">
                                                        <table class="table" data-show-columns="true">
                                                            <thead>
                                                                <tr>
                                                                    <th class=""># pago</th>
                                                                    <th class="">Fecha de pago</th>
                                                                    <th class="">Pago</th>
                                                                    <th class="">Capital</th>
                                                                    <th>Interés</th>
                                                                    <th class="">IVA</th>
                                                                    <th class="none">Estatus</th>
                                                                    <th class="none">Fecha retención</th>
                                                                    <th class="none">Comisión KC</th>
                                                                </tr>
                                                            </thead>
                    
                                                            <tbody>
                                                                @if ($payments != null)
                                                                    @foreach ($payments as $payment)
                                                                        @php
                                                                            $fecha_retencion = null;
                                                                            $investorsCredit = $mInvestorsCredit::where('credit_id', $credit->id)->first();
                                                                            if ($payment->tipo_de_pago == 4) {
                                                                                $fecha_envio_id = $payment->fecha_envio_id;
                                                                                $retention = $retention_period::find($fecha_envio_id);
                                                                                $fecha_retencion = $retention != null ? date('d-m-Y', strtotime($retention->retention_date)) : null;
                                                                            }
                                                                           
                                                                        @endphp
                                                                        <tr>
                                                                            <td> {{ $payment->numero_de_pago }} </td>
                                                                            <td>{{ $payment->fecha_pago != '' ? date('d-m-Y', strtotime($payment->fecha_pago)) : null }}</td>
                                                                            <td> {{ $investorsCredit != null ? format_price(($payment->pagado * $investorsCredit->percentage) / 100) : null }} </td>
                                                                            <td> {{ $investorsCredit != null ? format_price(($payment->abono * $investorsCredit->percentage) / 100) : null }} </td>
                                                                            <td> {{ $investorsCredit != null ? format_price(($payment->interes * $investorsCredit->percentage) / 100) : null }} </td>
                                                                            <td> {{ $investorsCredit != null ? format_price(($payment->iva * $investorsCredit->percentage) / 100) : null }} </td>
                                                                            
                                                                            <td> {{ $payment->estatus_pago != null && isset(config('enums.estatus_statement')[$payment->estatus_pago]) ? config('enums.estatus_statement')[$payment->estatus_pago] : null }}
                                                                            </td>
                                                                            <td> 
                                                                                {{ $fecha_retencion }}
                                                                            </td>
                                                                            <td> {{ $investorsCredit != null ? format_price(($payment->pagado * $investorsCredit->commission_rate * $investorsCredit->percentage)/ 10000) : null }} </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div><!-- data-list -->

                                    </div><!-- .nk-block -->
                                </div>
                                <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg"
                                    data-toggle-body="true" data-content="userAside" data-toggle-screen="lg"
                                    data-toggle-overlay="true">
                                    <div class="card-inner-group" data-simplebar>
                                        <div class="card-inner">
                                            <div class="user-card user-card-s2">
                                                <img class="logo-profile" src="{{ asset('images/logo_solo.png') }}"
                                                    alt="">
                                                <div class="user-info">
                                                    <div class="badge bg-outline-light rounded-pill ucap">Crédito</div>
                                                    <h5> {{ $client->name }} {{ $client->last_name }}
                                                        {{ $client->second_last_name }} </h5>
                                                    <span class="sub-text">
                                                        {{ $client->email }} <br>

                                                    </span>
                                                    <p class="profile-ud-value">
                                                        {{ $product !== null ? $product->alias : null }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                        
                                        <div class="card-inner">
                                            <h6 class="overline-title-alt mb-2 text-primary ">Otros</h6>
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <span class="sub-text">Origen:</span>
                                                    <span>{{ $origins != null && $credit->origin_id != null && isset($origins[$credit->origin_id]) ? $origins[$credit->origin_id] : null }}</span>
                                                </div>
                                                {{-- <div class="col-6">
                                                <span class="sub-text">Canal:</span>
                                                <span>{{ $channel[$credit->channel_id] }}</span>
                                            </div> --}}
                                                <div class="col-6 d-none">
                                                    <span class="sub-text">Etatus:</span>

                                                </div>
                                                <div class="col-6">
                                                    <span class="sub-text">Asesor:</span>
                                                    @if ($advisor !== null)
                                                        <span>
                                                            {{ $advisor->name }} {{ $advisor->last_name }}
                                                            {{ $advisor->second_last_name }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="col-6">
                                                    <span class="sub-text">Estatus:</span>
                                                    <span>
                                                        @if ($current_archive == null)
                                                        
                                                            {{ $current_module != null && $current_module->status_id != null && isset($m_history_log::$label_status[$current_module->status_id]) ? $m_history_log::$label_status[$current_module->status_id] : null }}
                                                        @endif
                                                    </span>
                                                </div>

                                                <div class="col-6">
                                                    <span class="sub-text">Módulo:</span>
                                                    <span>{{ $m_history_log->getCurrentModule($credit->id) }}</span>
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                        <div class="card-inner">
                                            <h6 class="overline-title-alt mb-3 text-primary ">Etiquetas </h6>
                                            <p> <a class="link pointer" onclick="modalCreditTag({{ $credit->id }})">Haz
                                                    click para agregar etiquetas</a> </p>
                                            <div id="content-tag"></div>
                                        </div><!-- .card-inner -->
                                    </div><!-- .card-inner-group -->
                                </div><!-- card-aside -->
                            </div><!-- .card-aside-wrap -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    {{-- content --}}

    <input type="hidden" id="refresh-dt" value="null">
    <input type="hidden" id="credit-profile-credit_id" value="{{ $credit->id }}">
    @include('panel.action.modal.form')
    @include('panel.action.modal.register_action')
    @include('panel.modal.note')
    @include('panel.credit.modal.tag')
@endsection
