<?php

namespace App\Strategies\Templates;

use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\File;
use App\Models\Financial;
use App\Models\FinancialProduct;
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
    const HOUR_STEP_1  = 6;
    const HOUR_STEP_2  = 3;
    const HOUR_STEP_3  = 6;
    const HOUR_STEP_4  = 1;
    const HOUR_STEP_5  = 4;

    public function move($id)
    {
    }

    public function configUpload($set_step = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        
        if ($set_step != null) {
            $step = $set_step;
        }

        if ($step == 3) {
            return self::uploadStep3();
        }
        return self::uploadStep1();
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
                'is_required' => true,
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
        } elseif ($step == '4') {
            return self::configFormstep4($id_rel, $history_id);
        } elseif ($step == '5') {
            return self::configFormstep5($id_rel, $history_id);
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
        $credit =Credit::find($id_rel);
        $name_form = 'frm-template_control_desk_step2';
        $type_form = HistoryLog::KC_CONTROL_DESK_FORM_STEP_2;
        $financial = Financial::select('id', 'commercial_name as name')->get();
        $product = FinancialProduct::getProductByFinancial($credit->applied_financial);
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
    
    public function configFormstep4($id_rel, $history_id)
    {
        $name_form        = 'frm-template_control_desk_step4';
        $type_form        = HistoryLog::KC_CONTROL_DESK_FORM_STEP_4;
        $marital_status   = config('enums.marital_status');
        $education_level  = config('enums.education_level');
        $home_type        = config('enums.home_type');
        $option_switch    = array(1 => 'Sí', 2 => 'No');
        $prepad_method          = array(1 => 'Efectivo', 2 => 'cheque', 3 => 'transferencia', 4 => 'otro');
        $credit = Credit::find($id_rel);
        $client_person = $credit->creditClientPerson;
        $curp = $client_person != null ? $client_person->curp : null;
        $show_btn = false;
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
                'title' => 'Validar CURP',
                'name_field' => 'client_person[curp]',
                'id_field' => 'curp',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => true,
                'is_disabled' => null,
                'value' => $curp
            ],
            3 => [
                'title_section' => null,
                'title' => 'Guardar',
                'name_field' => null,
                'id_field' => null,
                'col' => 'col-12',
                'class' => 'btn btn-primary',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'href',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => true,
                'is_disabled' => null,
                'onclick' => 'kycCreditHistory('.$history_id.')'
            ],
            
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'show_btn' => $show_btn, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    public function configFormstep5($id_rel, $history_id)
    {
        $name_form        = 'frm-template_control_desk_step5';
        $type_form        = HistoryLog::KC_CONTROL_DESK_FORM_STEP_5;
        $credit = Credit::find($id_rel);
        $user_financials = User::getUserRole('Cliente financiera');
        $option_user_financial = array();
        $step_origin    = isset($_GET['step_origin']) ? $_GET['step_origin'] : null;

        foreach ($user_financials as $user) {
            $name = $user->name.' '.$user->last_name.' '.$user->second_last_name;
            $option_user_financial[$user->id] = $name;
        }

        $elements = array(
            1 => [
                'title_section' => 'Asignar usuario financiera',
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
            //*TODO: Verificar la accion al guardar para los nombres de campos
            2 => [
                'title_section' => null,
                'title' => 'Usuario financiera',
                'name_field' => 'credit[financial_user_assigned]',
                'id_field' => 'financial_user_assigned',
                'comment_admin' => 'Selecciona un usuario financiera',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $option_user_financial,
                'is_required' => true,
                'is_disabled' => null,
                'value' => null
            ],
            3 => [
                'title_section' => null,
                'title' => 'Comisión',
                'name_field' => 'credit[commission]',
                'id_field' => 'commission',
                'comment_admin' => ' Indica el importe de la comisión',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => true,
                'is_disabled' => null,
                'value' => null
            ],
            
            4 => [
                'title_section' => null,
                'title' => 'Comentario',
                'name_field' => 'credit[commission_note]',
                'id_field' => 'commission_note',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'textarea',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => null,
                'col' => 'col-12'
            ],
            
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect',
                'id_field' => 'url_redirect',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/kc-delivery',
                'col' => 'col-12'
            ],
            
            6 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'step_origin',
                'id_field' => null,
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => $step_origin,
                'col' => 'col-12'
            ],
            
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function saveForm($request)
    {
        $id_rel         = $request->id_rel;
        $credit         = Credit::find($id_rel);
        $history        = HistoryLog::find($request->history_id);
        $step_origin    = isset($request->step_origin) ? $request->step_origin : null;

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
        if ($history != null) {
            $percent_form_step1   = self::percentForm($history);
            $percent_form_step2   = self::percentFormStep2($history);
            $percent_form_step3   = self::percentFormStep3_1($history);
            $percent_form_step3_2   = self::percentFormStep3_2($history);
            //* percent 4 is in kccontroldeskcontroller function validateKyc
            $percent_form_step5   = self::percentFormStep5($history);
            
            
            if ($percent_form_step1 == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM, $credit->id, 1);
                HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_FORM_STEP_2, HistoryLog::KC_CONTROL_DESK_FORM_STEP_2, null, false);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_2, $credit->id, 0);
            }
            
            if ($percent_form_step2 == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_2, $credit->id, 1);
                 //*inicializar las acciones de la siguiente etapa en curso
                HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1, HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1, null, false);
                HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1, HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1, null, false);
                HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2, HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2, null, false);

                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1, $credit->id, 0);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1, $credit->id, 0);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2, $credit->id, 0);
            }

            if ($percent_form_step3 == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1, $credit->id, 1);
            }
            
            if ($percent_form_step3_2 == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2, $credit->id, 1);
            }
            
            if ($percent_form_step3 == 100 && $percent_form_step3_2 == 100) {
                 //*inicializar las acciones de la siguiente etapa en curso
                 HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_FORM_STEP_4, HistoryLog::KC_CONTROL_DESK_FORM_STEP_4, null, false);
                 HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_4, $credit->id, 0);
            }

            if ($percent_form_step5 == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_FORM_STEP_5, $credit->id, 1);
                HistoryLog::move($credit->id, HistoryLog::KC_DELIVERY, HistoryLog::KC_CONTROL_DESK, null, false);
                $notification_add   = SendNotificationsValues::STRATEGY['pushCreditKcDelivery'];
                (new $notification_add)->send($credit->id);
                if ($step_origin == 1) { //* comes from swap, create the next stages
                    
                }
            }
        }
    }

    public function listStep($history_id)
    {
        
        $history                      = HistoryLog::find($history_id);

        $credit                       = $history->historyCredit;
        $max_hour                     = 12;
        $hour                         = $credit->created_at;
        
        $percent_file                 = self::percentFile($credit->id);
        $percent_form                 = self::percentForm($history); // etapa 1
        $file                         = $percent_file == 100 ? 50 : 0;
        $form                         = $percent_form == 100 ? 50 : 0;
        $total_percent                = $file + $form;
        $percent_form_step2           = self::percentFormStep2($history); // etapa 2
        
        $percent_form_step3_upload    = self::percentFile($credit->id, 3);
        $percent_form_step3_1         = self::percentFormStep3_1($history); //etapa 3
        $percent_form_step3_2         = self::percentFormStep3_2($history); //etapa 3
        
        $percent_form_step4           = self::percentFormStep4($history); //etapa 4
        
        $percent_form_step5           = self::percentFormStep5($history); //etapa 5
        
        $new_step3 = $percent_form_step3_upload == 100 ? 1 : 0;
        $new_step3_1 = $percent_form_step3_1 == 100 ? 1 : 0;
        $new_step3_2 = $percent_form_step3_2 == 100 ? 1 : 0;
        
        $percent_form_step3 = ($new_step3 + $new_step3_1 + $new_step3_2) / 3* 100;

        $color_inf_credit     = 'success';
        $color_report         = 'success';
        $option_step2         = null;
        $option_step3         = null;
        $option_step4         = null;
        $option_step5         = null;
        
        //$percent_form = $percent_form;
        $menu_options         = self::menuOptionsStep($history);
        $status_step2         = 'En espera';
        $status_step3         = 'En espera';
        $status_step4         = 'En espera';
        $status_step5         = 'En espera';

        $status_step1 = ($percent_form >= 100) ? 'Concluido' : 'En curso';
        //TODO: change validation when the decision action is carried out in the report
        if ($status_step1 == 'Concluido') {
            $status_step2 = ($percent_form_step2 >= 100) ? 'Concluido' : 'En curso';
            $status_step3 = ($percent_form_step3 >= 100) ? 'Concluido' : 'En curso';
            $status_step4 = ($percent_form_step4 >= 100) ? 'Concluido' : 'En curso';
            $status_step5 = ($percent_form_step5 >= 100) ? 'Concluido' : 'En curso';
        }
        
        $data_deadline    = deadline($hour, $max_hour, $total_percent, $color_inf_credit);
        
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        $option_inf_credit  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();

        if ($status_step1 == 'Concluido') {
            $option_step2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep2']])->render();
        }

        if ($status_step2 == 'Concluido') {
            $option_step3  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep3']])->render();
        }
       
        if ($status_step3 == 'Concluido') {
            $option_step4  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep4']])->render();
        }
        if ($status_step4 == 'Concluido') {
            $option_step5  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep5']])->render();
        }
        

        $view_percent_inf_credit    = \View::make('panel.module.view_percent', ['percent' => $total_percent])->render();
        $view_percent_step2    = \View::make('panel.module.view_percent', ['percent' => $percent_form_step2])->render();
        $view_percent_step3    = \View::make('panel.module.view_percent', ['percent' => $percent_form_step3])->render();
        $view_percent_step4    = \View::make('panel.module.view_percent', ['percent' => $percent_form_step4])->render();
        $view_percent_step5    = \View::make('panel.module.view_percent', ['percent' => $percent_form_step5])->render();

        $view_count_inf_credit      = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_count_step2          = \View::make('panel.module.view_count', ['number' => 'Dos'])->render();
        $view_count_step3          = \View::make('panel.module.view_count', ['number' => 'Tres'])->render();
        $view_count_step4          = \View::make('panel.module.view_count', ['number' => 'Cuatro'])->render();
        $view_count_step5          = \View::make('panel.module.view_count', ['number' => 'Cinco'])->render();


        $data = array();
        $data[] = array(
            'name' => $view_count_inf_credit,
            'step' => 'Viabilidad',
            'status' => $status_step1,
            'progress' => $view_percent_inf_credit,
            'deadline' => '',
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
        
        $data[] = array(
            'name' => $view_count_step4,
            'step' => 'KYC',
            'status' => $status_step4,
            'progress' => $view_percent_step4,
            'deadline' => null,
            'options' => $option_step4,
        );
        
        $data[] = array(
            'name' => $view_count_step5,
            'step' => 'Asignar usuario financiera',
            'status' => $status_step5,
            'progress' => $view_percent_step5,
            'deadline' => '',
            'options' => $option_step5,
        );
        return $data;
    }

    public function moduleDeadline($history)
    {
        $max_hour           = 20;
        $percent            = self::getPercent($history);
        $color_inf_credit   = 'success';
        $hour               = $history->created_at;
        $data_deadline      = deadline($hour, $max_hour, $percent, $color_inf_credit);
        $color_inf_credit   = $data_deadline['color'];
        $hour               = $data_deadline['lbl_hour'];
        $view_deadline      = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_deadline;
        
    }

    public function listAction($history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == 2) {
            return self::actionStep2($history_id);
        } elseif ($step == 3) {
            return self::actionStep3($history_id);
        } elseif ($step == 4) {
            return self::actionStep4($history_id);
        } elseif ($step == 5) {
            return self::actionStep5($history_id);
        }
        return self::actionStep1($history_id);
    }

    public function dinamicDeadline($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percents                     = array(
            HistoryLog::KC_CONTROL_DESK_UPLOAD => self::percentFile($credit->id),
            HistoryLog::KC_CONTROL_DESK_FORM => self::percentForm($history),
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_2 => self::percentFormStep2($history),
            HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1 => self::percentFile($credit->id, 3),
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1 => self::percentFormStep3_1($history),
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2 => self::percentFormStep3_2($history),
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_4 => self::percentFormStep4($history),
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_5 => self::percentFormStep5($history),
        );
        $hours = array(
            HistoryLog::KC_CONTROL_DESK_UPLOAD => self::HOUR_STEP_1,
            HistoryLog::KC_CONTROL_DESK_FORM => self::HOUR_STEP_1,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_2 => self::HOUR_STEP_2,
            HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1 => self::HOUR_STEP_3,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1 => self::HOUR_STEP_3,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2 => self::HOUR_STEP_3,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_4 => self::HOUR_STEP_4,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_5 => self::HOUR_STEP_5,
        );
        $menus = self::menuOptions($history);
        $menu_step2   = self::menuOptions($history, 2);
        $menu_step3   = self::menuOptionsStep3($history, 3);
        $menu_step4   = self::menuOptionsStep4($history);
        $menu_step5   = self::menuOptionsStep5($history);

        $option_step1  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menus['file']])->render();
        $option_step1_2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menus['form']])->render();
        
        $option_step2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_step2['form']])->render();
        
        $option_step3  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_step3['file']])->render();
        $option_step3_1  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_step3['form']])->render();
        $option_step3_2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_step3['form2']])->render();


        $option_step4  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_step4['form']])->render();

        $option_step5  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_step5['form']])->render();
        
        $menu_options = array(
            HistoryLog::KC_CONTROL_DESK_UPLOAD => $option_step1,
            HistoryLog::KC_CONTROL_DESK_FORM => $option_step1_2,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_2 => $option_step2,
            HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1 => $option_step3,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1 => $option_step3_1,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2 => $option_step3_2,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_4 => $option_step4,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_5 => $option_step5,
        );

        $menu               = $menu_options[$history->status_id];
        $percent            = $percents[$history->status_id];
        $in_progress        = HistoryLog::getByStatus([$history->status_id], $credit->id)[0];
        $hour               = $in_progress->date_status_progress;
        $max_hour           = $hours[$history->status_id];
        $data_deadline      = deadline($hour, $max_hour, $percent, $color_inf_credit);
        $color_inf_credit   = $data_deadline['color'];
        $hour               = $data_deadline['lbl_hour'];
        $view_dead_line     = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        
        return array('deadline' => $view_dead_line, 'percent' => $percent, 'menu' => $menu);
    }

    public function deadLineUploadStep1($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFile($credit->id);
        
        if ($percent_form == 100) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_UPLOAD, $credit->id, 1);
        }
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_UPLOAD], $credit->id)[0];
        $hour                         = $in_progress->date_status_progress;
        $max_hour                     = self::HOUR_STEP_1;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }
    
    public function deadLineStep1($history)
    {
        $color_inf_credit   = 'success';
        $percent_form       = self::percentForm($history);
        $credit             = $history->historyCredit;

       
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_FORM], $credit->id)[0];
        $hour                         = $in_progress->date_status_progress;
        $max_hour                     = self::HOUR_STEP_1;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function actionStep1($history_id, $step_origin = null)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_file   = self::percentFile($credit->id);
        $percent_form   = self::percentForm($history);
        $status_file    =  $percent_file == 100 ? 'Concluido' : 'En curso';
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        
        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
        
        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptions($history, 1, $step_origin);
        $view_dead_line_upload  = self::deadLineUploadStep1($history);
        $view_dead_line_form  = self::deadLineStep1($history);
        
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
        
        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }
        
        $data = array();
        
        $subject1 = HistoryLog::$label_subject[22];
        $subject2 = HistoryLog::$label_subject[23];
        
        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject1,
            'status' => $status_file,
            'deadline' => $view_dead_line_upload,
            'advisor' => $name_advisor,
            'options' => $file_option,
        );

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject2,
            'status' => $status_form,
            'deadline' => $view_dead_line_form,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );

        return $data;
    }

    

    public function deadLineStep2($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFormStep2($history);
        $max_hour                     = self::HOUR_STEP_2;
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_FORM_STEP_2], $credit->id)[0];
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function actionStep2($history_id, $step_origin = null)
    {

        
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_form   = self::percentFormStep2($history);
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $user = User::find($advisor->id);
        
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptions($history, 2, $step_origin);
        $view_dead_line_inf_credit  = self::deadLineStep2($history);
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();

        $subject1 = HistoryLog::$label_subject[24];

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' => $status_form,
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );

        return $data;
    }

    public function deadLineUploadStep3($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_file   = self::percentFile($credit->id, 3);
        
        if ($percent_file == 100) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1, $credit->id, 1);
        }
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1], $credit->id)[0];
        $hour                         = $in_progress->date_status_progress;
        $max_hour                     = self::HOUR_STEP_3;
        $data_deadline                = deadline($hour, $max_hour, $percent_file, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function deadLineStep3($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form1                = self::percentFormStep3_1($history);
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1], $credit->id)[0];
        $max_hour                     = self::HOUR_STEP_3;
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form1, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        return $view_dead_line_inf_credit;
    }
    
    public function deadLineStep3_2($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form1                = self::percentFormStep3_2($history);
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1], $credit->id)[0];
        $max_hour                     = self::HOUR_STEP_3;
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form1, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        return $view_dead_line_inf_credit;
    }
    

    public function actionStep3($history_id, $step_origin = null)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_file   = self::percentFile($credit->id, 3);
        $percent_form1   = self::percentFormStep3_1($history);
        $percent_form2   = self::percentFormStep3_2($history);
        $status_form1 = 'En espera';
        $status_form2 = 'En espera';

        $status_file    =  $percent_file == 100 ? 'Concluido' : 'En curso';
        $status_form1    = $percent_form1 == 100 ? 'Concluido' : 'En curso';
        $status_form2    = $percent_form2 == 100 ? 'Concluido' : 'En curso';

        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptionsStep3($history, $step_origin);


        $view_dead_line1  = self::deadLineUploadStep3($history);
        $view_dead_line2  = self::deadLineStep3($history);
        $view_dead_line3  = self::deadLineStep3_2($history);

        $view_dead_line_inf_credit  =self::deadLineStep3($history);
        $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        $form_option2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form2']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();

        $subject1 = HistoryLog::$label_subject[25];
        $subject2 = HistoryLog::$label_subject[26];
        $subject3 = HistoryLog::$label_subject[27];

        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject1,
            'status' => $status_file,
            'deadline' => $view_dead_line1,
            'advisor' => $name_advisor,
            'options' => $file_option,
        );

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject2,
            'status' => $status_form1,
            'deadline' => $view_dead_line2,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject3,
            'status' => $status_form2,
            'deadline' => $view_dead_line3,
            'advisor' => $name_advisor,
            'options' => $form_option2,
        );

        return $data;
    }

    public function deadLineStep4($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form1                = self::percentFormStep4($history);
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1], $credit->id)[0];
        $max_hour                     = self::HOUR_STEP_4;
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form1, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        return $view_dead_line_inf_credit;
    }
    
    
    public function actionStep4($history_id, $step_origin = null)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;

        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptionsStep4($history, $step_origin);

        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        $view_dead_line1  = self::deadLineStep4($history);

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();
        
        $subject1 = HistoryLog::$label_subject[28];

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' =>  'Opcional',
            'deadline' => $view_dead_line1,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );

        return $data;
    }

    public function deadLineStep5($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form1                = self::percentFormStep5($history);
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_FORM_STEP_5], $credit->id)[0];
        $max_hour                     = self::HOUR_STEP_5;
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form1, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        return $view_dead_line_inf_credit;
    }
    
    public function actionStep5($history_id, $step_origin = null)
    {
        
        $history              = HistoryLog::find($history_id);
        $credit               = $history->historyCredit;
        $advisor              = $credit->creditAdvisor;
        
        $user                 = User::find($advisor->id);
        $role                 = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor         = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options         = self::menuOptionsStep5($history, $step_origin);

        $percent_form_step5   = self::percentFormStep5($history); //etapa 3
        $status_step5         = 'En espera';
        $status_step5         = ($percent_form_step5 >= 100) ? 'Concluido' : 'En curso';
        
        $view_dead_line1      = self::deadLineStep5($history);

        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();
        
        $subject1 = HistoryLog::$label_subject[29];

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' =>  $status_step5,
            'deadline' => $view_dead_line1,
            'advisor' => $name_advisor,
            'options' => $form_option,
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

    public function menuOptions($history, $step = 1, $step_origin = null)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=' . $step.'&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/template/action-document/controlDesk/' . $history->id . '?step=' . $step.'&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

            )
        );

        return $menu;
    }

    public function menuOptionsStep3($history, $step_origin = null)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=3_1'.'&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=3_2'.'&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/template/action-document/controlDesk/' . $history->id . '?step=3'.'&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

            )
        );

        return $menu;
    }
    
    public function menuOptionsStep4($history, $step_origin = null)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=4'.'&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
        );

        return $menu;
    }
    
    public function menuOptionsStep5($history, $step_origin = null)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=5'.'&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
        );

        return $menu;
    }

    public function menuOptionsStep($history, $type_lbl = 1)
    {
        $lbl_action = $type_lbl === 1 ? 'Lista de acciones' : 'Ver acción';
        $menu = array(
            'actionstep1' => array(
                [
                    'link' => '/panel/template/actions/controlDesk/' . $history->id . '/show?step=1',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep2' => array(
                [
                    'link' => '/panel/template/actions/controlDesk/' . $history->id . '/show?step=2',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep3' => array(
                [
                    'link' => '/panel/template/actions/controlDesk/' . $history->id . '/show?step=3',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep4' => array(
                [
                    'link' => '/panel/template/actions/controlDesk/' . $history->id . '/show?step=4',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep5' => array(
                [
                    'link' => '/panel/template/actions/controlDesk/' . $history->id . '/show?step=5',
                    'onclick' => '',
                    'name' => $lbl_action,
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
        //dd($history->id, $client);
        if ($client != null && $client->rfc != null) {
            $total_valid = $total_valid + 5;
        }

        if ($client != null && $client->nationality != null) {
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
    
    public function percentFormStep4($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;
        $total_valid = 0;

        if ($credit->kyc_done == 1 || $credit->kyc_done == 2) {
            $total_valid = 100;
        }
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }
    
    public function percentFormStep5($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;

        $total_valid = 0;
        if ($credit != null && $credit->financial_user_assigned != '' && $credit->commission != '') {
            $total_valid = 100;
        }
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    //* get all percentages of the shares
    public function getPercent($history, $show_current_show = false)
    {
        $credit     = $history->historyCredit;
        $data_actions = array(
            HistoryLog::KC_CONTROL_DESK_UPLOAD,
            HistoryLog::KC_CONTROL_DESK_FORM,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_2,
            HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_4,
            HistoryLog::KC_CONTROL_DESK_FORM_STEP_5,
        );
        
        $get_actions = HistoryLog::getByStatus($data_actions, $credit->id);
        $status_progress = 0;
        $current_show = 'Documentos cliente';

        foreach ($get_actions as $key => $get_action) {
            $status = $get_action->status_progress;
            $status_progress += $status != null ? $status : 0;
        }

        switch ($status_progress) {
            case 1:
                $current_show = 'Determinar crédito max';
                break;
            case 2:
                $current_show = 'Crédito deseado';
                break;
            case 3:
                $current_show = 'Documentos cliente';
                break;
            case 4:
                $current_show = 'Llenado de solicitud';
                break;
            case 5:
                $current_show = 'Entrevista';
                break;
            case 6:
                $current_show = 'Análisis KYC';
                break;
            case 7:
                $current_show = 'Contactar financiera';
                break;
            
            default:
                $current_show = 'Documentos cliente';
                break;
        }

        $percent =  (($status_progress) / 8) * 100;
        

        if ($show_current_show == true) {
            return $current_show;
        }
        
        return $percent;
    }

    public function getFile($template_config_id)
    {
        try {
            $config = self::configUpload()[$template_config_id];
        } catch (\Exception $th) {
            $config = self::uploadStep3()[$template_config_id];
        }

        return $config;
    }

    //*TODO: se deshabilito al ser opcional la caja de carga
    public function percentFile($id_rel, $step = null)
    {
        $model = File::MODEL['controlDesk'];
        $percent = 0;
        
        $total_valid = $step == null? 4 : 1;

        $count_file = 0;
        $percent_file = 0;
        $config_files = self::configUpload($step);

        foreach ($config_files as $key => $config_file) {
            $file = File::where([
                'model' => $model,
                'id_rel' => $id_rel,
                'template_config_id' => $key,
            ])
                ->first();
            if ($file != null) {
                $count_file = $count_file + 1;
                //$percent_file = $percent_file + 25;
            }
        }

        //$percent =  (100 / 100) * $percent_file;
        $percent = ($count_file / $total_valid) * 100;
        return $percent;
    }
    public function breadcrumb($history, $type = null)
    {
        return null;
    }
}
