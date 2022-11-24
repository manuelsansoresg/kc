<?php

namespace App\Strategies\Templates;

use App\Lib\Csendgrid;
use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\File;
use App\Models\Financial;
use App\Models\FinancialProduct;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Survey;
use App\Models\User;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use App\Strategies\Values\TemplateValues;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use stdClass;

class SwapStrategyTemplate implements TemplateInterface
{
    const HOUR_STEP_1   = 6;
    const HOUR_STEP_2   = 1;
    const HOUR_STEP_2_2 = 2;
    const HOUR_STEP_2_3 = 1;
    const HOUR_STEP_2_4 = 1;
    const HOUR_STEP_3   = 1;
    const HOUR_STEP_3_2   = 24;

    public function move($id)
    {
    }

    public function configUpload($set_step = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($set_step != null) {
            $step = $set_step;
        }
        if ($step == '1_2') {
            return self::uploadStep1_2();
        } elseif ($step == '2') {
            return self::uploadStep2();
        } elseif ($step == '3') {
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
                'type' => 'image/*, .pdf',
                'comment_date' => null
            ],
            2 => [
                'name' => 'Identificación oficial',
                'comment' => 'INE vigente',
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

    public function uploadStep1_2()
    {
        $elements = array(
            3 => [
                'name' => 'Solicitud de terminación anticipada de contrato',
                'comment' => null,
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
    
    public function uploadstep2()
    {
        $elements = array(
            3 => [
                'name' => 'Solicitud de terminación anticipada de contrato (Firmada)',
                'comment' => null,
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
    public function uploadStep3()
    {
        $elements = array(
            4 => [
                'name' => 'Cotización de liquidación',
                'comment' => null,
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
        } elseif ($step == '2') {
            return self::configFormstep2($id_rel, $history_id);
        } elseif ($step == '2_2') {
            return self::configFormstep2_2($id_rel, $history_id);
        } elseif ($step == '2_3') {
            return self::configFormstep2_3($id_rel, $history_id);
        } elseif ($step == '3') {
            return self::configFormstep3($id_rel, $history_id);
        } elseif ($step == '3_2') {
            return self::configFormstep3_2($id_rel, $history_id);
        }/*  elseif ($step == '4') {
            dd('test');
            $actionStrategy  = TemplateValues::STRATEGY['controlDesk'];
            return $actionStrategy->actionStep1($history_id);
        } */
    }

    public function configFormStep1($id_rel, $history_id)
    {
        $name_form    = 'frm-template_swap_step1';
        $type_form    = HistoryLog::KC_SWAP_FORM;
        $credit       = Credit::find($id_rel);
        $client_person = $credit->creditClientPerson;

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
                'title' => 'Nombres',
                'name_field' => 'client_person[name]',
                'id_field' => 'name',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'link' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            3 => [
                'title_section' => null,
                'title' => 'Primer apellido',
                'name_field' => 'client_person[last_name]',
                'id_field' => 'last_name',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'link' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            4 => [
                'title_section' => null,
                'title' => 'Segundo apellido',
                'name_field' => 'client_person[second_last_name]',
                'id_field' => 'second_last_name',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'link' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            5 => [
                'title_section' => null,
                'title' => 'Celular',
                'name_field' => 'client_person[cellphone]',
                'id_field' => 'cellphone',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'link' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            6 => [
                'title_section' => null,
                'title' => 'Email',
                'name_field' => 'client_person[email]',
                'id_field' => 'email',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'email',
                'link' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            7 => [
                'title_section' => null,
                'title' => 'RFC',
                'name_field' => 'client_person[rfc]',
                'id_field' => 'rfc',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'link' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            8 => [
                'title_section' => null,
                'title' => 'Número ID',
                'name_field' => 'credit[id_number]',
                'id_field' => 'id_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'link' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            9 => [
                'title_section' => null,
                'title' => 'Folio crédito actual',
                'name_field' => 'credit[current_credit_number]',
                'id_field' => 'current_credit_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'link' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null,
            ],
            
            
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }


    public function configFormstep2($id_rel, $history_id)
    {
        $credit = Credit::find($id_rel);
        $name_form = 'frm-template_swap_step2';
        $type_form = HistoryLog::KC_SWAP_FORM_STEP_2;

        $elements = array(
            1 => [
                'title_section' => null,
                'title' => 'URL firma',
                'name_field' => 'credit[url_sign]',
                'id_field' => 'url_sign',
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
    
    public function configFormstep2_2($id_rel, $history_id)
    {
        $credit = Credit::find($id_rel);
        $name_form = 'frm-template_swap_step2-2';
        $type_form = HistoryLog::KC_SWAP_FORM_STEP_2_2;
        $option_payment    = array(1 => 'Sí', 2 => 'No');

        $elements = array(
            1 => [
                'title_section' => null,
                'title' => 'Confirmación de firma',
                'name_field' => 'credit[signed]',
                'id_field' => 'signed',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $option_payment,
                'is_required' => true,
                'is_disabled' => null
            ],
            2 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'sectionstep',
                'id_field' => 'sectionstep',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => true,
                'options' => null,
                'is_required' => false,
                'is_disabled' => true,
                'value' => 1,
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    
    public function configFormstep2_3($id_rel, $history_id)
    {
        $credit = Credit::find($id_rel);
        $client_person = $credit->creditClientPerson;
        $name_form = 'frm-template_swap_step2-3';
        $type_form = HistoryLog::KC_SWAP_FORM_STEP_2_3;
        $client_name = $client_person->last_name.' '.$client_person->second_last_name.' '.$client_person->name;
        $financial_t = $credit->creditAppliedFinancial;
        $name_financial_t = $financial_t->email;
        $id_number = $credit->id_number;
        $rfc = $client_person->rfc;
        $current_credit_number = $credit->current_credit_number;
        $current_loan = $credit->current_loan;
        $name_button = 'Enviar';

        $elements = array(
            1 => [
                'title_section' => null,
                'title' => 'Email de financiera transferente',
                'name_field' => 'financial[email]',
                'id_field' => 'email',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'email',
                'is_option_array' => true,
                'options' => null,
                'is_required' => true,
                'is_disabled' => 'disabled',
                'value' => $name_financial_t
            ],
            2 => [
                'title_section' => null,
                'title' => 'Nombre del cliente',
                'name_field' => 'client_name',
                'id_field' => 'client_name',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => true,
                'options' => null,
                'is_required' => false,
                'is_disabled' => 'disabled',
                'value' => $client_name,
            ],
            3 => [
                'title_section' => null,
                'title' => 'Número ID',
                'name_field' => 'credit[id_number]',
                'id_field' => 'id_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => true,
                'options' => null,
                'is_required' => false,
                'is_disabled' => true,
                'value' => $id_number
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
                'is_option_array' => true,
                'options' => null,
                'is_required' => false,
                'is_disabled' => true,
                'value' => $rfc,
            ],
            5 => [
                'title_section' => null,
                'title' => 'Folio credito actual',
                'name_field' => 'credit[current_credit_number]',
                'id_field' => 'current_credit_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => true,
                'options' => null,
                'is_required' => false,
                'is_disabled' => true,
                'value' => $current_credit_number,
            ],
            6 => [
                'title_section' => null,
                'title' => 'Crédito actual',
                'name_field' => 'credit[current_loan]',
                'id_field' => 'current_loan',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => true,
                'options' => null,
                'is_required' => false,
                'is_disabled' => true,
                'value' => $current_loan,
            ],
            7 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'credit[termination_email_sent]',
                'id_field' => 'termination_email_sent',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => true,
                'options' => null,
                'is_required' => false,
                'is_disabled' => true,
                'value' => 1,
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'name_button' => $name_button, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    
    public function configFormstep3($id_rel, $history_id)
    {
        $credit = Credit::find($id_rel);
        $client_person = $credit->creditClientPerson;
        $name_form = 'frm-template_swap_step3';
        $type_form = HistoryLog::KC_SWAP_FORM_STEP_3;
        $client_name = $client_person->last_name.' '.$client_person->second_last_name.' '.$client_person->name;
        $id_number = $credit->id_number;
        $rfc = $client_person->rfc;
        $current_credit_number = $credit->current_credit_number;
        $current_loan = $credit->current_loan;
        $name_button = 'Enviar';

        $elements = array(
            1 => [
                'title_section' => null,
                'title' => 'Folio liquidación',
                'name_field' => 'credit[termination_number]',
                'id_field' => 'termination_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => true,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $credit->termination_number
            ],
            2 => [
                'title_section' => null,
                'title' => 'Banco',
                'name_field' => 'credit[termination_bank_name]',
                'id_field' => 'termination_bank_name',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => true,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $credit->termination_bank_name,
            ],
            3 => [
                'title_section' => null,
                'title' => 'Titular',
                'name_field' => 'credit[termination_bank_account_holder]',
                'id_field' => 'termination_bank_account_holder',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => true,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $credit->termination_bank_account_holder
            ],
            4 => [
                'title_section' => null,
                'title' => 'Cuenta',
                'name_field' => 'credit[termination_bank_account_number]',
                'id_field' => 'termination_bank_account_number',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => true,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null,
                'value' => $credit->termination_bank_account_number,
            ],
            5 => [
                'title_section' => null,
                'title' => 'CLABE',
                'name_field' => 'credit[termination_bank_clabe]',
                'id_field' => 'termination_bank_clabe',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => true,
                'options' => null,
                'is_required' => true,
                'is_disabled' => false,
                'value' => $credit->termination_bank_clabe,
            ],
            6 => [
                'title_section' => null,
                'title' => 'Referencia',
                'name_field' => 'credit[termination_bank_reference]',
                'id_field' => 'termination_bank_reference',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => true,
                'options' => null,
                'is_required' => true,
                'is_disabled' => false,
                'value' => $credit->termination_bank_reference,
            ],
            7 => [
                'title_section' => null,
                'title' => 'Comentario',
                'name_field' => 'credit[termination_note]',
                'id_field' => 'termination_note',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => true,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null,
                'value' => $credit->termination_note,
            ],
            8 => [
                'title_section' => null,
                'title' => 'Importe',
                'name_field' => 'credit[termination_amount]',
                'id_field' => 'termination_amount',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => true,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $credit->termination_amount,
            ],
            9 => [
                'title_section' => null,
                'title' => 'Fecha límite para liquidar',
                'name_field' => 'credit[termination_deadline]',
                'id_field' => 'termination_deadline',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'date',
                'is_option_array' => true,
                'options' => null,
                'is_required' => true,
                'is_disabled' => false,
                'value' => $credit->termination_deadline,
            ],
            
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'name_button' => $name_button, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    
    public function configFormstep3_2($id_rel, $history_id)
    {
        $credit = Credit::find($id_rel);
        $name_form    = 'frm-template_swap_step3';
        $type_form    = HistoryLog::KC_SWAP_FORM_STEP_3;
        $name_button  = 'Enviar';
        $show_btn     = false;

        $elements = array(
            1 => [
                'title_section' => null,
                'title' => 'Continuar',
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'href',
                'link' => null,
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'col' => 'col-12 col-md-4',
                'onclick' => 'swapCreditContinue('.$credit->id.')'
            ],
            2 => [
                'title_section' => null,
                'title' => 'Cancelar',
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'href',
                'link' => '/panel/credit/product/17?swap_cancel='.$credit->id,
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'col' => 'col-12 col-md-4',
            ],
            
            
        );
        $list = \View::make('panel.module.form', [ 'show_btn' => $show_btn, 'elements' => $elements, 'name_button' => $name_button, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    
    

    public function saveForm($request)
    {
        $id_rel   = $request->id_rel;
        $credit   = Credit::find($id_rel);
        $history  = HistoryLog::find($request->history_id);

        if ($request->credit) {
            $data_credit = $request->credit;
            if (isset($data_credit['changed_commission'])) {
                $data_credit['changed_commission'] = $data_credit['changed_commission'] * 100;
            }
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
            if (isset($data_credit['signed']) && $data_credit['signed'] == 1) {
                $credit   = Credit::find($id_rel);
                $send_grid_sender = new Csendgrid();
                $send_grid_sender = $send_grid_sender->createSender($credit->id);
            }
            if (isset($data_credit['termination_email_sent']) && $data_credit['termination_email_sent'] == 1) {
                $credit   = Credit::find($id_rel);
                $client         = $credit->creditClientPerson;
                $financial_t = $credit->creditAppliedFinancial;
                if ($credit->signed == 1) {
                    $send_grid_create_sender = new Csendgrid();
                    $sender = $send_grid_create_sender->createEmail($credit->id);
    
                    $send_grid = new Csendgrid('manuelsansoresg@gmail.com', 'creacion cuenta', ' ', $sender);
                    $send_grid->setTemplate('d-944f2768988a43dca2e0ad689954fd20');
                    $data_params = array(
                        'name' => $client->name,
                        'last_name' => $client->last_name,
                        'second_last_name' => $client->second_last_name,
                        'if_number' => $credit->id_number,
                        'client_rfc' => $client->rfc,
                        'current_credit_number' => $credit->current_credit_number,
                        'current_loan' => $credit->current_loan,
                     );
                    $send_grid->setParams($data_params);
                    $send_grid->send();
                }
            }
        }
    }

    public function listStep($history_id)
    {
        $history                    = HistoryLog::find($history_id);
        $credit                     = $history->historyCredit;

        $status_step2               = 'En espera';
        $status_step3               = 'En espera';
        $status_step4               = 'En espera';
        
        $percent_file               = self::percentFile($credit->id);
        $percent_file_1_2           = self::percentFile($credit->id, '1_2');
        $percent_form               = self::percentForm($history);
        
        $new_percent_file           = $percent_file == 100 ? 33 : $percent_file;
        $new_percent_file2          = $percent_file_1_2 == 100 ? 33 : $percent_file_1_2;
        $new_percent_form           = $percent_form == 100 ? 34 : $percent_form;
        
        $total_percent              = $new_percent_file + $new_percent_file2 + $new_percent_form;
        $status_step1               = ($total_percent >= 100) ? 'Concluido' : 'En curso';


        $percent_form_2             = self::percentFormStep2($history);
        $percent_form_2_2           = self::percentFormStep2_2($history);
        $percent_file_2_1           = self::percentFile($credit->id, '2');

        $new_percent_form_2         = $percent_form_2  == 100 ? 33 : $percent_form_2;
        $new_percent_form_2_2       = $percent_form_2_2  == 100 ? 33 : $percent_form_2_2;
        $new_percent_file_2_1       = $percent_file_2_1  == 100 ? 34 : $percent_file_2_1;
        $total_percent2             = $new_percent_form_2 + $new_percent_form_2_2 + $new_percent_file_2_1;

        $percent_file_step3         = self::percentFile($credit->id, '3');
        $percent_form_step3         = self::percentFormStep3($history);
        $percent_form_2_step3       = self::percentFormStep3_2($history);
        $new_percent_form_step3_1   = $percent_file_step3  == 100 ? 33 : $percent_file_step3;
        $new_percent_form_step3_2   = $percent_form_step3  == 100 ? 33 : $percent_form_step3;
        $new_percent_file_step3_3   = $percent_form_2_step3  == 100 ? 34 : $percent_form_2_step3;
        $total_percent_step3        = $new_percent_form_step3_1 + $new_percent_form_step3_2 + $new_percent_file_step3_3;

        $template_control_desk      = TemplateValues::STRATEGY['controlDesk'];
        $ck_percent_file            = (new $template_control_desk)->percentFile($credit->id);
        $ck_percent_form            = (new $template_control_desk)->percentForm($history); // etapa cuatro
        $ck_file                    = $ck_percent_file == 100 ? 50 : 0;
        $ck_form                    = $ck_percent_form == 100 ? 50 : 0;
        $kc_total_percent_step4     = $ck_file + $ck_form;

        $percent_form_step5         = (new $template_control_desk)->percentFormStep2($history); //etapa 5
        
        $percent_form_step6_1       = (new $template_control_desk)->percentFormStep3_1($history); //etapa 6
        $percent_form_step6_2       = (new $template_control_desk)->percentFormStep3_2($history); //etapa 6
        $new_percent_form_step6_1   = $percent_form_step6_1 == 100 ? 50 : $percent_form_step6_1;
        $new_percent_form_step6_2   = $percent_form_step6_2 == 100 ? 50 : $percent_form_step6_2;
        $kc_total_percent_step6     = $new_percent_form_step6_1 + $new_percent_form_step6_2;

        $percent_form_step8         = (new $template_control_desk)->percentFormStep5($history); //etapa 5
        
        $status_step2               = ($total_percent2 >= 100) ? 'Concluido' : 'En curso';
        $status_step3               = ($total_percent_step3 >= 100) ? 'Concluido' : 'En curso';
        $status_step4               = ($kc_total_percent_step4 >= 100) ? 'Concluido' : 'En curso';
        $status_step5               = ($percent_form_step5 >= 100) ? 'Concluido' : 'En curso';
        $status_step6               = ($kc_total_percent_step6 >= 100) ? 'Concluido' : 'En curso';
        $status_step8               = ($percent_form_step8 >= 100) ? 'Concluido' : 'En curso';

        $menu_options               = self::menuOptionsStep($history);


        $option_step1   = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();
        $option_step2   = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep2']])->render();
        $option_step3   = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep3']])->render();
        $option_step4   = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep4']])->render();
        $option_step5   = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep5']])->render();
        $option_step6   = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep6']])->render();
        $option_step7   = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep7']])->render();
        $option_step8   = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep8']])->render();
        
        $view_count_1   = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_count_2   = \View::make('panel.module.view_count', ['number' => 'Dos'])->render();
        $view_count_3   = \View::make('panel.module.view_count', ['number' => 'Tres'])->render();
        $view_count_4   = \View::make('panel.module.view_count', ['number' => 'Cuatro'])->render();
        $view_count_5   = \View::make('panel.module.view_count', ['number' => 'Cinco'])->render();
        $view_count_6   = \View::make('panel.module.view_count', ['number' => 'Seis'])->render();
        $view_count_7   = \View::make('panel.module.view_count', ['number' => 'Siete'])->render();
        $view_count_8   = \View::make('panel.module.view_count', ['number' => 'Ocho'])->render();
        
        $view_percent   = \View::make('panel.module.view_percent', ['percent' => $total_percent])->render();
        $view_percent2   = \View::make('panel.module.view_percent', ['percent' => $total_percent2])->render();
        $view_percent3   = \View::make('panel.module.view_percent', ['percent' => $total_percent_step3])->render();
        $view_percent4   = \View::make('panel.module.view_percent', ['percent' => $kc_total_percent_step4])->render();
        $view_percent5   = \View::make('panel.module.view_percent', ['percent' => $percent_form_step5])->render();
        $view_percent6   = \View::make('panel.module.view_percent', ['percent' => $kc_total_percent_step6])->render();
        $view_percent8   = \View::make('panel.module.view_percent', ['percent' => $percent_form_step8])->render();

        $data = array();
        $data[] = array(
            'name' => $view_count_1,
            'step' => 'Información de crédito actual',
            'status' => $status_step1,
            'progress' => $view_percent,
            'deadline' => '',
            'options' => $option_step1,
        );
        
        $data[] = array(
            'name' => $view_count_2,
            'step' => 'Firmar Solicitud de terminación anticipada',
            'status' => $status_step2,
            'progress' => $view_percent2,
            'deadline' => '',
            'options' => $option_step2,
        );
        
        $data[] = array(
            'name' => $view_count_3,
            'step' => 'Cotización de liquidación',
            'status' => $status_step3,
            'progress' => $view_percent3,
            'deadline' => '',
            'options' => $option_step3,
        );
        
        $data[] = array(
            'name' => $view_count_4,
            'step' => 'Viabilidad',
            'status' => $status_step4,
            'progress' => $view_percent4,
            'deadline' => '',
            'options' => $option_step4,
        );
        
        $data[] = array(
            'name' => $view_count_5,
            'step' => 'Características del crédito',
            'status' => $status_step5,
            'progress' => $view_percent5,
            'deadline' => '',
            'options' => $option_step5,
        );
        
        $data[] = array(
            'name' => $view_count_6,
            'step' => 'Captura de información',
            'status' => $status_step6,
            'progress' => $view_percent6,
            'deadline' => '',
            'options' => $option_step6,
        );
        
        $data[] = array(
            'name' => $view_count_7,
            'step' => 'KYC',
            'status' => 'Opcional',
            'progress' => 'N/A',
            'deadline' => '',
            'options' => $option_step7,
        );
        $data[] = array(
            'name' => $view_count_8,
            'step' => 'Asignar usuario financiera',
            'status' => $status_step8,
            'progress' => $view_percent8,
            'deadline' => '',
            'options' => $option_step8,
        );
       
        return $data;
    }

    public function listAction($history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == 2) {
            return self::listActionStep2($history_id);
        } elseif ($step == 3) {
            return self::listActionStep3($history_id);
        } elseif ($step == 4) {
            //*execute function in template controldeskstrategy
            $actionStrategy  = TemplateValues::STRATEGY['controlDesk'];
            $list       = (new $actionStrategy)->actionStep1($history_id, 1);
            return $list;
        } elseif ($step == 5) {
            //*execute function in template controldeskstrategy
            $actionStrategy  = TemplateValues::STRATEGY['controlDesk'];
            $list       = (new $actionStrategy)->actionStep2($history_id, 1);
            return $list;
        } elseif ($step == 6) {
            //*execute function in template controldeskstrategy
            $actionStrategy  = TemplateValues::STRATEGY['controlDesk'];
            $list       = (new $actionStrategy)->actionStep3($history_id, 1);
            return $list;
        } elseif ($step == 7) {
            //*execute function in template controldeskstrategy
            $actionStrategy  = TemplateValues::STRATEGY['controlDesk'];
            $list       = (new $actionStrategy)->actionStep4($history_id, 1);
            return $list;
        } elseif ($step == 8) {
            //*execute function in template controldeskstrategy
            $actionStrategy  = TemplateValues::STRATEGY['controlDesk'];
            $list       = (new $actionStrategy)->actionStep5($history_id, 1);
            return $list;
        }
        return self::listActionStep1($history_id);
    }

    
    
    public function deadLineStep1($history, $show_max_hour = false)
    {
        $credit             = $history->historyCredit;
        $color_inf_credit   = 'success';
        $percent_file       = self::percentFile($credit->id);



        $max_hour                     = self::HOUR_STEP_1;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_file, $color_inf_credit, $show_max_hour);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        
        if ($show_max_hour == true) {
            return $data_deadline['lbl_hour'];
        }
        return $view_dead_line_inf_credit;
    }

    public function deadLineStep1_2($history, $show_max_hour = false)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_file                 = self::percentFile($credit->id, '1_2');
        $max_hour                     = self::HOUR_STEP_1;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_file, $color_inf_credit, $show_max_hour);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        
        if ($show_max_hour == true) {
            return $data_deadline['lbl_hour'];
        }
        return $view_dead_line_inf_credit;
    }
    
    public function deadLineStep1_3($history, $show_max_hour = false)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_file                 = self::percentForm($history);
        $max_hour                     = self::HOUR_STEP_1;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_file, $color_inf_credit, $show_max_hour);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        
        if ($show_max_hour == true) {
            return $data_deadline['lbl_hour'];
        }
        return $view_dead_line_inf_credit;
    }

    public function listActionStep1($history_id)
    {
        $history                = HistoryLog::find($history_id);
        $credit                 = $history->historyCredit;
        $advisor                = $credit->creditAdvisor;
        $status_file            = 'En espera';

        $percent_file       = self::percentFile($credit->id);
        $percent_form       = self::percentForm($history);
        $percent_file_2     = self::percentFile($credit->id, '1_2');
        

        $user                   = User::find($advisor->id);
        $role                   = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor           = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options           = self::menuOptions($history, 1);

        $view_dead_line_step1   = self::deadLineStep1($history);
        $view_dead_line_step2   = self::deadLineStep1_3($history);
        $view_dead_line_step3   = self::deadLineStep1_2($history);

        $option2 = null;
        $option3 = null;

        $status_file = ($percent_file >= 100) ? 'Concluido' : 'En curso';
        $status_file_2 = ($percent_file_2 >= 100) ? 'Concluido' : 'En curso';
        $status_form = ($percent_form >= 100) ? 'Concluido' : 'En curso';

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $option1  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
        if ($percent_file == 100) {
            $option2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        }
        if ($percent_form == 100) {
            $option3  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file2']])->render();
        }
       
        $subject1 = HistoryLog::$label_subject[38];
        $subject2 = HistoryLog::$label_subject[39];
        $subject3 = HistoryLog::$label_subject[46];

        $data = array();
        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject1,
            'status' => $status_file,
            'deadline' => $view_dead_line_step1,
            'advisor' => $name_advisor,
            'options' => $option1,
        );
        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject2,
            'status' => $status_form,
            'deadline' => $view_dead_line_step2,
            'advisor' => $name_advisor,
            'options' => $option2,
        );
        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject3,
            'status' => $status_file_2,
            'deadline' => $view_dead_line_step3,
            'advisor' => $name_advisor,
            'options' => $option3,
        );
        return $data;
    }
    
    public function listActionStep2($history_id)
    {
        $history                = HistoryLog::find($history_id);
        $credit                 = $history->historyCredit;
        $advisor                = $credit->creditAdvisor;
        $status_file            = 'En espera';

        $percent_form           = self::percentFormStep2($history);
        $percent_form_2         = self::percentFormStep2_2($history);
        $percent_file_2         = self::percentFile($credit->id, '2');
        

        $user                   = User::find($advisor->id);
        $role                   = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor           = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options           = self::menuOptionsStep2($history, 2);

        $view_dead_line_step1   = self::deadLineFormStep2($history);
        $view_dead_line_step2   = self::deadLineFormStep2_2($history);
        $view_dead_line_step3   = self::deadLineFileStep2_3($history);

        $option2                = null;
        $option3                = null;
        $option4                = null;
        
        $status_form            = ($percent_form >= 100) ? 'Concluido' : 'En curso';
        $status_form_2          = ($percent_form_2 >= 100) ? 'Concluido' : 'En curso';
        $status_file            = ($percent_file_2 >= 100) ? 'Concluido' : 'En curso';

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $option1  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        if ($percent_form == 100) {
            $option2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form2']])->render();
        }
        if ($percent_form_2 == 100) {
            $option3  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
        }
        if ($percent_file_2 == 100) {
            $option4  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form3']])->render();
        }
       

        $data = array();

        $subject1 = HistoryLog::$label_subject[40];
        $subject2 = HistoryLog::$label_subject[41];
        $subject3 = HistoryLog::$label_subject[42];
        $subject4 = HistoryLog::$label_subject[43];

        $data[] = array(
            'name' => 'Firma',
            'subject' => $subject1,
            'description' => 'Preparar documento',
            'status' => $status_form,
            'deadline' => $view_dead_line_step1,
            'advisor' => $name_advisor,
            'options' => $option1,
        );
        $data[] = array(
            'name' => 'Firma',
            'subject' => $subject2,
            'description' => 'Solicitar firma',
            'status' => $status_form_2,
            'deadline' => $view_dead_line_step2,
            'advisor' => $name_advisor,
            'options' => $option2,
        );
        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject3,
            'description' => 'Documento firmado',
            'status' => $status_file,
            'deadline' => $view_dead_line_step3,
            'advisor' => $name_advisor,
            'options' => $option3,
        );
        
        $data[] = array(
            'name' => 'Email',
            'subject' => $subject4,
            'description' => 'Enviar solicitud',
            'status' => $status_file,
            'deadline' => $view_dead_line_step3,
            'advisor' => $name_advisor,
            'options' => $option4,
        );
        return $data;
    }
    
    public function listActionStep3($history_id)
    {
        $history                = HistoryLog::find($history_id);
        $credit                 = $history->historyCredit;
        $advisor                = $credit->creditAdvisor;
        $status_file            = 'En espera';

        $percent_file         = self::percentFile($credit->id, '3');

        $percent_form           = self::percentFormStep3($history);
        $percent_form_2         = self::percentFormStep3_2($history);
        

        $user                   = User::find($advisor->id);
        $role                   = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor           = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options           = self::menuOptionsStep3($history, 3);

        $view_dead_line_step1   = self::deadLineFormStep3($history);
        $view_dead_line_step2   = self::deadLineFormStep3_2($history);
        $view_dead_line_step3   = self::deadLineFormStep3_3($history);

        $option2                = null;
        $option3                = null;
        $option4                = null;
        
        $status_file            = ($percent_file >= 100) ? 'Concluido' : 'En curso';
        $status_form            = ($percent_form >= 100) ? 'Concluido' : 'En curso';
        $status_form_2          = ($percent_form_2 >= 100) ? 'Concluido' : 'En curso';

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $option1  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
        if ($percent_file == 100) {
            $option2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        }
        if ($percent_form == 100) {
            $option3  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form2']])->render();
        }
       
       

        $data = array();

        $subject1 = HistoryLog::$label_subject[44];
        $subject2 = HistoryLog::$label_subject[45];
        $subject3 = HistoryLog::$label_subject[47];

        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject1,
            'description' => 'Preparar documento',
            'status' => $status_file,
            'deadline' => $view_dead_line_step1,
            'advisor' => $name_advisor,
            'options' => $option1,
        );
        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject2,
            'description' => 'Solicitar firma',
            'status' => $status_form,
            'deadline' => $view_dead_line_step2,
            'advisor' => $name_advisor,
            'options' => $option2,
        );
        $data[] = array(
            'name' => 'Decisión',
            'subject' => $subject3,
            'description' => 'Documento firmado',
            'status' => $status_form_2,
            'deadline' => $view_dead_line_step3,
            'advisor' => $name_advisor,
            'options' => $option3,
        );
        
        
        return $data;
    }

    public function deadLineFormStep2($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFormStep2($history);
        
        $max_hour                     = self::HOUR_STEP_2;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function deadLineFormStep2_2($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFormStep2_2($history);
        
        $max_hour                     = self::HOUR_STEP_2_2;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }
    
    public function deadLineFileStep2_3($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFile($credit->id);
        
        $max_hour                     = self::HOUR_STEP_2_3;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }
    
    public function deadLineFormStep3($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFile($credit->id);
        
        $max_hour                     = self::HOUR_STEP_3;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }
    
    public function deadLineFormStep3_2($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFormStep3($history);
        
        $max_hour                     = self::HOUR_STEP_3_2;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }
    
    public function deadLineFormStep3_3($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFormStep3($history);
        
        $max_hour                     = self::HOUR_STEP_3_2;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }
   
    public function deadLineFileStep2_4($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFormStep2_3($credit->id);
        
        $max_hour                     = self::HOUR_STEP_2_3;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function actionStep2($history_id)
    {

        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_form   = self::percentFile($credit->id);
        
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptions($history, 2);
        
        $view_dead_line_step2  = self::deadLineStep2($history);

        $view_dead_line_inf_credit  = 'N/A';
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();

        $data[] = array(
            'name' => 'Carga',
            'status' => $status_form,
            'deadline' => $view_dead_line_step2,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );
        
        $data[] = array(
            'name' => 'Formulario',
            'status' =>  'Opcional',
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );

        return $data;
    }

    

    public function menuPrincipalOptions($history)
    {
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $menu = array(
            'options' => array(
                [
                    'link' => '/panel/client/'.$client->id,
                    'onclick' => '',
                    'name' => 'Ver perfil cliente',
                    'icon' => 'icon ni ni-user-fill'
                ],
                [
                    'link' => '/panel/credit/'.$credit->id,
                    'onclick' => '',
                    'name' => 'Ver perfil crédito',
                    'icon' => 'icon ni ni-report-profit'
                ],
                [
                    'link' => '/panel/template/steps/swap/'.$history->id.'/show',
                    'onclick' => '',
                    'name' => 'Ver etapas',
                    'icon' => 'icon ni ni-list-thumb-fill'
                ]
            ),
        );

        return $menu;
    }
    
    public function menuOptions($history, $step = 1)
    {
        $menu = array(
            'file' => array(
                [
                    'link' => '/panel/template/action-document/swap/' . $history->id . '?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

                ),
            'form' => array(
                [
                    'link' => '/panel/action-form/swap/' . $history->id . '/form?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file2' => array(
                [
                    'link' => '/panel/template/action-document/swap/' . $history->id . '?step=1_2',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

                ),
        );

        return $menu;
    }

    public function menuOptionsStep2($history, $step = 2)
    {
        $menu = array(
            'file' => array(
                [
                    'link' => '/panel/template/action-document/swap/' . $history->id . '?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

                ),
            'form' => array(
                [
                    'link' => '/panel/action-form/swap/' . $history->id . '/form?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/action-form/swap/' . $history->id . '/form?step=2_2',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

                ),
            'form3' => array(
                [
                    'link' => '/panel/action-form/swap/' . $history->id . '/form?step=2_3',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

                ),
        );

        return $menu;
    }
    
    public function menuOptionsStep3($history, $step = 2)
    {
        $menu = array(
            'file' => array(
                [
                    'link' => '/panel/template/action-document/swap/' . $history->id . '?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

                ),
            'form' => array(
                [
                    'link' => '/panel/action-form/swap/' . $history->id . '/form?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/action-form/swap/' . $history->id . '/form?step=3_2',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

                ),
        );

        return $menu;
    }
    
    public function menuOptionsStep4($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=4',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
        );

        return $menu;
    }
    
    public function menuOptionsStep5($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=5',
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
                    'link' => '/panel/template/actions/swap/' . $history->id . '/show?step=1',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep2' => array(
                [
                    'link' => '/panel/template/actions/swap/' . $history->id . '/show?step=2',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep3' => array(
                [
                    'link' => '/panel/template/actions/swap/' . $history->id . '/show?step=3',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            //*step control desk clone    
            'actionstep4' => array(
                [
                    'link' => '/panel/template/actions/swap/' . $history->id . '/show?step=4',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep5' => array(
                [
                    'link' => '/panel/template/actions/swap/' . $history->id . '/show?step=5',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep6' => array(
                [
                    'link' => '/panel/template/actions/swap/' . $history->id . '/show?step=6',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep7' => array(
                [
                    'link' => '/panel/template/actions/swap/' . $history->id . '/show?step=7',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep8' => array(
                [
                    'link' => '/panel/template/actions/swap/' . $history->id . '/show?step=8',
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
        if ($client != null && $client->name != '') {
            $total_valid = $total_valid + 14;
        }

        if ($client != null && $client->last_name != null) {
            $total_valid = $total_valid + 14;
        }

        if ($client != null && $client->second_last_name != null) {
            $total_valid = $total_valid + 14;
        }

        if ($client != null && $client->cellphone != null) {
            $total_valid = $total_valid + 14;
        }

        if ($client != null && $client->email != null) {
            $total_valid = $total_valid + 14;
        }
       
        if ($client != null && $client->rfc != null) {
            $total_valid = $total_valid + 14;
        }
        
        if ($credit != null && $credit->id_number != null) {
            $total_valid = $total_valid + 16;
        }
        
     
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    public function percentUploadStep2($history)
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

    public function percentFormStep2($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;

        $total_valid = 0;
        
        if ($credit != null && $credit->url_sign != null) {
            $total_valid = 100;
        }

        
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }
    
    public function percentFormStep2_2($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;

        $total_valid = 0;
        
        if ($credit != null && $credit->signed != null) {
            $total_valid = 100;
        }

        
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }
    
    public function percentFormStep2_3($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;

        $total_valid = 0;
        
        if ($credit != null && $credit->termination_email_sent != null) {
            $total_valid = 100;
        }

        
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    public function percentFormStep3($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $total_valid = 0;
        
        if ($credit != null && $credit->termination_number != null) {
            $total_valid = 14;
        }
        if ($credit != null && $credit->termination_bank_name != null) {
            $total_valid = $total_valid + 14;
        }
        if ($credit != null && $credit->termination_bank_account_holder != null) {
            $total_valid = $total_valid + 14;
        }
        if ($credit != null && $credit->termination_bank_clabe != null) {
            $total_valid = $total_valid + 14;
        }
        if ($credit != null && $credit->termination_bank_reference != null) {
            $total_valid = $total_valid + 14;
        }
        if ($credit != null && $credit->termination_amount != null) {
            $total_valid = $total_valid + 14;
        }
        if ($credit != null && $credit->termination_deadline != null) {
            $total_valid = $total_valid + 16;
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
        
        if ($credit != null && $credit->termination_number != null) {
            $total_valid = 14;
        }
        if ($credit != null && $credit->termination_bank_name != null) {
            $total_valid = 14;
        }
        if ($credit != null && $credit->termination_bank_account_holder != null) {
            $total_valid = 14;
        }
        if ($credit != null && $credit->termination_bank_clabe != null) {
            $total_valid = 14;
        }
        if ($credit != null && $credit->termination_bank_reference != null) {
            $total_valid = 14;
        }
        if ($credit != null && $credit->termination_amount != null) {
            $total_valid = 14;
        }
        if ($credit != null && $credit->termination_deadline != null) {
            $total_valid = 16;
        }

        
        $percent =  (100 / 100) * $total_valid;
        return 100;
    }

    

    //* get all percentages of the shares
    public function getPercent($history, $show_current_show = false)
    {
        $credit       = $history->historyCredit;
        
        $current_show = 'Información de crédito actual';

        $credit             = $history->historyCredit;
        $percent_file       = self::percentFile($credit->id);
        $percent_file_2     = self::percentFile($credit->id, '1_2');
        $percent_form       = self::percentForm($history);

        $new_percent_file = $percent_file == 100 ? 33 : $percent_file;
        $new_percent_file2 = $percent_file_2 == 100 ? 33 : $percent_file_2;
        $new_percent_form = $percent_form == 100 ? 34 : $percent_form;
        
        $total_percent = $new_percent_file + $new_percent_file2 + $new_percent_form;

        $percent      = (100 / 100) * $total_percent;
        
        if ($show_current_show == true) {
            return $current_show;
        }
        return $percent;
    }

    public function getFile($template_config_id)
    {
        $config = self::configUpload()[$template_config_id];
        return $config;
    }

    //*TODO: se deshabilito al ser opcional la caja de carga
    public function percentFile($id_rel, $step = null)
    {
        $model = File::MODEL['swap'];
        $percent = 0;
        $total_valid = 1;
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
            if ($file != null && $config_file['is_required'] == true) {
                $count_file = $count_file + 1;
                $percent_file = $percent_file + 100;
            }
        }

        $percent =  (100 / 100) * $percent_file;
        return $percent;
    }

    public function optionBreadcumbStep($history)
    {
        $breadcumbs = array(
            0 => array(
             'title' => 'Inicio',
             'link' => '/panel/home',
             'active' => null
            ),
            1 => array(
             'title' => 'KC - Aftermarket',
             'link' => '/panel/kc-aftermarket',
             'active' => null
            ),
            2 => array(
             'title' => 'etapas',
             'link' => null,
             'active' => true
            ),
         );
         return $breadcumbs;
    }
    
    public function optionBreadcumblistAction($history)
    {
        $breadcumbs = array(
            0 => array(
             'title' => 'Inicio',
             'link' => '/panel/home',
             'active' => null
            ),
            1 => array(
             'title' => 'KC - Swap',
             'link' => '/panel/swap',
             'active' => null
            ),
            2 => array(
                'title' => 'etapas',
                'link' => '/panel/template/steps/swap/'.$history->id.'/show',
                'active' => true
            ),
            3 => array(
                'title' => 'acciones',
                'link' => null,
                'active' => true
               ),
         );
         return $breadcumbs;
    }

    public function optionSteps($history)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;

        $breadcumbs = array(
            0 => array(
             'title' => 'Inicio',
             'link' => '/panel/home',
             'active' => null
            ),
            1 => array(
             'title' => 'KC - Swap',
             'link' => '/panel/swap',
             'active' => null
            ),
            2 => array(
             'title' => 'etapas',
             'link' => '/panel/template/steps/swap/'.$history->id.'/show',
             'active' => null
            ),
            3 => array(
             'title' => 'acciones',
             'link' => '/panel/template/actions/swap/'.$history->id.'/show?step='.$step,
             'active' => null
            ),
            4 => array(
             'title' => 'entrega',
             'link' => null,
             'active' => true
            ),
         );
         return $breadcumbs;
    }

    public function breadcrumb($history, $type = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == null) {
            $breadcumbs = self::optionBreadcumbStep($history);
        }
        if ($type == 2) {
            $breadcumbs = self::optionBreadcumblistAction($history);
        } else {
            if ($step == 1 || $step == 2 || $step == 3) {
                $breadcumbs = self::optionSteps($history);
            }
        }

        
        
        $view_breadcumb    = \View::make('panel.module.breadcumb', ['breadcumbs' => $breadcumbs])->render();
        return $view_breadcumb;
    }
}
