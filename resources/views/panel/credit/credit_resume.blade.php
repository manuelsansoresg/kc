@extends('layouts.admin')
@section('title', 'Perfíl crédito')

@inject('m_lead', 'App\Models\Lead')
@inject('m_history_log', 'App\Models\HistoryLog')
@inject('m_action', 'App\Models\Action')
@inject('m_file', 'App\Models\File')
@inject('m_survey', 'App\Models\Survey')

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
    $marital          = config('enums.marital_status');
    $sex          = config('enums.sex');
    $education_level          = config('enums.education_level');

    //TODO: hacer que al pasar de prospecto a credito cambiar el model
    $files = $m_file->getByIdRelandModel($credit->id, [$m_history_log::KC_CHECK_UP, $m_history_log::KC_CONTROL_DESK, $m_history_log::KC_CHECK_UP_DEBT_REDUCTION]);
    $path = $m_file::PATH;
    
   
@endphp

@section('content')

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-md mx-auto">
                    <div class="nk-block-head nk-block-head-lg wide-sm">
                        <div class="nk-block-head-content">
                            
                            <h3 class="nk-block-title page-title"> Crédito / <strong class="text-primary small">
                                {{ $client->name }} {{ $client->last_name }} {{ $client->second_last_name }}
                            </strong>
                            </h3>
                            <div class="nk-block-des text-soft">
                                <nav>
                                    <ul class="list-inline">
                                        <li>ID: <span class="text-base"> {{ $client->id }} </span></li>
                                        <li>Creado: <span class="text-base"> {{ formatDateNameMonth($client->created_at) }}
                                            </span></li>
                                    </ul>
                                </nav>
                                
                            </div>
                           
                        </div>
                       
                    </div><!-- .nk-block-head -->
                    <div class="nk-block nk-block-lg mt-n3">
                        <div class="card card-bordered card-preview">
                            <div class="card-inner">
                                <div class="preview-block">
                                    <div class="row gy-4">
                                        <span class="preview-title-lg overline-title text-primary ">Generales</span>
                                        <div class="profile-ud-list">
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Nombres</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->name : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Primer apellido</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->last_name : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Segundo apellido</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->second_last_name : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Celular</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->cellphone : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Email</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->email : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Email laboral</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->work_email : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Fecha de nacimiento</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->birth_date : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">sexo</span>
                                                    <span class="profile-ud-value">
                                                        {{ isset($sex[$client->sex]) ? $sex[$client->sex] : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">RFC</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->rfc : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Nacionalidad</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->nationality : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Estado de nacimiento</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->birth_state : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">CURP</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->curp : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Estado civil</span>
                                                    <span class="profile-ud-value">
                                                        {{ isset($marital[$client->marital_status]) ? $marital[$client->marital_status] : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Nivel educativo</span>
                                                    <span class="profile-ud-value">
                                                        {{ isset($education_level[$client->education_level]) ? $education_level[$client->education_level] : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Ocupación</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->profession : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Horio de contacto</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->client_contact_time : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <span class="preview-title-lg overline-title text-primary ">Familiares</span>
                                        <div class="profile-ud-list">
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Primer apellido</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->relative_lastname : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Segundo Apellido</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->relative_second_lastname : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Nombres</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->relative_names : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Tel. Fijo</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->relative_local_phone : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Tel. Celular</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->relative_cel_phone : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Horario de contacto</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->relative_contact_time : null }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="preview-title-lg overline-title text-primary ">Domicilio</span>
                                        <div class="profile-ud-list">
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Código postal</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->client_postal_code : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Calle</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->client_street : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Número exterior.</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->client_home_external_number : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Número interior</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->client_home_internal_number : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Colonia</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->client_colony : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Municipio</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->client_city : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Estado</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->client_state : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">País</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->client_country : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Tipo vivienda</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->home_type : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Tiempo de vivir ahí</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->home_time_living : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Comentarios vivienda</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->home_note : null }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="preview-title-lg overline-title text-primary ">Bienes</span>
                                        <div class="profile-ud-list">
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">úmero de propiedades</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->propety_ownnership_amount : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Varlos estimado de propiedades</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->propety_ownnership_value : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Número de vehículos propios</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->vehicle_ownnership_amount : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Varlor estimado de vehículos</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->vehicle_ownnership_value : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Número de dependientes económicos</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->economic_dependents : null }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="preview-title-lg overline-title text-primary ">BANCO</span>
                                        <div class="profile-ud-list">
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Nombre del banco</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->bank_name : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Número de tarjeta</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->bank_card_number : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Número de cuenta</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->bank_acount_number : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">CLABE interbancaria</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->bank_clabe : null }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="preview-title-lg overline-title text-primary ">LABORAL</span>
                                        <div class="profile-ud-list">
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Centro de trabajo</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_name : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Fecha de ingreso</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->admission_date : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Antigüedad laboral</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->labor_old : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Número de empleado</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->employee_number : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Categoría</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->employee_category : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Área</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->employee_area : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Puesto</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->employee_position : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Ingreso mensual</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->monthly_income : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Fuente de ingresos adicionales</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->aditional_labor_source : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Ingresos adicionales</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->aditional_labor_income : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Código postal</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_postal_code : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Calle</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_street : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Número exterior</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_home_external_number : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Número interior</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_home_internal_number : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Colonia</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_colony : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Municipio</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_city : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Estado</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_state : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">País</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_country : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Tel fijo</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_local_phone : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Tel celular</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_cel_phone : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Clave centro trabajo</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_code : null }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="profile-ud-item">
                                                <div class="profile-ud wider">
                                                    <span class="profile-ud-label">Extensión</span>
                                                    <span class="profile-ud-value">
                                                        {{ $client !== null ? $client->workplace_local_phone_extension : null }}
                                                    </span>
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
</div>
   
@endsection
