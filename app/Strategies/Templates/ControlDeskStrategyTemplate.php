<?php

namespace App\Strategies\Templates;

use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\File;
use App\Models\Financial;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\Product;
use App\Models\User;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use stdClass;

class ControlDeskStrategyTemplate implements TemplateInterface
{
    public function move($id)
    {
    }

    public function configUpload()
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == 1) {
            return self::uploadStep1();
        }
        return self::uploadStep3();
    }

    public function uploadStep1()
    {
        $elements = array(
            1 => [
                'name' => 'Identificación oficial',
                'comment' => 'INE vigente',
                'is_required' => true,
                'is_date' => false,
                'max_size' => 2, //* size in MB
                'max_file' => 2,
                'type' => 'image/*',
                'comment_date' => null
            ],

            2 => [
                'name' => 'Recibo de nómina',
                'comment' => 'Más reciente',
                'is_required' => true,
                'is_date' => true,
                'max_size' => 2,
                'max_file' => 2,
                'type' => 'image/*',
                'comment_date' => 'Establece la fecha del comprobante más antigüo'
            ],
            3 => [
                'name' => 'Comprobante de domicilio',
                'comment' => 'Más reciente',
                'is_required' => true,
                'is_date' => true,
                'max_size' => 2,
                'max_file' => 2,
                'type' => 'image/*',
                'comment_date' => 'Fecha del documento'
            ],
            4 => [
                'name' => 'Comprobante de capacidad de pago',
                'comment' => 'Evidencia de capacidad de pago',
                'is_required' => true,
                'is_date' => false,
                'max_size' => 2,
                'max_file' => 2,
                'type' => 'image/*',
                'comment_date' => null
            ],
        );
        return $elements;
    }

    public function Uploadstep3()
    {
        $elements = array(
            5 => [
                'name' => 'Edo Cta bancario',
                'comment' => 'Último estado de cuenta',
                'is_required' => false,
                'is_date' => false,
                'max_size' => 2, //* size in MB
                'max_file' => 2,
                'type' => 'image/*, .pdf',
                'comment_date' => null
            ],

        );
        return $elements;
    }

    public function configForm($id_rel, $history_id = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;

        if ($step == 1) {
            return self::configFormStep1($id_rel, $history_id);
        } elseif ($step == 2) {
            return self::configFormstep2($id_rel, $history_id);
        } elseif ($step == '3_1') {
            return self::configFormstep3_1($id_rel, $history_id);
        } elseif ($step == '3_2') {
            return self::configFormstep3_2($id_rel, $history_id);
        }
    }

    public function configFormStep1($id_rel, $history_id)
    {
        $name_form = 'frm-template_control_desk_step1';
        $type_form = HistoryLog::KC_CONTROL_DESK_FORM;
        $elements = array(
            1 => [
                'title_section' => 'Viabilidad',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            2 => [
                'title_section' => null,
                'title' => 'Periodo CP',
                'name_field' => 'credit[payment_capacity_period]',
                'id_field' => 'payment_capacity_period',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'date',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            3 => [
                'title_section' => null,
                'title' => 'Capacidad de pago',
                'name_field' => 'credit[payment_capacity]',
                'id_field' => 'payment_capacity',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            4 => [
                'title_section' => null,
                'title' => 'Fecha de nacimiento',
                'name_field' => 'client_person[birth_date]',
                'id_field' => 'birth_date',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'date',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            5 => [
                'title_section' => null,
                'title' => 'Antigüedad laboral',
                'name_field' => 'client_person[labor_old]',
                'id_field' => 'labor_old',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            6 => [
                'title_section' => null,
                'title' => 'Categoría',
                'name_field' => 'client_person[employee_category]',
                'id_field' => 'employee_category',
                'comment_admin' => 'Ej. Base, confianza etc..',
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }


    public function configFormstep2($id_rel, $history_id)
    {
        $name_form = 'frm-template_control_desk_step2';
        $type_form = HistoryLog::KC_CONTROL_DESK_FORM_STEP_2;
        $financial = Financial::select('id', 'commercial_name as name')->get();
        $product = Product::select('id', 'alias as name')->get();
        $loan_type = config('enums.loan_type');
        $sign_type = config('enums.sign_type');
        $periodicity = config('enums.periodicity');

        $elements = array(
            1 => [
                'title_section' => 'Crédito solicitado',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            2 => [
                'title_section' => null,
                'title' => 'Financiera',
                'name_field' => 'credit[applied_financial]',
                'id_field' => 'applied_financial',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => false,
                'options' => $financial,
                'is_required' => true,
                'is_disabled' => 'disabled'
            ],
            3 => [
                'title_section' => null,
                'title' => 'Producto financiero',
                'name_field' => 'credit[applied_financial_product]',
                'id_field' => 'applied_financial_product',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => false,
                'options' => $product,
                'is_required' => true,
                'is_disabled' => null
            ],
            4 => [
                'title_section' => null,
                'title' => 'Tipo de trámite',
                'name_field' => 'credit[applied_loan_type]',
                'id_field' => 'applied_loan_type',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $loan_type,
                'is_required' => true,
                'is_disabled' => null
            ],
            5 => [
                'title_section' => null,
                'title' => 'Promoción',
                'name_field' => 'credit[applied_loan_discount]',
                'id_field' => 'applied_loan_discount',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],

            6 => [
                'title_section' => null,
                'title' => 'Tipo de firma',
                'name_field' => 'credit[applied_sign_type]',
                'id_field' => 'applied_sign_type',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $sign_type,
                'is_required' => false,
                'is_disabled' => null
            ],
            7 => [
                'title_section' => null,
                'title' => 'Importe solicitado',
                'name_field' => 'credit[applied_import]',
                'id_field' => 'applied_import',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            8 => [
                'title_section' => null,
                'title' => 'Plazo solcitado',
                'name_field' => 'credit[applied_term]',
                'id_field' => 'applied_term',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            9 => [
                'title_section' => null,
                'title' => 'Periodicidad solicitada',
                'name_field' => 'credit[applied_periodicity]',
                'id_field' => 'applied_periodicity',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $periodicity,
                'is_required' => true,
                'is_disabled' => null
            ],
            10 => [
                'title_section' => null,
                'title' => 'Pago solicitado',
                'name_field' => 'credit[applied_payment]',
                'id_field' => 'applied_payment',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            11 => [
                'title_section' => null,
                'title' => 'Monto total del crédito',
                'name_field' => 'credit[applied_loan_total_amount]',
                'id_field' => 'applied_loan_total_amount',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            12 => [
                'title_section' => null,
                'title' => 'Tasa de interés',
                'name_field' => 'credit[applied_interest_rate]',
                'id_field' => 'applied_interest_rate',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            13 => [
                'title_section' => null,
                'title' => 'CAT',
                'name_field' => 'credit[applied_CAT]',
                'id_field' => 'applied_CAT',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function configFormstep3_1($id_rel, $history_id)
    {
        $name_form    = 'frm-template_control_desk_step3_1';
        $type_form    = HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1;
        $sex = config('enums.sex');

        $elements = array(
            1 => [
                'title_section' => 'Generales',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            2 => [
                'title_section' => null,
                'title' => 'Email laboral',
                'name_field' => 'client_person[work_email]',
                'id_field' => 'work_email',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'email',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            3 => [
                'title_section' => null,
                'title' => 'Sexo',
                'name_field' => 'client_person[sex]',
                'id_field' => 'sex',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $sex,
                'is_required' => true,
                'is_disabled' => null
            ],
            4 => [
                'title_section' => null,
                'title' => 'RFC',
                'name_field' => 'client_person[rfc]',
                'id_field' => 'rfc',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            5 => [
                'title_section' => null,
                'title' => 'Nacionalidad',
                'name_field' => 'client_person[nationality]',
                'id_field' => 'nationality',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            6 => [
                'title_section' => null,
                'title' => 'Estado de nacimiento',
                'name_field' => 'client_person[birth_state]',
                'id_field' => 'birth_state',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            6 => [
                'title_section' => null,
                'title' => 'CURP',
                'name_field' => 'client_person[curp]',
                'id_field' => 'curp',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            7 => [
                'title_section' => 'Domicilio',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            8 => [
                'title_section' => null,
                'title' => 'Código postal',
                'name_field' => 'client_person[client_postal_code]',
                'id_field' => 'client_postal_code',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            9 => [
                'title_section' => null,
                'title' => 'Calle',
                'name_field' => 'client_person[client_street]',
                'id_field' => 'client_street',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            10 => [
                'title_section' => null,
                'title' => 'Número exterior',
                'name_field' => 'client_person[client_home_external_number]',
                'id_field' => 'client_home_external_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            11 => [
                'title_section' => null,
                'title' => 'Número interior',
                'name_field' => 'client_person[client_home_internal_number]',
                'id_field' => 'client_home_internal_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            12 => [
                'title_section' => null,
                'title' => 'Colonia',
                'name_field' => 'client_person[client_colony]',
                'id_field' => 'client_colony',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            13 => [
                'title_section' => null,
                'title' => 'Municipio',
                'name_field' => 'client_person[client_city]',
                'id_field' => 'client_city',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            14 => [
                'title_section' => null,
                'title' => 'Estado',
                'name_field' => 'client_person[client_state]',
                'id_field' => 'client_state',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            15 => [
                'title_section' => null,
                'title' => 'País',
                'name_field' => 'client_person[client_country]',
                'id_field' => 'client_country',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            16 => [
                'title_section' => 'Banco',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            15 => [
                'title_section' => null,
                'title' => 'Nombre del banco',
                'name_field' => 'client_person[bank_name]',
                'id_field' => 'bank_name',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            16 => [
                'title_section' => null,
                'title' => 'Número de tarjeta',
                'name_field' => 'client_person[bank_card_number]',
                'id_field' => 'bank_card_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            17 => [
                'title_section' => null,
                'title' => 'Número de cuenta',
                'name_field' => 'client_person[bank_acount_number]',
                'id_field' => 'bank_acount_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            18 => [
                'title_section' => null,
                'title' => 'CLABE interbancaria',
                'name_field' => 'client_person[bank_clabe]',
                'id_field' => 'bank_clabe',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            19 => [
                'title_section' => 'Laboral',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            20 => [
                'title_section' => null,
                'title' => 'Número de empleado',
                'name_field' => 'client_person[employee_number]',
                'id_field' => 'employee_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            21 => [
                'title_section' => null,
                'title' => 'Ingreso mensual',
                'name_field' => 'client_person[monthly_income]',
                'id_field' => 'monthly_income',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            22 => [
                'title_section' => null,
                'title' => 'Código postal',
                'name_field' => 'client_person[workplace_postal_code]',
                'id_field' => 'workplace_postal_code',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            23 => [
                'title_section' => null,
                'title' => 'Calle',
                'name_field' => 'client_person[workplace_street]',
                'id_field' => 'workplace_street',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            24 => [
                'title_section' => null,
                'title' => 'Número exterior',
                'name_field' => 'client_person[workplace_home_external_number]',
                'id_field' => 'workplace_home_external_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            25 => [
                'title_section' => null,
                'title' => 'Número interior',
                'name_field' => 'client_person[workplace_home_internal_number]',
                'id_field' => 'workplace_home_internal_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            26 => [
                'title_section' => null,
                'title' => 'Colonia',
                'name_field' => 'client_person[workplace_colony]',
                'id_field' => 'workplace_colony',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            27 => [
                'title_section' => null,
                'title' => 'Municipio',
                'name_field' => 'client_person[workplace_city]',
                'id_field' => 'workplace_city',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            28 => [
                'title_section' => null,
                'title' => 'Estado',
                'name_field' => 'client_person[workplace_state]',
                'id_field' => 'workplace_state',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            29 => [
                'title_section' => null,
                'title' => 'País',
                'name_field' => 'client_person[workplace_country]',
                'id_field' => 'workplace_country',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function configFormstep3_2($id_rel, $history_id)
    {
        $name_form        = 'frm-template_control_desk_step3_2';
        $type_form        = HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2;
        $marital_status   = config('enums.marital_status');
        $education_level  = config('enums.education_level');
        $home_type        = config('enums.home_type');
        $option_switch    = array(1 => 'Sí', 2 => 'No');
        $prepad_method          = array(1 => 'Efectivo', 2 => 'cheque', 3 => 'transferencia', 4 => 'otro');

        $elements = array(
            1 => [
                'title_section' => 'Generales',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            2 => [
                'title_section' => null,
                'title' => 'Estado civil',
                'name_field' => 'client_person[marital_status]',
                'id_field' => 'marital_status',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $marital_status,
                'is_required' => true,
                'is_disabled' => null
            ],
            3 => [
                'title_section' => null,
                'title' => 'Nivel educativo',
                'name_field' => 'client_person[education_level]',
                'id_field' => 'education_level',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $education_level,
                'is_required' => false,
                'is_disabled' => null
            ],
            4 => [
                'title_section' => null,
                'title' => 'Ocupación',
                'name_field' => 'client_person[profession]',
                'id_field' => 'profession',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            5 => [
                'title_section' => null,
                'title' => 'Horio de contacto',
                'name_field' => 'client_person[client_contact_time]',
                'id_field' => 'client_contact_time',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            6 => [
                'title_section' => 'Familiares',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            7 => [
                'title_section' => null,
                'title' => 'Primer apellido',
                'name_field' => 'client_person[relative_lastname]',
                'id_field' => 'relative_lastname',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            8 => [
                'title_section' => null,
                'title' => 'Segundo Apellido',
                'name_field' => 'client_person[relative_second_lastname]',
                'id_field' => 'relative_second_lastname',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            9 => [
                'title_section' => null,
                'title' => 'Nombres',
                'name_field' => 'client_person[relative_names]',
                'id_field' => 'relative_names',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            10 => [
                'title_section' => null,
                'title' => 'Tel. Fijo',
                'name_field' => 'client_person[relative_local_phone]',
                'id_field' => 'relative_local_phone',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            11 => [
                'title_section' => null,
                'title' => 'Tel. Celular',
                'name_field' => 'client_person[relative_cel_phone]',
                'id_field' => 'relative_cel_phone',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            12 => [
                'title_section' => null,
                'title' => 'Horario de contacto',
                'name_field' => 'client_person[relative_contact_time]',
                'id_field' => 'relative_contact_time',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            13 => [
                'title_section' => null,
                'title' => 'Tipo vivienda',
                'name_field' => 'client_person[home_type]',
                'id_field' => 'home_type',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $home_type,
                'is_required' => false,
                'is_disabled' => null
            ],
            14 => [
                'title_section' => null,
                'title' => 'Tiempo de vivir ahí',
                'name_field' => 'client_person[home_time_living]',
                'id_field' => 'home_time_living',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            15 => [
                'title_section' => null,
                'title' => 'Comentarios vivienda',
                'name_field' => 'client_person[home_note]',
                'id_field' => 'home_note',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            16 => [
                'title_section' => null,
                'title' => 'Número de propiedades',
                'name_field' => 'client_person[propety_ownnership_amount]',
                'id_field' => 'propety_ownnership_amount',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            17 => [
                'title_section' => null,
                'title' => 'Varlos estimado de propiedades',
                'name_field' => 'client_person[propety_ownnership_value]',
                'id_field' => 'propety_ownnership_value',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            18 => [
                'title_section' => null,
                'title' => 'Número de vehículos propios',
                'name_field' => 'client_person[vehicle_ownnership_amount]',
                'id_field' => 'vehicle_ownnership_amount',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            19 => [
                'title_section' => null,
                'title' => 'Varlos estimado de vehículos',
                'name_field' => 'client_person[vehicle_ownnership_value]',
                'id_field' => 'vehicle_ownnership_value',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            20 => [
                'title_section' => null,
                'title' => 'Número de dependientes económicos',
                'name_field' => 'client_person[economic_dependents]',
                'id_field' => 'economic_dependents',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            21 => [
                'title_section' => 'Laboral',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            22 => [
                'title_section' => null,
                'title' => 'Centro de trabajo',
                'name_field' => 'client_person[workplace_name]',
                'id_field' => 'workplace_name',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            23 => [
                'title_section' => null,
                'title' => 'Fecha de ingreso',
                'name_field' => 'client_person[admission_date]',
                'id_field' => 'admission_date',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'date',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            24 => [
                'title_section' => null,
                'title' => 'Área',
                'name_field' => 'client_person[employee_area]',
                'id_field' => 'employee_area',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            25 => [
                'title_section' => null,
                'title' => 'Puesto',
                'name_field' => 'client_person[employee_position]',
                'id_field' => 'employee_position',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            26 => [
                'title_section' => null,
                'title' => 'Fuente de ingresos adicionales',
                'name_field' => 'client_person[aditional_labor_source]',
                'id_field' => 'aditional_labor_source',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            27 => [
                'title_section' => null,
                'title' => 'Ingresos adicionales',
                'name_field' => 'client_person[aditional_labor_income]',
                'id_field' => 'aditional_labor_income',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            27 => [
                'title_section' => null,
                'title' => 'Tel fijo',
                'name_field' => 'client_person[workplace_local_phone]',
                'id_field' => 'workplace_local_phone',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            27 => [
                'title_section' => null,
                'title' => 'Tel celular',
                'name_field' => 'client_person[workplace_cel_phone]',
                'id_field' => 'workplace_cel_phone',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            27 => [
                'title_section' => null,
                'title' => 'Clave centro trabajo',
                'name_field' => 'client_person[workplace_code]',
                'id_field' => 'workplace_code',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            27 => [
                'title_section' => null,
                'title' => 'Extensión',
                'name_field' => 'client_person[workplace_local_phone_extension]',
                'id_field' => 'workplace_local_phone_extension',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            28 => [
                'title_section' => 'Referencias',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            29 => [
                'title_section' => 'PLD',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            30 => [
                'title_section' => null,
                'title' => 'Cliente funcionario público',
                'name_field' => 'credit[client_public_servant]',
                'id_field' => 'client_public_servant',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' =>  'switch',
                'is_option_array' => false,
                'options' => $option_switch,
                'is_required' => false,
                'is_disabled' => null
            ],
            31 => [
                'title_section' => null,
                'title' => 'Puesto',
                'name_field' => 'credit[client_public_servant_position]',
                'id_field' => 'client_public_servant_position',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            32 => [
                'title_section' => null,
                'title' => 'Período',
                'name_field' => 'credit[client_public_servant_period]',
                'id_field' => 'client_public_servant_period',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            33 => [
                'title_section' => null,
                'title' => 'Familiar funcionario público',
                'name_field' => 'credit[relative_public_servant]',
                'id_field' => 'relative_public_servant',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' =>  'switch',
                'is_option_array' => false,
                'options' => $option_switch,
                'is_required' => false,
                'is_disabled' => null
            ],
            34 => [
                'title_section' => null,
                'title' => 'Primer apellido',
                'name_field' => 'credit[relative_public_servant_lastname]',
                'id_field' => 'relative_public_servant_lastname',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            35 => [
                'title_section' => null,
                'title' => 'Segundo apellido',
                'name_field' => 'credit[relative_public_servant_second_lastname]',
                'id_field' => 'relative_public_servant_second_lastname',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            35 => [
                'title_section' => null,
                'title' => 'Segundo apellido',
                'name_field' => 'credit[relative_public_servant_names]',
                'id_field' => 'relative_public_servant_names',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            35 => [
                'title_section' => null,
                'title' => 'Segundo apellido',
                'name_field' => 'credit[relative_public_servant_relationship]',
                'id_field' => 'relative_public_servant_relationship',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            35 => [
                'title_section' => null,
                'title' => 'Segundo apellido',
                'name_field' => 'credit[relative_public_servant_position]',
                'id_field' => 'relative_public_servant_position',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            35 => [
                'title_section' => null,
                'title' => 'Segundo apellido',
                'name_field' => 'credit[relative_public_servant_period]',
                'id_field' => 'relative_public_servant_period',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            36 => [
                'title_section' => null,
                'title' => 'Pagos anticipados',
                'name_field' => 'credit[prepaid]',
                'id_field' => 'prepaid',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' =>  'switch',
                'is_option_array' => false,
                'options' => $option_switch,
                'is_required' => false,
                'is_disabled' => null
            ],
            37 => [
                'title_section' => null,
                'title' => 'Método de pago',
                'name_field' => 'credit[prepad_method]',
                'id_field' => 'prepad_method',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' =>  'switch',
                'is_option_array' => false,
                'options' => $prepad_method,
                'is_required' => false,
                'is_disabled' => null
            ],
            38 => [
                'title_section' => null,
                'title' => 'Frecuencia de pago',
                'name_field' => 'credit[prepaid_frequency]',
                'id_field' => 'prepaid_frequency',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            39 => [
                'title_section' => null,
                'title' => 'Origen de recursos',
                'name_field' => 'credit[prepaid_source]',
                'id_field' => 'prepaid_source',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            40 => [
                'title_section' => 'Otros datos',
                'title' => null,
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => null,
                'is_disabled' => null
            ],
            41 => [
                'title_section' => null,
                'title' => 'Aval',
                'name_field' => 'credit[endorsement]',
                'id_field' => 'endorsement',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' =>  'switch',
                'is_option_array' => false,
                'options' => $option_switch,
                'is_required' => false,
                'is_disabled' => null
            ],
            42 => [
                'title_section' => null,
                'title' => 'Beneficiario real',
                'name_field' => 'credit[real_beneficiary]',
                'id_field' => 'real_beneficiary',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' =>  'switch',
                'is_option_array' => false,
                'options' => $option_switch,
                'is_required' => false,
                'is_disabled' => null
            ],
            43 => [
                'title_section' => null,
                'title' => 'Proveedor de recursos',
                'name_field' => 'credit[soruce_provider]',
                'id_field' => 'soruce_provider',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' =>  'switch',
                'is_option_array' => false,
                'options' => $option_switch,
                'is_required' => false,
                'is_disabled' => null
            ],
            44 => [
                'title_section' => null,
                'title' => 'Propietario real',
                'name_field' => 'credit[real_propetary]',
                'id_field' => 'real_propetary',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' =>  'switch',
                'is_option_array' => false,
                'options' => $option_switch,
                'is_required' => false,
                'is_disabled' => null
            ],
            45 => [
                'title_section' => null,
                'title' => 'Comentarios',
                'name_field' => 'credit[notes]',
                'id_field' => 'notes',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'textarea',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null,
                'col' => 'col-md-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function saveForm($request)
    {
        $id_rel               = $request->id_rel;
        $credit               = Credit::find($id_rel);

        if ($request->credit) {
            $data_credit = $request->credit;
            $credit->fill($data_credit);
            $credit->update();
        }

        $client = ClientPerson::find($credit->client_person_id);
        if ($request->client_person) {
            $data_client_person = $request->client_person;
            $client->fill($data_client_person);
            $client->update();
        }
    }

    public function listStep($history_id)
    {
        $history              = HistoryLog::find($history_id);

        $credit               = $history->historyCredit;
        $max_hour             = 12;
        $hour                 = $credit->created_at;
        
        $percent_form         = self::percentForm($history); // etapa 1
        
        $percent_form_step2   = self::percentFormStep2($history); // etapa 2

        $percent_form_step3_1   = self::percentFormStep3_1($history); //etapa 3
        $percent_form_step3_2 = self::percentFormStep3_2($history); //etapa 3
        $percent_form_step3 = $percent_form_step3_1 + $percent_form_step3_2;
        if ($percent_form_step3 == 200) {
            $percent_form_step3 = 100;
        }

        $percent_file         = 100;
        $color_inf_credit     = 'success';
        $color_report         = 'success';
        $option_step2         = null;
        $option_step3         = null;
        $total_percent        = $percent_file + $percent_form;
        //$percent_form = $percent_form;
        $menu_options         = self::menuOptionsStep($history);
        $status_step2         = 'En espera';
        $status_step3         = 'En espera';

        $status_step1 = ($percent_form >= 100) ? 'Concluido' : 'En curso';
        //TODO: change validation when the decision action is carried out in the report
        if ($status_step1 == 'Concluido') {
            $status_step2 = ($percent_form_step2 >= 100) ? 'Concluido' : 'En espera';
            $status_step3 = ($percent_form_step3 >= 100) ? 'Concluido' : 'En espera';
        }

        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        $option_inf_credit  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();

        if ($status_step1 == 'Concluido') {
            $option_step2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep2']])->render();
        }

        if ($status_step2 == 'Concluido') {
            $option_step3  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep3']])->render();
        }


        $view_percent_inf_credit    = \View::make('panel.module.view_percent', ['percent' => $percent_form])->render();
        $view_percent_step2    = \View::make('panel.module.view_percent', ['percent' => $percent_form_step2])->render();
        $view_percent_step3    = \View::make('panel.module.view_percent', ['percent' => $percent_form_step3])->render();
        $view_count_inf_credit      = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        $view_percent_report        = \View::make('panel.module.view_percent', ['percent' => 0])->render();
        $view_count_step2          = \View::make('panel.module.view_count', ['number' => 'Dos'])->render();
        $view_count_step3          = \View::make('panel.module.view_count', ['number' => 'Tres'])->render();


        $data = array();
        $data[] = array(
            'name' => $view_count_inf_credit,
            'step' => 'Viabilidad',
            'status' => $status_step1,
            'progress' => $view_percent_inf_credit,
            'deadline' => $view_dead_line_inf_credit,
            'options' => $option_inf_credit,
        );
        $data[] = array(
            'name' => $view_count_step2,
            'step' => 'Características del crédito',
            'status' => $status_step2,
            'progress' => $view_percent_step2,
            'deadline' => '',
            'options' => $option_step2,
        );

        $data[] = array(
            'name' => $view_count_step3,
            'step' => 'Captura de información',
            'status' => $status_step3,
            'progress' => $view_percent_step3,
            'deadline' => '',
            'options' => $option_step3,
        );
        return $data;
    }

    public function listAction($history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == 2) {
            return self::actionStep2($history_id);
        } elseif ($step == 3) {
            return self::actionStep3($history_id);
        }
        return self::actionStep1($history_id);
    }

    public function actionStep1($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_file   = self::percentFile($credit->id);
        $percent_form   = self::percentForm($history);
        $status_file    =  $percent_file == 100 ? 'Concluido' : 'En curso';
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $max_hour       = 6;
        $hour           = $history->created_at;

        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptions($history, 1);
        $color_inf_credit = 'success';

        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];


        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();
        $data[] = array(
            'name' => 'Carga',
            'status' => $status_file,
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $file_option,
        );

        $data[] = array(
            'name' => 'Formulario',
            'status' => $status_form,
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );

        return $data;
    }

    public function actionStep2($history_id)
    {

        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_form   = self::percentFormStep2($history);
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $max_hour       = 3;
        $hour           = $history->created_at;

        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptions($history, 2);
        $color_inf_credit = 'success';

        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];


        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();

        $data[] = array(
            'name' => 'Formulario',
            'status' => $status_form,
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );

        return $data;
    }

    public function actionStep3($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_file   = self::percentFile($credit->id);
        $percent_form   = self::percentForm($history);
        $status_file    =  $percent_file == 100 ? 'Concluido' : 'En curso';
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $max_hour       = 6;
        $hour           = $history->created_at;

        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptionsStep3($history);
        $color_inf_credit = 'success';

        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];


        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        $form_option2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form2']])->render();
        $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();
        $data[] = array(
            'name' => 'Carga',
            'status' => $status_file,
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $file_option,
        );

        $data[] = array(
            'name' => 'Formulario',
            'status' => $status_form,
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );

        $data[] = array(
            'name' => 'Formulario',
            'status' => $status_form,
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $form_option2,
        );

        return $data;
    }

    public function listStepReport($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $max_hour       = 12;
        $hour           = $credit->created_at;
        $menu_options   = self::menuOptionReportStep($history);
        $advisor        = $credit->creditAdvisor;

        $name_module_response   = 'KaaxClub';
        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
        $color_desition   = 'success';
        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;

        $data_deadline    = deadline($hour, $max_hour, 0, 'success');
        $color_desition = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        $view_dead_line_desition  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_desition])->render();
        $options_progress  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['progress']])->render();
        $options_desition  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['desition']])->render();

        $data = array();
        $status_desition = 'En curso';
        $data[] = array(
            'name' => 'Respuesta de módulo',
            'status' => 'Concluida',
            'deadline' => 'N/A',
            'advisor' => $name_module_response,
            'options' => $options_progress,
        );

        $data[] = array(
            'name' => 'Decisión',
            'status' => $status_desition,
            'deadline' => $view_dead_line_desition,
            'advisor' => $name_advisor,
            'options' => $options_desition,
        );

        return $data;
    }

    public function menuOptions($history, $step)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/template/action-document/controlDesk/' . $history->id . '?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

            )
        );

        return $menu;
    }

    public function menuOptionsStep3($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=3_1',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=3_2',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/template/action-document/controlDesk/' . $history->id . '?step=3',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

            )
        );

        return $menu;
    }

    public function menuOptionsStep($history)
    {
        $menu = array(
            'actionstep1' => array(
                [
                    'link' => '/panel/template/actions/controlDesk/' . $history->id . '/show?step=1',
                    'onclick' => '',
                    'name' => 'Lista de acciones',
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep2' => array(
                [
                    'link' => '/panel/template/actions/controlDesk/' . $history->id . '/show?step=2',
                    'onclick' => '',
                    'name' => 'Lista de acciones',
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep3' => array(
                [
                    'link' => '/panel/template/actions/controlDesk/' . $history->id . '/show?step=3',
                    'onclick' => '',
                    'name' => 'Lista de acciones',
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),

        );

        return $menu;
    }

    public function menuOptionReportStep($history)
    {
        $menu = array(
            'progress' => array(
                [
                    'link' => '/panel/kc-check-up/report/answer_module/' . $history->id . '/show/',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut',
                ]
            ),
            'desition' => array(
                [
                    'link' => '/panel/kc-check-up/report/desition/' . $history->id . '/show/',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut',
                ]
            )
        );
        return $menu;
    }

    public function percentForm($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $total_valid = 0;
        if ($credit != null && $credit->payment_capacity_period != '') {
            $total_valid = $total_valid + 20;
        }

        if ($credit != null && $credit->payment_capacity != null) {
            $total_valid = $total_valid + 20;
        }

        if ($client != null && $client->birth_date != null) {
            $total_valid = $total_valid + 20;
        }

        if ($client != null && $client->labor_old != null) {
            $total_valid = $total_valid + 20;
        }

        if ($client != null && $client->employee_category != null) {
            $total_valid = $total_valid + 20;
        }
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    public function percentFormStep2($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $total_valid = 0;
        if ($credit != null && $credit->applied_financial != '') {
            $total_valid = $total_valid + 10;
        }

        if ($credit != null && $credit->applied_financial_product != null) {
            $total_valid = $total_valid + 10;
        }

        if ($credit != null && $credit->applied_loan_type != null) {
            $total_valid = $total_valid + 10;
        }

        if ($credit != null && $credit->applied_import != null) {
            $total_valid = $total_valid + 10;
        }

        if ($credit != null && $credit->applied_term != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_periodicity != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_payment != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_loan_total_amount != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_interest_rate != null) {
            $total_valid = $total_valid + 10;
        }
        if ($credit != null && $credit->applied_CAT != null) {
            $total_valid = $total_valid + 10;
        }
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    public function percentFormStep3_1($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $total_valid = 0;
        if ($client != null && $client->sex != '') {
            $total_valid = $total_valid + 5;
        }

        if ($client != null && $client->rfc != null) {
            $total_valid = $total_valid + 5;
        }

        if ($client != null && $client->nationality != null) {
            $total_valid = $total_valid + 5;
        }

        if ($client != null && $client->birth_state != null) {
            $total_valid = $total_valid + 5;
        }

        if ($client != null && $client->curp != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->client_postal_code != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->client_street != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->client_home_external_number != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->client_home_internal_number != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->client_colony != null) {
            $total_valid = $total_valid + 5;
        }
        
        if ($client != null && $client->client_city != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->client_state != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->client_country != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->monthly_income != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->workplace_postal_code != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->workplace_street != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->workplace_home_external_number != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->workplace_home_internal_number != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->workplace_colony != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->workplace_city != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->workplace_state != null) {
            $total_valid = $total_valid + 5;
        }
        if ($client != null && $client->workplace_country != null) {
            $total_valid = $total_valid + 5;
        }
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    public function percentFormStep3_2($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $total_valid = 0;
        if ($client != null && $client->marital_status != '') {
            $total_valid = 100;
        }
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    //* get all percentages of the shares
    public function getPercent($history)
    {
        $percent_form = self::percentForm($history) / 2;
        $percent_desition = 0;
        $total_valid = $percent_form  + $percent_desition;

        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    public function getFile($template_config_id)
    {
        $config = self::configUpload()[$template_config_id];
        return $config;
    }

    //*TODO: se deshabilito al ser opcional la caja de carga
    public function percentFile($id_rel)
    {
        $model = File::MODEL['controlDesk'];
        $percent = 0;
        $total_valid = 4;
        $count_file = 0;
        $percent_file = 0;
        $config_files = self::configUpload();

        foreach ($config_files as $key => $config_file) {
            $file = File::where([
                'model' => $model,
                'id_rel' => $id_rel,
                'template_config_id' => $key,
            ])
                ->first();
            if ($file != null) {
                $count_file = $count_file + 1;
                $percent_file = $percent_file + 25;
            }
        }

        $percent =  (100 / 100) * $percent_file;
        return $percent;
    }
}
