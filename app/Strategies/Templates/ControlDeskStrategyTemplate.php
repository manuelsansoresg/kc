<?php

namespace App\Strategies\Templates;

use App\Lib\CalculadoraCredito;
use Illuminate\Support\Str;
use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\CreditPayOff;
use App\Models\CreditsControlDesk;
use App\Models\File;
use App\Models\Financial;
use App\Models\FinancialAgreement;
use App\Models\FinancialProduct;
use App\Models\FpTerm;
use App\Models\HistoryLog;
use App\Models\Investor;
use App\Models\InvestorsCredit;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class ControlDeskStrategyTemplate implements TemplateInterface
{
    const HOUR_STEP_1  = 6;
    const HOUR_STEP_2  = 3;
    const HOUR_STEP_3  = 6;
    const HOUR_STEP_4  = 2;
    const HOUR_STEP_5  = 2;
    const HOUR_STEP_5_2 = 2;
    const HOUR_STEP_5_3 = 2;

    public function move($id)
    {
    }

    public function configUpload($set_step = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
       
        if ($set_step != null) {
            $step = $set_step;
        }

        if ($step == '3_5') {
            return self::uploadstep3_5();
        }
        if ($step == 3) {
            return self::uploadStep3();
        }
        
       
        
        if ($step == '5_3') {
            return self::uploadStep5();
        }

        
        
        return self::uploadStep1();
    }

    public function setURLDocument()
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == '5_3') {
            return '/panel/kc-delivery';
        }
        return null;
    }

    public function uploadStep1()
    {
        $elements = array(
            1 => [
                'name' => 'Identificación oficial',
                'comment' => 'INE vigente',
                'is_required' => false,
                'is_date' => false,
                'max_size' => 2, //* size in MB
                'max_file' => 2,
                'type' => 'image/*',
                'comment_date' => null
            ],

            2 => [
                'name' => 'Recibo de nómina',
                'comment' => 'Más reciente',
                'is_required' => false,
                'is_date' => true,
                'max_size' => 2,
                'max_file' => 2,
                'type' => 'image/*',
                'comment_date' => 'Establece la fecha del comprobante más antigüo'
            ],
            3 => [
                'name' => 'Comprobante de domicilio',
                'comment' => 'Más reciente',
                'is_required' => false,
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
                'type' => 'image/*, .pdf',
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

    public function uploadstep5()
    {
        $elements = array(
            6 => [
                'name' => 'Contrato firmado',
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
    
    public function uploadstep3_5()
    {
        $elements = array(
           1 => [
                'name' => 'CEP',
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
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $task = null;

        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $task) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }
        
        if ($task=== null && $step === 1) {
            return self::configFormStep1Task1($id_rel, $history_id);
        } elseif ($task=== null && $step === 2) {
            return self::configFormStep1Task2($id_rel, $history_id);
        } elseif ($task=== null && $step >= 3 ) {
            return self::configDinamicFormStep1($id_rel, $history_id, $step);
        }elseif($step === 2 && $task === 1){
            return self::configFormStep2Task1($id_rel, $history_id);
        }elseif($step === 2 && $task === 2){
            return self::configFormStep2Task2($id_rel, $history_id);
        }elseif($step === 2 && $task === 3){
            return self::configFormStep2Task3($id_rel, $history_id);
        }elseif($step === 2 && $task >  3){ //tareas dinamicas de la etapa 2
            return self::configDinamicFormStep2($id_rel, $history_id, $step);
        }elseif($step === 3){ 
            return self::configDinamicFormStep3($id_rel, $history_id, $step);
        }elseif($step === 4 && $task == 1){ 
            return self::configFormStep4Task1($id_rel, $history_id, $step);
        }elseif($step === 4 && $task == 2){ 
            return self::configFormStep4Task2($id_rel, $history_id, $step);
        } 
    }

   

    public function configFormStep1Task1($id_rel, $history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : '1';
        $name_form = 'frm-template_control_desk_step1';
        $type_form = HistoryLog::KC_CONTROL_DESK_TASK1_STEP1;
        $elements = array(
            
            1 => [
                'title_section' => null,
                'title' => '*Anverso INE',
                'subtitle' => 'Adjunta la parte delantera de la INE',
                'name_field' => 'Anverso INE',
                'id_field' => '1',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'dropzone',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            
            2 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-model',
                'id_field' => 'action-model',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-12'
            ],
            
            3 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-id_rel',
                'id_field' => 'action-id_rel',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => $id_rel,
                'col' => 'col-12'
            ],
           
            4 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=3&step_origin=',
                'col' => 'col-12'
            ],
            6=> [
                'title_section' => null,
                'title' => null,
                'name_field' => 'step',
                'id_field' => 'step',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 1,
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }


    public function configFormStep1Task2($id_rel, $history_id)
    {
        $credit       = Credit::find($id_rel);
        $name_form    = 'frm-template_control_desk_step2';
        $type_form    = HistoryLog::KC_CONTROL_DESK_TASK2_STEP1;
        $financial    = Financial::select('id', 'commercial_name as name')->get();
        $product      = FinancialProduct::getProductByFinancial($credit->applied_financial_product);
        /* $get_financials = FinancialAgreement::where('agreement_id', $credit->agreement_id)->get();
        $financials = array();
        if ($get_financials != null) {
            foreach ($get_financials as $financial) {
                $getProduct = FinancialProduct::getbyIdFirst($financial->product_id);
                $financials[$getProduct->id]= $getProduct->commercial_name.' - '.$getProduct->name;
            }
        } */

        $loan_type    = config('enums.loan_type');
        $sign_type    = config('enums.sign_type');
        $periodicity  = config('enums.periodicity');
        $step         = isset($_GET['step']) ? $_GET['step'] : '2';

        $elements = array(
            1 => [
                'title_section' => null,
                'title' => '*Reverso INE',
                'subtitle' => 'Adjunta la parte delantera de la INE',
                'name_field' => 'Reverso INE',
                'id_field' => '2',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'dropzone',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            
            2 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-model',
                'id_field' => 'action-model',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-12'
            ],
            
            3 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-id_rel',
                'id_field' => 'action-id_rel',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => $id_rel,
                'col' => 'col-12'
            ],
           
            4 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=2&step_origin=',
                'col' => 'col-12'
            ],
            6=> [
                'title_section' => null,
                'title' => null,
                'name_field' => 'step',
                'id_field' => 'step',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 1,
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    //configuracion dinamica del formulario
    public function configDinamicFormStep1($id_rel, $history_id, $step)
    {
        $credit       = Credit::find($id_rel);
        $name_form    = 'frm-template_control_desk_step2';
        $type_form    = HistoryLog::KC_CONTROL_DESK_TASK3_STEP1;
        $financial    = Financial::select('id', 'commercial_name as name')->get();
        $product      = FinancialProduct::getProductByFinancial($credit->applied_financial_product);
      
        $taks = self::ElementsTaskStep1($history_id, null);
        $templateId = $step -1;
        $task = $taks[$templateId];
        

        $loan_type    = config('enums.loan_type');
        $sign_type    = config('enums.sign_type');
        $periodicity  = config('enums.periodicity');
        $step         = isset($_GET['step']) ? $_GET['step'] : '2';
        
        $stepRedirect = $step +1;
        $elements = array(
            1 => [
                'title_section' => null,
                'title' => '*'.$task['subject'],
                'subtitle' => $task['helpText'],
                'name_field' => $task['subject'],
                'id_field' => $step,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'dropzone',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            
            2 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-model',
                'id_field' => 'action-model',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-12'
            ],
            
            3 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-id_rel',
                'id_field' => 'action-id_rel',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => $id_rel,
                'col' => 'col-12'
            ],
           
            4 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step='.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
            6=> [
                'title_section' => null,
                'title' => null,
                'name_field' => 'step',
                'id_field' => 'step',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 1,
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    
    public function configDinamicFormStep2($id_rel, $history_id, $step)
    {
        $credit       = Credit::find($id_rel);
        $name_form    = 'frm-template_control_desk_dynamic_step2';
        $type_form    = HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2;
      
        
        

        $loan_type    = config('enums.loan_type');
        $sign_type    = config('enums.sign_type');
        $periodicity  = config('enums.periodicity');
        
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $taskId = null;

        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $taskId) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }

        $taks = self::ElementsTaskStep2($history_id, null);
        $templateId = $taskId -1;
        $task = $taks[$templateId];

        $payOff = CreditPayOff::find($task['id']);
        

        $stepRedirect = $taskId +1;
        $elements = array(
            1 => [
                'title_section' => '',
                'title' => 'Fecha límite de pago',
                'subtitle' => 'Captura la fecha límite para el pago',
                'name_field' => 'pay_off[deadline_date]',
                'id_field' => 'deadline_date',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'date',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $payOff != null ? $payOff->deadline_date : null
            ],
            
            2 => [
                'title_section' => null,
                'title' => '*Importe',
                'subtitle' => 'Captura el importe que se debe pagar',
                'name_field' => 'pay_off[ammount]',
                'id_field' => 'ammount',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-6',
                'value' => $payOff != null ? $payOff->ammount : null
            ],
            
            3 => [
                'title_section' => null,
                'title' => '*CLABE',
                'subtitle' => 'Captura la cable',
                'name_field' => 'pay_off[bank_clabe]',
                'id_field' => 'bank_clabe',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'col' => 'col-6',
                'value' => $payOff != null ? $payOff->bank_clabe : null
            ],
           
            4 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=2_'.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    public function configDinamicFormStep3($id_rel, $history_id, $step)
    {
        $credit       = Credit::find($id_rel);
        $client = $credit->creditClientPerson;
        $product = FinancialProduct::find($credit->applied_financial_product);
        

        $loan_type    = config('enums.loan_type');
        $sign_type    = config('enums.sign_type');
        $periodicity  = config('enums.periodicity');
        
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $taskId = null;
        

        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $taskId) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }
        
        $taks = self::ElementsTaskStep3($history_id, null);
        
        if ($product->type_product_id != 3) {
            $templateId = $taskId -1;
        } else {
            $templateId = 0;
        }
        
        
        $task = $taks[$templateId];
        $type_form    = $task['idForm'];
        
        $name_form    = null;
        $payOff = CreditPayOff::find($task['id']);
        
        
        switch ($taskId) {
            case 1:
                $elements = self::configFormStep3Task1($id_rel, $history_id, $task, $taskId);
                
                $name_form    = 'frm-template_control_desk_step3_task';
                break;
            case 2:
                $elements = self::configFormStep3Task2($id_rel, $history_id, $task, $taskId);
                $name_form    = 'frm-template_control_desk_step3_task';
                break;
            case 3:
                $elements = self::configFormStep3Task3($id_rel, $history_id, $task, $taskId);
                $name_form    = 'frm-template_control_desk_step3_task3';
                break;
            case 4:
                $elements = self::configFormStep3Task4($id_rel, $history_id, $task, $taskId);
                $name_form    = 'frm-template_control_desk_step3_task4';
                break;
            case 5:
                $elements = self::configFormStep3Task5($id_rel, $history_id, $task, $taskId);
                $name_form    = 'frm-template_control_desk_step3_task5';
                break;
            
            default:
                $elements = self::configFormDynamicStep3($id_rel, $history_id, $task, $taskId);
                $name_form    = 'frm-template_control_desk_dynamic_step3';
                break;
        }
        
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
        
    }

    public function configFormStep3Task1($id_rel, $history_id, $task, $taskId)
    {
        $credit       = Credit::find($id_rel);
        $client = $credit->creditClientPerson;
        $stepRedirect = $taskId +1;
        $contentInfo = \View::make('panel.client.infoClient', ['client' => $client, 'taskId' => $taskId, 'credit' => $credit])->render();

        $elements = array(
            1 => [
                'title_section' => '',
                'title' => null,
                'subtitle' => null,
                
                'id_field' => 'deadline_date',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'col' => 'col-12',
                'type' => 'div',
                'content' => $contentInfo,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            
            2 => [
                'title_section' => null,
                'title' => '*ID Válida',
                'subtitle' => ' Indica si la ID pertenece al cliente y está vigente',
                'name_field' => 'pay_off[ammount]',
                'id_field' => 'ammount',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'radio',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-6',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'name' => 'Valida',
                        'name_field' =>  $task['nameField'],
                        'class' => null,
                        'onclick' => null,
                        'value' => 1,
                        'is_required' => true,
                    ),
                    1 => array(
                        'link' => null,
                        'name' => 'Invalida',
                        'name_field' => $task['nameField'],
                        'class' => null,
                        'onclick' => null,
                        'value' => 0,
                        'is_required' => true,
                        
                    ),
                )
            ],
           
            3 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            4 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=3_'.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
        );
        return $elements;
    }
    
    public function configFormStep3Task2($id_rel, $history_id, $task, $taskId)
    {
        $credit       = Credit::find($id_rel);
        $client = $credit->creditClientPerson;
        $stepRedirect = $taskId +1;
        

        $step = null;
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;
        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $taskId) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }
        
        $contentInfo = \View::make('panel.client.infoClient', ['client' => $client, 'taskId' => $taskId, 'credit' => $credit, 'step' => $step])->render();
        $elements = array(
            1 => [
                'title_section' => '',
                'title' => null,
                'subtitle' => null,
                
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'col' => 'col-12',
                'type' => 'div',
                'content' => $contentInfo,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            
            2 => [
                'title_section' => null,
                'title' => '*Pertenencia de nómina',
                'subtitle' => ' Indica si la nómina pertenece al cliente',
                'name_field' => null,
                'id_field' => 'ammount',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'radio',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => null,
                'col' => 'col-6',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'name' => 'Valida',
                        'name_field' =>  $task['nameField'].'_1',
                        'class' => null,
                        'onclick' => null,
                        'value' => 1,
                        'is_required' => true,
                    ),
                    1 => array(
                        'link' => null,
                        'name' => 'Invalida',
                        'name_field' => $task['nameField'].'_1',
                        'class' => null,
                        'onclick' => null,
                        'value' => 0,
                        'is_required' => true,
                        
                    ),
                )
            ],
            
            3 => [
                'title_section' => null,
                'title' => '*Vigencia de nómina',
                'subtitle' => 'Indica si la nómina es la última',
                'name_field' => null,
                'id_field' => 'ammount',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'radio',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => null,
                'col' => 'col-6',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'name' => 'Valida',
                        'name_field' =>  $task['nameField'].'_2',
                        'class' => null,
                        'onclick' => null,
                        'value' => 1,
                        'is_required' => true,
                    ),
                    1 => array(
                        'link' => null,
                        'name' => 'Invalida',
                        'name_field' => $task['nameField'].'_2',
                        'class' => null,
                        'onclick' => null,
                        'value' => 0,
                        'is_required' => true,
                        
                    ),
                )
            ],
           
            4 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=3_'.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
        );
        return $elements;
    }
    
    public function configFormStep3Task3($id_rel, $history_id, $task, $taskId)
    {
        $credit       = Credit::find($id_rel);
        $client = $credit->creditClientPerson;
        $stepRedirect = $taskId +1;

        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;
        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $taskId) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }


        $contentInfo = \View::make('panel.client.infoClient', ['client' => $client, 'taskId' => $taskId, 'credit' => $credit, 'step' => $step])->render();

        $elements = array(
            1 => [
                'title_section' => '',
                'title' => null,
                'subtitle' => null,
                
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'col' => 'col-12',
                'type' => 'div',
                'content' => $contentInfo,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            
            2 => [
                'title_section' => null,
                'title' => 'Capacidad de pago real',
                'subtitle' => 'indica la capacidad de pago del cliente',
                'name_field' => 'credit[payroll_payment_capacity]',
                'id_field' => 'payroll_payment_capacity',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => true,
                'is_disabled' => null,
                'value' => null,
                'step' => 0.01,
                'col' => 'col-6',
            ],

            3 => [
                'title_section' => null,
                'title' => 'Evidencia capacidad  de pago',
                'subtitle' => '&nbsp;',
                'name_field' => 'file',
                'id_field' => '1',
                'is_required' => true,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'file',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            
            
           
            4 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=3_'.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
        );
        return $elements;
    }
    
    public function configFormStep3Task4($id_rel, $history_id, $task, $taskId)
    {
        $credit       = Credit::find($id_rel);
        $client = $credit->creditClientPerson;
        $stepRedirect = $taskId +1;

        

        $creditPays = CreditPayOff::select('credit_pay_off.id', 'financial_products.alias', 'credit_pay_off.ammount', 'deadline_date', 'annual_int_rate_iva')
        ->join('financial_products', 'credit_pay_off.financial_product_id', 'financial_products.id')
        ->where('credit_pay_off.new_kc_credit_id', $credit->id)
        ->where('kc_credit_id_payed_off', '=', null)
        ->get();

        $creditRefinanced = CreditPayOff::select('credit_pay_off.id', 'financial_products.alias', 'credit_pay_off.ammount', 'deadline_date', 'annual_int_rate_iva')
        ->join('financial_products', 'credit_pay_off.financial_product_id', 'financial_products.id')
        ->where('credit_pay_off.client_person_id', $client->id)
        ->where('kc_credit_id_payed_off', '!=', null)
        ->get();
        
        $totalCompraCartera = CreditPayOff::select('credit_pay_off.id', 'financial_products.alias', 'credit_pay_off.ammount', 'deadline_date', 'annual_int_rate_iva')
        ->join('financial_products', 'credit_pay_off.financial_product_id', 'financial_products.id')
        ->where('credit_pay_off.client_person_id', $client->id)
        ->where('kc_credit_id_payed_off', '=', null)
        ->sum('ammount');
        
        $financialProduct = FinancialProduct::find($credit->applied_financial_product);
        
        $total = $creditPays->sum('ammount');
        $calculadora = new CalculadoraCredito();
        
        $montoMaximo         = $calculadora->getMontoMaximo($client, $financialProduct, $credit->tramit_type);


        $payment = $calculadora->getPayment($financialProduct, $montoMaximo);
        $lead = Lead::find($credit->lead_id);

        $terms        = null;
        if ($financialProduct->max_term != null) {
            $terms = FpTerm::select('terms.id', 'terms.term')
            ->join('terms', 'terms.term_id',  'f_p_terms.term_id')
            ->where('financial_product_id', $financialProduct->id)
            ->where('terms.term', '<=', $financialProduct->max_term)
            ->pluck('terms.term', 'terms.term');
        }
        
        $contentInfo = \View::make('panel.credit.controldeskTask4Step3', ['client' => $client, 'taskId' => $taskId, 'creditRefinanced' => $creditRefinanced, 'credit' => $credit, 'totalCompraCartera' => $totalCompraCartera, 'creditPays' => $creditPays, 'montoMaximo' => $montoMaximo, 'financialProduct' => $financialProduct, 'payment' => $payment, 'lead' => $lead, 'terms' => $terms])->render();

        $elements = array(
            1 => [
                'title_section' => '',
                'title' => null,
                'subtitle' => null,
                
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'col' => 'col-12',
                'type' => 'div',
                'content' => $contentInfo,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            
            
            2 => [
                'title_section' => null,
                'title' => '*Validación del crédito',
                'subtitle' => 'Indica si el crédito es viable',
                'name_field' => null,
                'id_field' => 'ammount',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'radio',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => null,
                'col' => 'col-6',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'name' => 'Valida',
                        'name_field' =>  $task['nameField'],
                        'class' => null,
                        'onclick' => null,
                        'value' => 1,
                        'is_required' => true,
                    ),
                    1 => array(
                        'link' => null,
                        'name' => 'Invalida',
                        'name_field' => $task['nameField'],
                        'class' => null,
                        'onclick' => null,
                        'value' => 0,
                        'is_required' => true,
                        
                    ),
                )
            ],
            
           
            3 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            4 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=3_'.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'validateBtnSave',
                'id_field' => 'validateBtnSave',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => true,
                'col' => 'col-12'
            ],
        );
        return $elements;
    }
    
    public function configFormStep3Task5($id_rel, $history_id, $task, $taskId)
    {
        $credit       = Credit::find($id_rel);
        $client = $credit->creditClientPerson;
        $stepRedirect = $taskId +1;
        $financialProduct = FinancialProduct::find($credit->applied_financial_product);
        $urlRedirect = '/panel/template/steps/controlDesk/' . $history_id . '/show';
       /*  if ($financialProduct->type_product_id === 3) {
            $urlRedirect = '/panel/kc-control-desk';
        } */
        
        $contentInfo = \View::make('panel.client.infoClient', ['client' => $client, 'taskId' => $taskId, 'credit' => $credit])->render();

        $elements = array(
            1 => [
                'title_section' => '',
                'title' => null,
                'subtitle' => null,
                
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'col' => 'col-12',
                'type' => 'div',
                'content' => $contentInfo,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
        );

        // Add conditional element 6 based on clabe_ownership
        if ($client->clabe_ownership == 1) {
            //mostrar archivo adjunto si esta validado 
            $path       = File::PATH;
            $getFile = File::where([
                'model' => 21,
                'id_rel' => $credit->id,
                'template_config_id' => 4,
                'step' => '3_5',
                'client_id' => $client->id,
            ])->orderBy('id', 'DESC')->first();
            $file_validate =  $getFile != null ? '<a href="/'.$path.'/'.$getFile->name.'" target="_blank">Ver CEP</a>' : 'No hay archivo adjunto';

            $elements[2] = [
                'title_section' => null,
                'title' => null,
                'name_field' => '',
                'content' => $file_validate,
                'id_field' => '',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'div',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-12'
            ];
        }

        // Add conditional elements based on clabe_ownership
        if ($client->clabe_ownership != 1) {
            $elements[2] = [
                'title_section' => null,
                'title' => 'CEP',
                'subtitle' => 'Adjunta el comprobante electrónico de pago',
                'name_field' => 'cep',
                'id_field' => '1',
                'is_required' => true,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'file',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ];
        }

        $elements[3] = [
            'title_section' => null,
            'title' => '*Pertenencia de cuenta',
            'subtitle' => 'Indica si la clabe pertenece al cliente',
            'name_field' => null,
            'id_field' => 'ammount',
            'comment_admin' => '',
            'comment_webApp' =>  null,
            'placeholder' => '',
            'type' => 'radio',
            'is_option_array' => false,
            'options' => 'null',
            'is_required' => false,
            'is_disabled' => null,
            'value' => null,
            'col' => 'col-6',
            'childs' => array(
                0 => array(
                    'link' => null,
                    'name' => 'Valida',
                    'name_field' =>  $task['nameField'],
                    'class' => null,
                    'onclick' => null,
                    'value' => 1,
                    'is_required' => true,
                ),
                1 => array(
                    'link' => null,
                    'name' => 'Invalida',
                    'name_field' => $task['nameField'],
                    'class' => null,
                    'onclick' => null,
                    'value' => 0,
                    'is_required' => true,
                    
                ),
            )
        ];
        
       
        $elements[4] = [
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
            'value' => $urlRedirect,
            'col' => 'col-12'
        ];
        $elements[5] = [
            'title_section' => null,
            'title' => null,
            'name_field' => 'url_redirect_next',
            'id_field' => 'url_redirect_next',
            'comment_admin' => '',
            'comment_webApp' =>  null,
            'placeholder' => '',
            'type' => 'hidden',
            'is_option_array' => false,
            'options' => 'null',
            'is_required' => false,
            'is_disabled' => null,
            'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=3_'.$stepRedirect.'&step_origin=',
            'col' => 'col-12'
        ];

        
        if ($client->clabe_ownership != 1) {
            $elements[6] = [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-model',
                'id_field' => 'action-model',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-12'
            ];
            $elements[7] = [
                'title_section' => null,
                'title' => null,
                'name_field' => 'step',
                'id_field' => 'step',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '3_5',
                'col' => 'col-12'
            ];

            $elements[8] = [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-id_rel',
                'id_field' => 'action-id_rel',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => $id_rel,
                'col' => 'col-12'
            ];
        }

        
        return $elements;
    }
    
    public function configFormDynamicStep3($id_rel, $history_id, $task, $taskId)
    {
        $credit       = Credit::find($id_rel);
        $client = $credit->creditClientPerson;
        $stepRedirect = $taskId +1;
        $payOff = CreditPayOff::where('new_kc_credit_id', $credit->id)->first();
        $contentInfo = \View::make('panel.client.infoClient', ['client' => $client, 'taskId' => $taskId, 'credit' => $credit, 'payOff' => $payOff])->render();

        $elements = array(
            1 => [
                'title_section' => '',
                'title' => null,
                'subtitle' => null,
                
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'col' => 'col-12',
                'type' => 'div',
                'content' => $contentInfo,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            
           2 => [
                'title_section' => null,
                'title' => 'CEP',
                'subtitle' => 'Adjunta el comprobante electrónico de pago',
                'name_field' => 'cep',
                'id_field' => '1',
                'is_required' => true,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'file',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
           ],
            
            3 => [
                'title_section' => null,
                'title' => '*Pertenencia de cuenta',
                'subtitle' => 'Indica si la clabe pertenece al cliente',
                'name_field' => null,
                'id_field' => 'ammount',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'radio',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => null,
                'col' => 'col-6',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'name' => 'Valida',
                        'name_field' =>  $task['nameField'],
                        'class' => null,
                        'onclick' => null,
                        'value' => 1,
                        'is_required' => true,
                    ),
                    1 => array(
                        'link' => null,
                        'name' => 'Invalida',
                        'name_field' => $task['nameField'],
                        'class' => null,
                        'onclick' => null,
                        'value' => 0,
                        'is_required' => true,
                        
                    ),
                )
            ],
            
           
            4 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=3_'.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
        );
        return $elements;
    }

    public function configFormStep4Task1($id_rel, $history_id, $step)
    {
        $credit       = Credit::find($id_rel);
        $name_form    = 'frm-template_control_desk_step4_task1';
        $type_form    = HistoryLog::KC_CONTROL_DESK_TASK1_STEP4;
        $client = $credit->creditClientPerson;
        
        

        $loan_type    = config('enums.loan_type');
        $sign_type    = config('enums.sign_type');
        $periodicity  = config('enums.periodicity');
        
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $taskId = null;

        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $taskId) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }

        $taks = self::ElementsTaskStep2($history_id, null);
        $templateId = $taskId -1;
        $task = $taks[$templateId];

        $payOff = CreditPayOff::find($task['id']);
        

        $stepRedirect = $taskId +1;
        $contentInfo = \View::make('panel.client.infoClient', ['client' => $client, 'taskId' => $taskId, 'credit' => $credit, 'payOff' => null, 'step' => $step])->render();

        
            

        $elements = array(
            1 => [
                'title_section' => '',
                'title' => null,
                'subtitle' => null,
                
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'col' => 'col-12',
                'type' => 'div',
                'content' => $contentInfo,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
            ],
            2 => [
                'title_section' => null,
                'title' => '*Firma de contrato válida',
                'subtitle' => 'Indica si la firma del cliente es válida',
                'name_field' => null,
                'id_field' => 'ammount',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'radio',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => null,
                'col' => 'col-6',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'name' => 'Valida',
                        'name_field' =>  'firma-de-contrato-valida',
                        'class' => null,
                        'onclick' => null,
                        'value' => 1,
                        'is_required' => true,
                    ),
                    1 => array(
                        'link' => null,
                        'name' => 'Invalida',
                        'name_field' => 'firma-de-contrato-valida',
                        'class' => null,
                        'onclick' => null,
                        'value' => 0,
                        'is_required' => true,
                        
                    ),
                )
            ],
            
           
            4 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=4_'.$stepRedirect.'&step_origin=',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    
    public function configFormStep4Task2($id_rel, $history_id, $step)
    {
        $credit       = Credit::find($id_rel);
        $product = FinancialProduct::find($credit->applied_financial_product);
        $name_form    = 'frm-template_control_desk_step4_task2';
        $type_form    = HistoryLog::KC_CONTROL_DESK_TASK2_STEP4;
        $client = $credit->creditClientPerson;
        
        

        $loan_type    = config('enums.loan_type');
        $sign_type    = config('enums.sign_type');
        $periodicity  = config('enums.periodicity');
        
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $taskId = null;

        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $taskId) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }

        $taks = self::ElementsTaskStep2($history_id, null);
        $templateId = $taskId -1;
        $task = $taks[$templateId];

        $payOff = CreditPayOff::find($task['id']);
        

        $stepRedirect = $taskId +1;
        
        $contentInfo = \View::make('panel.client.infoClient', ['client' => $client, 'taskId' => $taskId, 'credit' => $credit, 'payOff' => null, 'step' => $step, 'product' => $product])->render();
        
        if ($product->type_product_id != 3) {
            $elements = array(
                1 => [
                    'title_section' => '',
                    'title' => null,
                    'subtitle' => null,
                    
                    'id_field' => null,
                    'comment_admin' => null,
                    'comment_webApp' =>  null,
                    'col' => 'col-12',
                    'type' => 'div',
                    'content' => $contentInfo,
                    'is_option_array' => false,
                    'options' => null,
                    'is_required' => true,
                    'is_disabled' => null,
                ],
                
                2 => [
                    'title_section' => '',
                    'title' => null,
                    'subtitle' => null,
                    
                    'id_field' => null,
                    'comment_admin' => null,
                    'comment_webApp' =>  null,
                    'col' => 'col-12',
                    'type' => 'div',
                    'content' => '<a class="btn btn-outline-primary" href="/panel/credit/export/'.$credit->id.'/contrato"> Exportar CSV </a> ',
                    'is_option_array' => false,
                    'options' => null,
                    'is_required' => true,
                    'is_disabled' => null,
                ],
    
               
                3 => [
                    'title_section' => null,
                    'title' => '*Contrato de crédito',
                    'subtitle' => 'Indica si el cliente ya firmó el contrato de crédito',
                    'name_field' => null,
                    'id_field' => 'ammount',
                    'comment_admin' => '',
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'radio',
                    'is_option_array' => false,
                    'options' => 'null',
                    'is_required' => false,
                    'is_disabled' => null,
                    'value' => null,
                    'col' => 'col-6',
                    'childs' => array(
                        0 => array(
                            'link' => null,
                            'name' => 'Valida',
                            'name_field' =>  'credit_agreement_signed',
                            'class' => null,
                            'onclick' => null,
                            'value' => 1,
                            'is_required' => true,
                        ),
                        1 => array(
                            'link' => null,
                            'name' => 'Invalida',
                            'name_field' => 'credit_agreement_signed',
                            'class' => null,
                            'onclick' => null,
                            'value' => 0,
                            'is_required' => true,
                            
                        ),
                    )
                ],
                
                4 => [
                    'title_section' => null,
                    'title' => '*Firma de contrato válida',
                    'subtitle' => 'Indica si la firma del cliente es válida',
                    'name_field' => null,
                    'id_field' => 'ammount',
                    'comment_admin' => '',
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'radio',
                    'is_option_array' => false,
                    'options' => 'null',
                    'is_required' => false,
                    'is_disabled' => null,
                    'value' => null,
                    'col' => 'col-6',
                    'childs' => array(
                        0 => array(
                            'link' => null,
                            'name' => 'Valida',
                            'name_field' =>  'firma-de-contrato-valida',
                            'class' => null,
                            'onclick' => null,
                            'value' => 1,
                            'is_required' => true,
                        ),
                        1 => array(
                            'link' => null,
                            'name' => 'Invalida',
                            'name_field' => 'firma-de-contrato-valida',
                            'class' => null,
                            'onclick' => null,
                            'value' => 0,
                            'is_required' => true,
                            
                        ),
                    )
                ],
    
                5 => [
                    'title_section' => null,
                    'title' => '*Contrato firmado',
                    'subtitle' => 'Adjunta el contrato firmado',
                    'name_field' => 'Contrato firmado',
                    'id_field' => '4',
                    'comment_admin' => null,
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'dropzone',
                    'is_option_array' => false,
                    'options' => null,
                    'is_required' => true,
                    'is_disabled' => null
                ],
                6 => [
                    'title_section' => null,
                    'title' => null,
                    'name_field' => 'action-model',
                    'id_field' => 'action-model',
                    'comment_admin' => '',
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'hidden',
                    'is_option_array' => false,
                    'options' => 'null',
                    'is_required' => false,
                    'is_disabled' => null,
                    'value' => 'controlDesk',
                    'col' => 'col-12'
                ],
                
                7 => [
                    'title_section' => null,
                    'title' => null,
                    'name_field' => 'action-id_rel',
                    'id_field' => 'action-id_rel',
                    'comment_admin' => '',
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'hidden',
                    'is_option_array' => false,
                    'options' => 'null',
                    'is_required' => false,
                    'is_disabled' => null,
                    'value' => $id_rel,
                    'col' => 'col-12'
                ],
                
               
                8 => [
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
                    'value' => '/panel/template/steps/controlDesk/'.$history_id.'/show',
                    'col' => 'col-12'
                ],
                9 => [
                    'title_section' => null,
                    'title' => null,
                    'name_field' => 'url_redirect_next',
                    'id_field' => 'url_redirect_next',
                    'comment_admin' => '',
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'hidden',
                    'is_option_array' => false,
                    'options' => 'null',
                    'is_required' => false,
                    'is_disabled' => null,
                    'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=4_'.$stepRedirect.'&step_origin=',
                    'col' => 'col-12'
                ],
                10 => [
                    'title_section' => null,
                    'title' => null,
                    'name_field' => 'step',
                    'id_field' => 'step',
                    'comment_admin' => '',
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'hidden',
                    'is_option_array' => false,
                    'options' => 'null',
                    'is_required' => false,
                    'is_disabled' => null,
                    'value' => 4,
                    'col' => 'col-12'
                ],
            );
        } else {
            $elements = array(
                1 => [
                    'title_section' => '',
                    'title' => null,
                    'subtitle' => null,
                    
                    'id_field' => null,
                    'comment_admin' => null,
                    'comment_webApp' =>  null,
                    'col' => 'col-12',
                    'type' => 'div',
                    'content' => $contentInfo,
                    'is_option_array' => false,
                    'options' => null,
                    'is_required' => true,
                    'is_disabled' => null,
                ],
                2 => [
                    'title_section' => null,
                    'title' => '*Solicitud/Descuento SOD',
                    'subtitle' => ' Indica si el cliente aceptó la Solicitud/Descuento SOD',
                    'name_field' => null,
                    'id_field' => 'ammount',
                    'comment_admin' => '',
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'radio',
                    'is_option_array' => false,
                    'options' => 'null',
                    'is_required' => false,
                    'is_disabled' => null,
                    'value' => null,
                    'col' => 'col-6',
                    'childs' => array(
                        0 => array(
                            'link' => null,
                            'name' => 'Valida',
                            'name_field' =>  'solicituddescuento-sod',
                            'class' => null,
                            'onclick' => null,
                            'value' => 1,
                            'is_required' => true,
                        ),
                        1 => array(
                            'link' => null,
                            'name' => 'Invalida',
                            'name_field' => 'solicituddescuento-sod',
                            'class' => null,
                            'onclick' => null,
                            'value' => 0,
                            'is_required' => true,
                            
                        ),
                    )
                ],

                3 => [
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
                    'value' => '/panel/template/steps/controlDesk/'.$history_id.'/show',
                    'col' => 'col-12'
                ],
                4 => [
                    'title_section' => null,
                    'title' => null,
                    'name_field' => 'url_redirect_next',
                    'id_field' => 'url_redirect_next',
                    'comment_admin' => '',
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'hidden',
                    'is_option_array' => false,
                    'options' => 'null',
                    'is_required' => false,
                    'is_disabled' => null,
                    'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=4_'.$stepRedirect.'&step_origin=',
                    'col' => 'col-12'
                ],
                5=> [
                    'title_section' => null,
                    'title' => null,
                    'name_field' => 'step',
                    'id_field' => 'step',
                    'comment_admin' => '',
                    'comment_webApp' =>  null,
                    'placeholder' => '',
                    'type' => 'hidden',
                    'is_option_array' => false,
                    'options' => 'null',
                    'is_required' => false,
                    'is_disabled' => null,
                    'value' => 4,
                    'col' => 'col-12'
                ],
            );
        }
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function configFormStep2Task1($id_rel, $history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : '1';
        $name_form = 'frm-template_control_desk_step2_task1';
        $type_form = HistoryLog::KC_CONTROL_DESK_TASK1_STEP2;
        $credit = Credit::find($id_rel);
        $clientPerson = ClientPerson::find($credit->client_person_id);
        $elements = array(
            
            1 => [
                'title_section' => null,
                'title' => 'Primer apellido',
                'subtitle' => 'Captura apellido como en la ID',
                'name_field' => 'client_person[ID_primer_apellido]',
                'id_field' => 'ID_primer_apellido',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $clientPerson != null ? $clientPerson->ID_primer_apellido : null,
            ],
            2 => [
                'title_section' => null,
                'title' => 'Segundo apellido',
                'subtitle' => 'Captura apellido como en la ID',
                'name_field' => 'client_person[ID_segundo_apellido]',
                'id_field' => 'ID_segundo_apellido',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $clientPerson != null ? $clientPerson->ID_segundo_apellido : null,
            ],
            3 => [
                'title_section' => null,
                'title' => 'Nombres',
                'subtitle' => 'Captura nombre como en la ID',
                'name_field' => 'client_person[ID_nombres]',
                'id_field' => 'ID_nombres',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $clientPerson != null ? $clientPerson->ID_nombres : null,
            ],
           
            4 => [
                'title_section' => null,
                'title' => 'Vigencia',
                'subtitle' => 'Captura fecha como en la ID',
                'name_field' => 'client_person[ID_vigencia]',
                'id_field' => 'ID_vigencia',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'min' => 1900,
                'max' => 2100,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $clientPerson != null ? $clientPerson->ID_vigencia : null,
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            6 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=2_2&step_origin=',
                'col' => 'col-12'
            ],
            7 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-model',
                'id_field' => 'action-model',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function configFormStep2Task2($id_rel, $history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : '1';
        $name_form = 'frm-template_control_desk_step2_task2';
        $type_form = HistoryLog::KC_CONTROL_DESK_TASK2_STEP2;
        $credit = Credit::find($id_rel);
        $clientPerson = ClientPerson::find($credit->client_person_id);

        $elements = array(
            
            1 => [
                'title_section' => null,
                'title' => 'CIC',
                'subtitle' => 'Captura el Código de Identificación de la Credencial como en la ID',
                'name_field' => 'client_person[ID_CIC]',
                'id_field' => 'ID_CIC',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $clientPerson != null ? $clientPerson->ID_CIC : null,
            ],
            2 => [
                'title_section' => null,
                'title' => 'IDC',
                'subtitle' => 'Captura el Código de Identificación del ciudadano como en la ID',
                'name_field' => 'client_person[ID_IDC]',
                'id_field' => 'ID_IDC',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $clientPerson != null ? $clientPerson->ID_IDC : null,
            ],
            3 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            4 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=2_3&step_origin=',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-model',
                'id_field' => 'action-model',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    
    public function configFormStep2Task3($id_rel, $history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : '1';
        $name_form = 'frm-template_control_desk_step2_task3';
        $type_form = HistoryLog::KC_CONTROL_DESK_TASK3_STEP2;
        $credit = Credit::find($id_rel);
        
        $clientPerson = ClientPerson::find($credit->client_person_id);
        
        $elements = array(
            
            1 => [
                'title_section' => null,
                'title' => 'Fecha nómina',
                'subtitle' => 'Captura la fecha del recibo de nómina',
                'name_field' => 'credit[payroll_date]',
                'id_field' => 'payroll_date',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'date',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $credit != null ? $credit->payroll_date : null,
            ],
            2 => [
                'title_section' => null,
                'title' => 'Total nómina',
                'subtitle' => 'Captura el total del recibo de nómina (percepciones menos deducciones)',
                'name_field' => 'credit[payroll_total]',
                'id_field' => 'payroll_total',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'value' => $credit != null ? $credit->payroll_total : null,
            ],
            3 => [
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
                'value' => '/panel/template/steps/controlDesk/' . $history_id . '/show',
                'col' => 'col-12'
            ],
            4 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'url_redirect_next',
                'id_field' => 'url_redirect_next',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=2_3&step_origin=',
                'col' => 'col-12'
            ],
            5 => [
                'title_section' => null,
                'title' => null,
                'name_field' => 'action-model',
                'id_field' => 'action-model',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => 'controlDesk',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function configFormstep3_1($id_rel, $history_id)
    {
        $name_form    = 'frm-template_control_desk_step3_1';
        $type_form    = HistoryLog::KC_CONTROL_DESK_TASK1_STEP2;
        $sex = config('enums.sex');
        $step = isset($_GET['step']) ? $_GET['step'] : '3';

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
                'title_section' => '&nbsp;',
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
            3 => [
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
            4 => [
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
            5 => [
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
            6 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            7 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            8 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            9 => [
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
            10 => [
                'title_section' => '&nbsp;',
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
            11 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            12 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            13 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            14 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            15 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            16 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            17 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            18 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            19 => [
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
            20 => [
                'title_section' => '&nbsp;',
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

            21 => [
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
                'is_required' => true,
                'is_disabled' => null
            ],
            22 => [
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
            23 => [
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
            24 => [
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
                'is_required' => true,
                'is_disabled' => null
            ],
            25 => [
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
            26 => [
                'title_section' => '&nbsp;',
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
            27 => [
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
            28 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            29 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            30 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            31 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            32 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            33 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            34 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            35 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            36 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            37 => [
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
                'value' => '/panel/template/steps/controlDesk/'.$history_id.'/show',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function configFormstep3_2($id_rel, $history_id)
    {
        $name_form        = 'frm-template_control_desk_step3_2';
        $type_form        = HistoryLog::KC_CONTROL_DESK_TASK2_STEP2;
        $marital_status   = config('enums.marital_status');
        $education_level  = config('enums.education_level');
        $home_type        = config('enums.home_type');
        $option_switch    = array(1 => 'Sí', 2 => 'No');
        $option_interviewer    = config('enums.interviewer');
        $prepad_method          = array(1 => 'Efectivo', 2 => 'cheque', 3 => 'transferencia', 4 => 'otro');
        $step = isset($_GET['step']) ? $_GET['step'] : '3';

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
                'title_section' => '&nbsp;',
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
            3 => [
                'title_section' => null,
                'title' => 'Entrevistador',
                'name_field' => 'credit[interviewer]',
                'id_field' => 'interviewer',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $option_interviewer,
                'is_required' => true,
                'is_disabled' => null
            ],
            4 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            5 => [
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
            6 => [
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
            7 => [
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
            8 => [
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
            9 => [
                'title_section' => '&nbsp;',
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
            10 => [
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
            11 => [
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
            12 => [
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
            13 => [
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
            14 => [
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
            15 => [
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

            16 => [
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
            17 => [
                'title_section' => null,
                'title' => 'Tiempo de vivir ahí',
                'name_field' => 'client_person[home_time_living]',
                'id_field' => 'home_time_living',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            18 => [
                'title_section' => null,
                'title' => 'Comentarios vivienda',
                'name_field' => 'client_person[home_note]',
                'id_field' => 'home_note',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'textarea',
                'col' => 'col-12',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],

            19 => [
                'title_section' => 'Bienes',
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
            21 => [
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
            22 => [
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
            23 => [
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
            24 => [
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
            25 => [
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
            26 => [
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
            27 => [
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
            28 => [
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
            29 => [
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
            30 => [
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
            31 => [
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
            32 => [
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
            33 => [
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
            34 => [
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
            35 => [
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
            36 => [
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
            37 => [
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
            38 => [
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
            39 => [
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
            40 => [
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
            41 => [
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
            42 => [
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
            43 => [
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
            44 => [
                'title_section' => null,
                'title' => 'Nombres',
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
            45 => [
                'title_section' => null,
                'title' => 'Relación',
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
            46 => [
                'title_section' => null,
                'title' => 'Puesto',
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
            47 => [
                'title_section' => null,
                'title' => 'Período',
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
            48 => [
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
            49 => [
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
            50 => [
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
            51 => [
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
            52 => [
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
            53 => [
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
            54 => [
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
            55 => [
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
            56 => [
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
            57 => [
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
            58 => [
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
                'value' => '/panel/template/steps/controlDesk/'.$history_id.'/show',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function configFormstep4($id_rel, $history_id)
    {
        $name_form        = 'frm-template_control_desk_step4';
        $type_form        = HistoryLog::KC_CONTROL_DESK_TASK3_STEP2;
        $marital_status   = config('enums.marital_status');
        $education_level  = config('enums.education_level');
        $home_type        = config('enums.home_type');
        $option_switch    = array(1 => 'Sí', 2 => 'No');
        $prepad_method          = array(1 => 'Efectivo', 2 => 'cheque', 3 => 'transferencia', 4 => 'otro');
        $credit = Credit::find($id_rel);
        $client_person = $credit->creditClientPerson;
        $curp = $client_person != null ? $client_person->curp : null;
        $rfc = $client_person != null ? $client_person->rfc : null;
        //$show_btn = false;
        $step = isset($_GET['step']) ? $_GET['step'] : '4';

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
                'is_required' => false,
                'is_disabled' => 'readonly',
                'value' => $curp,
                'class' => 'col-12 col-md-6',
                'class_form_group' => 'mb-0',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'type' => 'href',
                        'name_field' => 'Validar',
                        'class' => 'btn btn-outline-primary float-end',
                        'onclick' => 'kycCreditHistory(' . $history_id . ', 1)'
                    ),
                    1 => array(
                        'link' => null,
                        'type' => 'div',
                        'col' => 'col-12 col-md-6 my-0',
                        'name_field' => '',
                        'class' => 'btn btn-outline-primary float-end',
                        'id_field' => 'kyc-curp',
                        
                    ),
                )
            ],
            
            3 => [
                'title_section' => null,
                'title' => 'Validar INE',
                'name_field' => 'client_person[ine]',
                'id_field' => 'ine',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => 'Código identificador de Credencial',
                'type' => 'text',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '',
                'class' => 'col-12 col-md-6',
                'class_form_group' => 'mb-0',
                'childs' => array(
                    0 => array(
                        'placeholder' => 'Identificador del ciudadano',
                        'link' => null,
                        'type' => 'text',
                        'name_field' => 'identificador_ciudadano',
                        'id_field' => 'identificadorCiudadano',
                        'class' => 'btn btn-outline-primary float-end',
                        'onclick' => 'kycCreditHistory(' . $history_id . ', 2)'
                    ),
                    1 => array(
                        'link' => '/images/credencial-modeloEG.png',
                        'target' => '_blank',
                        'type' => 'href',
                        'name_field' => '<em class="icon ni ni-help"></em> Ayuda',
                        'class' => 'text-primary',
                        'onclick' => 'kycCreditHistory(' . $history_id . ', 2)'
                    ),
                    2 => array(
                        'link' => null,
                        'type' => 'href',
                        'title' => 'text_info',
                        'name_field' => 'Validar',
                        'class' => 'btn btn-outline-primary float-end',
                        'onclick' => 'kycCreditHistory(' . $history_id . ', 2)'
                    ),
                    3 => array(
                        'link' => null,
                        'type' => 'div',
                        'col' => 'col-12 col-md-6 my-0',
                        'name_field' => '',
                        'class' => 'btn btn-outline-primary float-end',
                        'id_field' => 'kyc-ine',
                        
                    ),
                )
            ],
           
            4 => [
                'title_section' => null,
                'title' => 'Validar RFC',
                'name_field' => 'client_person[rfc]',
                'id_field' => 'rfc',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => 'readonly',
                'value' => $rfc,
                'class' => 'col-12 col-md-6',
                'class_form_group' => 'mb-0',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'type' => 'href',
                        'name_field' => 'Validar',
                        'class' => 'btn btn-outline-primary float-end',
                        'onclick' => 'kycCreditHistory(' . $history_id . ', 3)'
                    ),
                    1 => array(
                        'link' => null,
                        'type' => 'div',
                        'col' => 'col-12 col-md-6 my-0',
                        'name_field' => '',
                        'class' => 'btn btn-outline-primary float-end',
                        'id_field' => 'kyc-rfc',
                        
                    ),
                )
            ],
            
            5 => [
                'title_section' => null,
                'title' => 'Validar Datos laborales ISSSTE',
                'name_field' => 'client_person[issste]',
                'id_field' => 'issste',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'text',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => 'readonly',
                'value' => $curp,
                'col' => 'col-12 col-md-6',
                'class_input' => '',
                'class_form_group' => 'mb-0',
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'type' => 'href',
                        'name_field' => 'Validar',
                        'class' => 'btn btn-outline-primary float-end my-n3',
                        'onclick' => 'kycCreditHistory(' . $history_id . ', 4)'
                    ),
                    1 => array(
                        'link' => null,
                        'type' => 'div',
                        'col' => 'col-12 col-md-6 my-0',
                        'name_field' => '',
                        'class' => 'btn btn-outline-primary float-end',
                        'id_field' => 'kyc-issste',
                        
                    ),
                )
            ],
          
            6 => [
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
                'value' => '/panel/template/steps/controlDesk/'.$history_id.'/show',
                'col' => 'col-12'
            ],
            7 => [
                'title_section' => null,
                'title' => null,
                'name_field' => '',
                'id_field' => 'kyc-curp-msg',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '',
                'col' => ''
            ],
            
            8 => [
                'title_section' => null,
                'title' => null,
                'name_field' => '',
                'id_field' => 'kyc-ine-msg',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '',
                'col' => ''
            ],
            9 => [
                'title_section' => null,
                'title' => null,
                'name_field' => '',
                'id_field' => 'kyc-rfc-msg',
                'comment_admin' => '',
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'is_option_array' => false,
                'options' => 'null',
                'is_required' => false,
                'is_disabled' => null,
                'value' => '',
                'col' => ''
            ],

        );
        $list = \View::make('panel.module.form', ['elements' => $elements,  'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    public function configFormstep5($id_rel, $history_id)
    {
        $name_form        = 'frm-template_control_desk_step5';
        $type_form        = HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2;
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
                'is_disabled' => null,
                'childs' => array(
                    0 => array(
                        'link' => null,
                        'type' => 'div',
                        'name_field' => null,
                        'col' => 'col-md-6 text-primary h6',
                        'id_field' => 'text-firma',
                        'onclick' => null
                    ),
                )
            ],
            2 => [
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
                'value' => '/panel/template/steps/controlDesk/'.$history_id.'/show',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function configFormstep5_2($id_rel, $history_id)
    {
        $credit = Credit::find($id_rel);
        $name_form = 'frm-template_control_desk_step5_2';
        $type_form = HistoryLog::KC_CONTROL_DESK_TASK1_STEP3;
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
            3 => [
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
                'value' => '/panel/template/steps/controlDesk/'.$history_id.'/show',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function saveForm($request)
    {
        $id_rel      = $request->id_rel;
        $credit      = Credit::find($id_rel);
        $financialProduct = FinancialProduct::find($credit->applied_financial_product);
        $client = $credit->creditClientPerson;
        $history     = HistoryLog::find($request->history_id);
        $step_origin = isset($request->step_origin) ? $request->step_origin : null;
        $urlRedirect = isset($request->url_redirect_next) ? $request->url_redirect_next : null;
        $step = null;
        $task = null;

        if ($urlRedirect) {
            // Extraer la parte de consulta de la URL
            $query = parse_url($urlRedirect, PHP_URL_QUERY);

            // Parsear los parámetros de la consulta
            parse_str($query, $params);

            // Obtener el valor de 'step' si existe
            if (isset($params['step'])) {
                $stepValue = $params['step'];

                // Verificar si contiene un guion bajo "_"
                if (strpos($stepValue, '_') !== false) {
                    list($step, $task) = array_map('intval', explode('_', $stepValue));
                } else {
                    $step = intval($stepValue);
                    $task = null;
                }
            }
        }

        if ($task != null) {
            $task = $task -1;

        }
        
        if ($request->credit) {
            $data_credit = $request->credit;
            if ($task == 4) {
                //calculos para guardar en credits cuando sea control desk etapa 4
                $getMontoRefinanciar = CreditPayOff::selectRaw('SUM(ammount) as ammount')
                            ->join('financial_products', 'financial_products.id', 'credit_pay_off.financial_product_id')
                            ->where([
                                'new_kc_credit_id' => $credit->id,
                                'is_kc_lender' => 1
                            ])->first();
                $getCompracartera = CreditPayOff::selectRaw('SUM(ammount) as ammount')
                ->join('financial_products', 'financial_products.id', 'credit_pay_off.financial_product_id')
                ->where([
                    'new_kc_credit_id' => $credit->id,
                    'is_kc_lender' => 0
                ])->first();
                if ($getMontoRefinanciar != null) {
                    $data_credit['refinance_adjustment'] = $getMontoRefinanciar->ammount;
                }
                
                if ($getCompracartera != null) {
                    $data_credit['third_party_adjustment'] = $getMontoRefinanciar->ammount;
                }
                //$data_credit['applied_loan_total_amount'] = $credit->applied_payment * $credit->applied_term;
                $data_credit['applied_interest_rate'] = $financialProduct->annual_interest_rate;
                $data_credit['applied_CAT'] = $financialProduct->rate_cat;
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

            //validar etapa 1 
            
            if ($step != 4 ) {
                if ($task  == null) {
                    $percentTask1Step1   = self::percentUpload($id_rel);
                    $percentTask2Step1   = self::percentUpload($id_rel, 2);
                    $percentTask3Step1   = self::percentUpload($id_rel, 3);
                    
                    
                    if ($percentTask1Step1 == 100) {
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK1_STEP1, $credit->id, 1); //terminar tarea1
                        //iniciar tarea 2 etapa 1
                        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK2_STEP1, HistoryLog::KC_CONTROL_DESK_TASK2_STEP1, null, false);
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP1, $credit->id, 0);
                        
                    }
        
                    if ($percentTask2Step1 == 100) {
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP1, $credit->id, 1); //terminar tarea2
                        //iniciar tarea 2 etapa 1
                        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK3_STEP1, HistoryLog::KC_CONTROL_DESK_TASK3_STEP1, null, false);
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK3_STEP1, $credit->id, 0);
                    }
                    
                    
                    //actualizar las tareas dinamicas
                    if ($percentTask3Step1 == 100) {
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK3_STEP1, $credit->id, 1); //terminar tarea3
        
                        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1, null, false);
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1, $credit->id, 0);
                        //recorrer las tareas dinamicas y ver su porcentaje
                        $elements = self::ElementsTaskStep1($request->history_id);
                        
                        if ($task == null && $step > 3) {
                            $percent =  self::percentUpload($id_rel, $step);
                            if ($percent == 100) {
                                HistoryLog::where([
                                    'is_credit' => 1,
                                    'id_rel' => $id_rel,
                                    'status_id' => HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1,
                                    'status' => 1,
                                ])->update([
                                    'dynamic_status_id' => $step
                                ]);
                             }
                        }   
                        if ($step -1  == count($elements)) {
                            
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1, $credit->id, 1); //terminar tarea dinamica
                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK1_STEP2, HistoryLog::KC_CONTROL_DESK_TASK1_STEP2, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK1_STEP2, $credit->id, 0);
                        }
                        
                    }
                }
            }
            if ($task != null) {
                if ($step == 2) {
                    $percentTask1Step1  = self::percentTask1Step2($history);
                    $percentTask2Step1  = self::percentTask2Step2($history);
                    $percentTask3Step1  = self::percentTask3Step2($history);
                    
                    

                    if ($percentTask1Step1 == 100) {
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK1_STEP2, $credit->id, 1); //terminar tarea1
                        //iniciar tarea 2 etapa 1
                        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK2_STEP2, HistoryLog::KC_CONTROL_DESK_TASK2_STEP2, null, false);
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP2, $credit->id, 0);
                        
                    }
                    
                    if ($percentTask2Step1 == 100) {
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP2, $credit->id, 1); //terminar tarea1
                        //iniciar tarea 2 etapa 1
                        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK3_STEP2, HistoryLog::KC_CONTROL_DESK_TASK3_STEP2, null, false);
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK3_STEP2, $credit->id, 0);
                        
                    }
                    
                    if ($percentTask3Step1 == 100) {
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK3_STEP2, $credit->id, 1); //terminar tarea1
                        //iniciar tarea 2 etapa 1
                        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, null, false);
                        //KC_CONTROL_DESK_TASK3_STEP2
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, $credit->id, 0);
                    }
                    
                    if ($task > 3) {
                        $taskId = $task -1;

                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK3_STEP1, $credit->id, 1); //terminar tarea3
    
                        HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, null, false);
                        HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, $credit->id, 0);
                        //recorrer las tareas dinamicas y ver su porcentaje
                        $elementsStep2 = self::ElementsTaskStep2($request->history_id);
                        $getTask = $elementsStep2[$taskId];
                        
                        if ($task > 3) {
                            $dataPayOff = $request->pay_off;
                            CreditPayOff::where('id', $getTask['id'])->update($dataPayOff);
                            $percent =  self::DynamicPercentStep2($getTask['id']);
                            
                            
                            if ($percent == 100) {
                                HistoryLog::where([
                                    'is_credit' => 1,
                                    'id_rel' => $id_rel,
                                    'status_id' => HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2,
                                    'status' => 1,
                                ])->update([
                                    'dynamic_status_id' => $getTask['id']
                                ]);
                            }
                        }   
                        if ($task  == count($elementsStep2)) {
                            
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, $credit->id, 1); //terminar tarea dinamica

                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK2_STEP3, HistoryLog::KC_CONTROL_DESK_TASK2_STEP3, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP3, $credit->id, 0);
                        }
                        
                    }
                }
                if ($step == 3) {
                    
                    if ($task <= 5) {
                        $labelValidate = CreditsControlDesk::$labelValidate[$task];
                    } else {
                        $taskId = $task -1;
                        $labelValidate = CreditsControlDesk::$labelValidate[6];
                    }

                    if ($task == 1) {
                        CreditsControlDesk::saveEdit($credit->id, $request, $labelValidate, null);
                        $percentTask1Step3  = self::DynamicPercentStep3($credit->id, $labelValidate);
                        if ($percentTask1Step3 == 100) {
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK1_STEP3, $credit->id, 1); //terminar tarea
    
                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK2_STEP3, HistoryLog::KC_CONTROL_DESK_TASK2_STEP3, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP3, $credit->id, 0);
                        }
                    }
                    
                    if ($task == 2 ) {
                        CreditsControlDesk::where([
                            'credit_id' => $credit->id,
                            'validation' => $labelValidate,
                        ])->delete();
                        CreditsControlDesk::saveEdit($credit->id, $request, $labelValidate, '_1', true);
                        CreditsControlDesk::saveEdit($credit->id, $request, $labelValidate, '_2', true);
                        $percentTask2Step3  = self::DynamicPercentStep3($credit->id, $labelValidate, 1);
                        if ($percentTask2Step3 == 100) {
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP3, $credit->id, 1); //terminar tarea

                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK3_STEP3, HistoryLog::KC_CONTROL_DESK_TASK3_STEP3, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK3_STEP3, $credit->id, 0);
                        }
                    }

                    if ($task == 3) {
                        $percentTask2Step3  = self::DynamicPercentStep3($credit->id, $labelValidate);
                        if ($percentTask2Step3 == 100) {
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK3_STEP3, $credit->id, 1); //terminar tarea

                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK4_STEP3, HistoryLog::KC_CONTROL_DESK_TASK4_STEP3, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK4_STEP3, $credit->id, 0);
                        }
                        $step_task = $step.'_'.$task;
                        // Preparar request para subir archivo asociado a esta tarea/etapa
                        // Asegurar que el request incluya el 'step' esperado por File::upload
                        try {
                            if (method_exists($request, 'request')) {
                                $request->request->set('step', $step_task);
                            } else {
                                // Fallback: asignación directa si no es un Illuminate Request
                                $request->step = $step_task;
                            }

                            // Si viene la imagen bajo otro nombre (p.ej. 'image'), mapearla a 'file'
                            if (method_exists($request, 'file')) {
                                $image = $request->file('image');
                                if ($image) {
                                    if (property_exists($request, 'files') && method_exists($request->files, 'set')) {
                                        $request->files->set('file', $image);
                                    }
                                }
                            }
                            //dd(File::MODEL['controlDesk'], $credit->id, $request, 3);
                            // Subir archivo al modelo controlDesk (21) con template_config_id = 3
                            File::upload(File::MODEL['controlDesk'], $credit->id, $request, 3);
                        } catch (\Exception $e) {
                            // Evitar romper el flujo si falla la carga; registrar si se requiere
                        }
                    }

                    if ($task == 4) {
                        $getProduct = FinancialProduct::where('id', $credit->applied_financial_product)->first();
                        $product_id =  $getProduct->type_product_id; 
                        $applied_periodicity =  $getProduct->periodicity_id; 
                        $applied_payment = $data_credit['applied_payment']; 
                        $applied_loan_total_amount = $applied_payment * $credit->applied_term; 
                        $opening_Commission_percentage =  $getProduct->opening_commission_rate; 
                        $net_amount =  $data_credit['net_amount']; 
                        $opening_commission =  $data_credit['opening_commission']; 
                        
                        Credit::where('id', $credit->id)->update([
                            'product_id' => $product_id,
                            'applied_periodicity' => $applied_periodicity,
                            'applied_payment' => $applied_payment,
                            'applied_loan_total_amount' => $applied_loan_total_amount,
                            'opening_Commission_percentage' => $opening_Commission_percentage,
                            'net_amount' => $net_amount,
                            'opening_commission' => $opening_commission,
                        ]);
                        CreditsControlDesk::saveEdit($credit->id, $request, $labelValidate, null);
                        $percentTask4Step3  = self::DynamicPercentStep3($credit->id, $labelValidate);
                        
                        if ($percentTask4Step3 == 100) {
                            //InvestorsCredit::saveEdit($credit->id);
                            //Credit::unlockPendingCredits($credit->applied_financial_product);
                            InvestorsCredit::removeInvestorsCreditsByProduct($credit->applied_financial_product);
                            //InvestorsCredit::lockFundingIfComplete($credit->id);
                            //$getInvestors = InvestorsCredit::where('credit_id', $credit->id)->get();
                            //foreach ($getInvestors as $getInvestor) {
                                //Transaction::setTotalCapital($getInvestor->investor_id);
                                //Investor::updateInvestorData($getInvestor->investor_id);
                            //}
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK4_STEP3, $credit->id, 1); //terminar tarea

                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK5_STEP3, HistoryLog::KC_CONTROL_DESK_TASK5_STEP3, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK5_STEP3, $credit->id, 0);
                            //InvestorsCredit::lockFundingIfComplete($credit->id);
                            
                            
                            //mover para que aparezca en kc-wallet / solicitud 
                            $tipoCredito   = $financialProduct != null  ? Product::find($financialProduct->type_product_id) : null;
                            $alias_product = $tipoCredito      != null ? $tipoCredito->alias : null;
                            $agreement     = Agreement::find($credit->agreement_id);
                            $auto_go_ahead = $agreement != null && $agreement->auto_go_ahead == 1 ? true : false;

                            if(($alias_product == 'Crédito personal' || $alias_product == 'Soluciona tu deuda') && !$auto_go_ahead) {
                                HistoryLog::move($credit->id, HistoryLog::SOLICITUD, HistoryLog::KC_CONTROL_DESK, null, false);
                            }
                           
                            if(($alias_product == 'Crédito personal' || $alias_product == 'Soluciona tu deuda') && $auto_go_ahead) {
                                Credit::where('id', $credit->id)->update([
                                    'go_ahead' => 2
                                ]);
                            }

                        }
                    }

                    if ($task == 5) {
                        CreditsControlDesk::saveEdit($credit->id, $request, $labelValidate, null);
                        $percentTask5Step3  = self::DynamicPercentStep3($credit->id, $labelValidate);

                        $idvalue  = Str::slug($labelValidate);
                        $value = $request->$idvalue;
                        $validated_clabe = $value == 1 ? $client->bank_clabe : 0;

                        ClientPerson::where('id', $client->id)->update([
                            'clabe_ownership' => $value,
                            'validated_clabe' => $validated_clabe,
                        ]);

                        //guardar cep
                        File::saveCep($request, $credit->id);

                        if ($percentTask5Step3 == 100) {
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK5_STEP3, $credit->id, 1); //terminar tarea

                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP3, HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP3, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP3, $credit->id, 0);


                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK1_STEP4, HistoryLog::KC_CONTROL_DESK_TASK1_STEP4, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK1_STEP4, $credit->id, 0);

                        }

                        
                        
                    }
                    
                    if ($task > 5) {
                        
                        
                        //recorrer las tareas dinamicas y ver su porcentaje
                        $elementsStep3 = self::ElementsTaskStep3($request->history_id);
                        $getTask3 = $elementsStep3[$taskId];
                        
                        $alias = 'Validar clabe '.$getTask3['alias'];
                        $percenttDynamicStep3  = self::DynamicPercentStep3($credit->id, $labelValidate, 0 , $alias);
                        
                        CreditsControlDesk::saveEdit($credit->id, $request, $labelValidate, null, false, 1, $alias);
                        //guardar cep
                        $step_file = $step.'_'.$task;
                        File::saveCep($request, $credit->id, $step_file);
                        
                        if ($percenttDynamicStep3 == 100) {
                            HistoryLog::where([
                                'is_credit' => 1,
                                'id_rel' => $id_rel,
                                'status_id' => HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP3,
                                'status' => 1,
                            ])->update([
                                'dynamic_status_id' => $getTask3['id']
                            ]);
                        }
                        
                        if ($task  == count($elementsStep3)) {
                            
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP3, $credit->id, 1); //terminar tarea dinamica
                            
                            
                        }
                        
                    }
                    
                }

                if ($step == 4) {
                    
                    if ($task == 1) {
                        $labelValidate = CreditsControlDesk::$labelValidate[9];
                        CreditsControlDesk::saveEdit($credit->id, $request, $labelValidate, null);
                        
                        
                        $percentTask1Step4 = self::percentTask1Step4($history->id);
                        if ($percentTask1Step4 == 100) {
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK1_STEP4, $credit->id, 1); //terminar tarea
    
                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK2_STEP4, HistoryLog::KC_CONTROL_DESK_TASK2_STEP4, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP4, $credit->id, 0);
                        }
                    }

                    if ($task == 2) {

                        
                        $labelValidate = $financialProduct->type_product_id != 3 ? CreditsControlDesk::$labelValidate[9] : CreditsControlDesk::$labelValidate[8];
                        CreditsControlDesk::saveEdit($credit->id, $request, $labelValidate, null);
                        
                        
                        Credit::where('id', $credit->id)->update([
                            'credit_agreement_signed' => $request->credit_agreement_signed,
                            
                        ]);
                        $percentTask2Step4 = self::percentTask2Step4($history->id);
                        
                        if ($percentTask2Step4 == 100) {
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP4, $credit->id, 1); //terminar tarea
                            HistoryLog::move($credit->id, HistoryLog::KC_CONTROL_DESK_TASK2_STEP4, HistoryLog::KC_CONTROL_DESK_TASK2_STEP4, null, false);
                            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP4, $credit->id, 0);

                           
                            
                        }
                    }
                }
            }
            
        }
    }

    public function menuPrincipalOptions($history)
    {
        $credit           = $history->historyCredit;
        $client           = $credit->creditClientPerson;
        $status_cancel    = HistoryLog::CREDIT_CANCELED;
        $status_reject    = HistoryLog::CREDIT_REJECTED;
        $status_archive   = HistoryLog::CREDIT_ARCHIVE;
        $old_status       = $history->old_status_id;
        $url_finish       = "panel/kc-control-desk";

        $menu = array(
            'options' => array(
                [
                    'link' => '/panel/template/steps/controlDesk/' . $history->id . '/show',
                    'onclick' => '',
                    'name' => 'Ver etapas',
                    'icon' => 'icon ni ni-list-thumb-fill',
                    'class' => 'text-dark'
                ],
                [
                    'link' => '/panel/client/' . $client->id,
                    'onclick' => '',
                    'name' => 'Ver perfil cliente',
                    'icon' => 'icon ni ni-user-fill'
                ],
                [
                    'link' => '/panel/credit/' . $credit->id,
                    'onclick' => '',
                    'name' => 'Ver perfil crédito',
                    'icon' => 'icon ni ni-report-profit'
                ],
                [
                    'link' => 'https://manychat.com/fb861553/chat/'.$credit->manychat_id,
                    'target' => '_blank',
                    'onclick' => '',
                    'name' => 'ManyChat',
                    'icon' => 'icon ni ni-chat-circle'
                ],
                
                [
                    'link' => null,
                    'onclick' => 'moveModal("Cancelar",' . $credit->id . ',' . $status_cancel . ',' . $old_status . ',"dt-control-desk")',
                    'name' => 'Cancelar',
                    'icon' => 'icon ni ni-cross-circle-fill'
                ],
                [
                    'link' => null,
                    'onclick' => 'moveModal("Rechazar",' . $credit->id . ',' . $status_reject . ',' . $old_status . ',"dt-control-desk")',
                    'name' => 'Rechazar',
                    'icon' => 'icon ni ni-cross-round-fill'
                ],
                [
                    'link' => null,
                    'onclick' => 'moveModal("Archivar",' . $credit->id . ',' . $status_archive . ',' . $old_status . ',"dt-control-desk")',
                    'name' => 'Archivar',
                    'icon' => 'icon ni ni-archive-fill'
                ],
                [
                    'link' => null,
                    'onclick' => 'modalAdvisorCredit('. $credit->id.')',
                    'name' => 'Asignar asesor',
                    'icon' => 'icon ni ni-headphone'
                ],
                [
                    'link' => null,
                    'onclick' => "deliveryFinish({$history->id}, {$history->status_id}, '{$url_finish}', true)",
                    'name' => 'Concluir',
                    'icon' => 'icon ni ni-stop-circle-fill'
                ]
            ),
        );

        return $menu;
    }

    public function getlblStatusApi($history)
    {
        $credit               = $history->historyCredit;
        $percent_file         = self::percentUpload($credit->id);
        $percent_form         = self::percent($history); // etapa 1

        $percent_form_step2   = self::percentTask1Step2($history); // etapa 2


        $percent_form_step3_1 = self::percentFormStep3_1($history); //etapa 3
        $percent_form_step3_2 = self::percentFormStep3_2($history); //etapa 3
        
        $new_step3_1          = $percent_form_step3_1 == 100 ? 1 : 0;
        $new_step3_2          = $percent_form_step3_2 == 100 ? 1 : 0;
        
        $percent_form_step3   = ($new_step3_1 + $new_step3_2) / 2 * 100;
        $percent_form_step4   = self::percentFormStep4($history); //etapa 4
        $percent_form_step5   = self::percentFormStep5($history); //etapa 5

        $status_step2         = 'EN ESPERA';
        $status_step3         = 'EN ESPERA';
        $status_step4         = 'EN ESPERA';
        $status_step5         = 'EN ESPERA';
        

        $status_step1 = ($percent_form >= 100) ? 'CONCLUIDA' : 'EN CURSO';
        $total_percent = ($percent_form >= 100) ? 20 : 0;
        //TODO: change validation when the decision action is carried out in the report
        if ($status_step1 == 'CONCLUIDA') {
            $status_step2 = ($percent_form_step2 >= 100) ? 'CONCLUIDA' : 'EN CURSO';
            $total_percent = ($percent_form_step2 >= 100) ? 40 : 20;
        }

        if ($status_step2 == 'CONCLUIDA') {
            $status_step3 = ($percent_form_step3 == 100 && $percent_form_step4 == 100 && $percent_form_step5 == 100) ? 'CONCLUIDA' : 'EN CURSO';
            $total_percent = ($percent_form_step3 == 100 && $percent_form_step4 == 100 && $percent_form_step5 == 100) ? 100 : 40;
        }
        $data_lbl = array(
            'Recopilación de información' => $status_step1,
            'Características del crédito' => $status_step2,
            'Captura de información' => $status_step3,
        );
        return array('lbl' => $data_lbl, 'total_percent' => $total_percent);
    }

    //listado de etapas
    public function listStep($history_id)
    {

        $history = HistoryLog::find($history_id);

        $credit   = $history->historyCredit;
        $product  = FinancialProduct::find($credit->applied_financial_product);
        $max_hour = 12;
        $hour     = $credit->created_at;

        $percentStep1 = reduceDecimal(self::percentUpload($credit->id));
        $percentStep2 = null;                                             // etapa 2


        $statusStep1 = 'En espera';
        $statusStep2 = 'En espera';
        

        $statusStep1 = ($percentStep1 >= 100) ? 'Concluido' : 'En curso';
        //TODO: change validation when the decision action is carried out in the report
        if ($statusStep1 == 'Concluido') {
            $statusStep2 = ($percentStep2 >= 100) ? 'Concluido' : 'En curso';
        }

        

        $data = array();
        
        
        if ($product!= null && $product->type_product_id != 3) {
            $data[] = array(
                'nameStep' => 'Documentos',
                'status' => $statusStep1,
                'link' => '',
                'percent' => self::calculateStepAverage($history_id, 1),
            );

            $data[] = array(
                'nameStep' => 'Captura info',
                'status' => $statusStep2,
                'link' => '',
                'percent' => self::calculateStepAverage($history_id, 2),
            );
          
            $data[] = array(
                
                'nameStep' => 'KYC/MDC',
                'status' => $statusStep2,
                'link' => '',
                'percent' => self::calculateStepAverage($history_id, 3),
            );
            $data[] = array(
            
                'nameStep' => 'Firmas',
                'status' => $statusStep2,
                'link' => '',
                'percent' => self::calculateStepAverage($history_id, 5),
            );
            
        } elseif ($product!= null && $product->type_product_id == 3) {
            
            $data[] = array(
            
                'nameStep' => 'Firmas',
                'status' => $statusStep2,
                'link' => '',
                'percent' => self::calculateStepAverage($history_id, 5),
            );

            $data[] = array(
                
                'nameStep' => 'KYC/MDC',
                'status' => $statusStep2,
                'link' => '',
                'percent' => self::calculateStepAverage($history_id, 4),
            );
        }
       

       
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
            return self::listTasksStep2($history_id);
        } elseif ($step == 3) {
            return self::listTasksStep3($history_id);
        } elseif ($step == 4) {
            return self::actionStep4($history_id);
        } elseif ($step == 5) {
            return self::actionStep5($history_id);
        }
        return self::listTasksStep1($history_id);
    }
    
    public function listActionByStep($history_id, $step)
    {
        $history = HistoryLog::find($history_id);
        $credit   = $history->historyCredit;
        $product  = FinancialProduct::find($credit->applied_financial_product);
        if ($product->type_product_id != 3) {
            
            if ($step == 2) {
                try {
                    return self::listTasksStep2($history_id);
                } catch (\Exception $e) {
                    return null;
                }
            } elseif ($step == 3) {
                try {
                    return self::listTasksStep3($history_id);
                   
                } catch (\Exception $e) {
                    return null;
                }
            } elseif ($step == 4) {
                try {
                    return self::listTasksStep4($history_id);
                } catch (\Exception $e) {
                    return null;
                }
            } elseif ($step == 5) {
                try {
                    return null;
                    return self::actionStep5($history_id);
                } catch (\Exception $e) {
                    return null;
                }
            } elseif ($step == 1) {
                return self::listTasksStep1($history_id);
            }
        } else {
            if ($step == 1) {
                return self::listTasksStep4($history_id);
            }
            return self::listTasksStep3($history_id);
        }

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

    public function dinamicDeadline($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percents                     = array(
            HistoryLog::KC_CONTROL_DESK_TASK1_STEP1 => self::percentUpload($credit->id),
            HistoryLog::KC_CONTROL_DESK_TASK2_STEP1 => self::percent($history),
            HistoryLog::KC_CONTROL_DESK_TASK3_STEP1 => self::percentTask1Step2($history),
            HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1 => self::percentUpload($credit->id, 3),
            HistoryLog::KC_CONTROL_DESK_TASK1_STEP2 => self::percentFormStep3_1($history),
            HistoryLog::KC_CONTROL_DESK_TASK2_STEP2 => self::percentFormStep3_2($history),
            HistoryLog::KC_CONTROL_DESK_TASK3_STEP2 => self::percentFormStep4($history),
            HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2 => self::percentFormStep5($history),
        );
        $hours = array(
            HistoryLog::KC_CONTROL_DESK_TASK1_STEP1 => self::HOUR_STEP_1,
            HistoryLog::KC_CONTROL_DESK_TASK2_STEP1 => self::HOUR_STEP_1,
            HistoryLog::KC_CONTROL_DESK_TASK3_STEP1 => self::HOUR_STEP_2,
            HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1 => self::HOUR_STEP_3,
            HistoryLog::KC_CONTROL_DESK_TASK1_STEP2 => self::HOUR_STEP_3,
            HistoryLog::KC_CONTROL_DESK_TASK2_STEP2 => self::HOUR_STEP_3,
            HistoryLog::KC_CONTROL_DESK_TASK3_STEP2 => self::HOUR_STEP_4,
            HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2 => self::HOUR_STEP_5,
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
            HistoryLog::KC_CONTROL_DESK_TASK1_STEP1 => $option_step1,
            HistoryLog::KC_CONTROL_DESK_TASK2_STEP1 => $option_step1_2,
            HistoryLog::KC_CONTROL_DESK_TASK3_STEP1 => $option_step2,
            HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1 => $option_step3,
            HistoryLog::KC_CONTROL_DESK_TASK1_STEP2 => $option_step3_1,
            HistoryLog::KC_CONTROL_DESK_TASK2_STEP2 => $option_step3_2,
            HistoryLog::KC_CONTROL_DESK_TASK3_STEP2 => $option_step4,
            HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2 => $option_step5,
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
        $percent_form                 = self::percentUpload($credit->id);

        if ($percent_form == 100) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK1_STEP1, $credit->id, 1);
        }
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_TASK1_STEP1], $credit->id)[0];
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
        $percent_form       = self::percent($history);
        $credit             = $history->historyCredit;


        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_TASK2_STEP1], $credit->id)[0];
        $hour                         = $in_progress->date_status_progress;
        $max_hour                     = self::HOUR_STEP_1;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function getPercentStep1($history)
    {

    }

    public function listTasksStep1($history_id, $step_origin = null)
    {
        
        return self::ElementsTaskStep1($history_id, $step_origin);
        
    }

    //tareas dinamicas paso 1
    public function ElementsTaskStep1($history_id, $step_origin = null)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percentages    = [
            1 => self::percentUpload($credit->id),
            2 => self::percentUpload($credit->id, 2),
            3 => self::percentUpload($credit->id, 3)
        ];
        $helpText    = [
            1 => 'Adjunta la parte delantera de la INE',
            2 => 'Adjunta la parte trasera de la INE',
            3 => 'Adjunta el último recibo de nómina'
        ];
       

        $name_advisor = null;
        try {
            $user = User::find($advisor->id);
            $role = isset(User::$alias_role[$user->getRoleNames()[0]]) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor = $advisor->id == Auth::user()->id ? 'Tú' : $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        } catch (\Exception $th) {
            // No advisor data available.
        }

        $menu_options   = self::menuOptions($history, 1, $step_origin);
        $view_dead_line_upload  = self::deadLineUploadStep1($history);
        $view_dead_line_form    = self::deadLineStep1($history);

        $data = [];
        $subjects = [
            1 => HistoryLog::$label_subject[22],
            2 => HistoryLog::$label_subject[23],
            3 => HistoryLog::$label_subject[24]
        ];

        $statuses = [];
        $currentTaskInProgress = false;

        // Define statuses for fixed tasks (1-3)
        foreach ($percentages as $index => $percent) {
            $statuses[$index] = $currentTaskInProgress ? 'null' : ($percent >= 100 ? 'Concluido' : 'En curso');
            if ($statuses[$index] === 'En curso') {
                $currentTaskInProgress = true;
            }
        }

        for ($i = 1; $i <= 3; $i++) {
            
            $data[] = [
                'name' => "{$i}- " . ($i === 1 ? 'Anverso INE' : ($i === 2 ? 'Reverso INE' : 'Última nómina')),
                'subject' => $subjects[$i],
                'helpText' => $helpText[$i],
                'status' => $statuses[$i],
                'statusBadge' => $statuses[$i] === 'null' ? null : \View::make('panel.module.status', ['status' => $statuses[$i]])->render(),
                'deadline' => $i === 1 ? $view_dead_line_upload : $view_dead_line_form,
                'advisor' => $name_advisor,
                'link' => "/panel/action-form/controlDesk/{$history_id}/form?step={$i}&step_origin=null"
            ];
        }

        // Handle dynamic tasks
        $CreditPayOff = CreditPayOff::select('financial_products.name')
            ->join('financial_products', 'financial_products.id', 'credit_pay_off.financial_product_id')
            ->where(['new_kc_credit_id' => $credit->id])
            ->get();
        
        $dynamicIndex = 4;
        foreach ($CreditPayOff as $creditPayOff) {
            $dynamicPercent = self::percentUpload($credit->id, $dynamicIndex);
            $dynamicStatus = $currentTaskInProgress ? 'null' : ($dynamicPercent >= 100 ? 'Concluido' : 'En curso');
            if ($dynamicStatus === 'En curso') {
                $currentTaskInProgress = true;
            }

            $data[] = [
                'name' => "{$dynamicIndex}- Cotización {$creditPayOff->name}",
                'subject' => " ".$creditPayOff->name,
                'helpText' => 'Adjunta el documento '. $creditPayOff->name,
                'status' => $dynamicStatus,
                'statusBadge' => $dynamicStatus === 'null' ? null : \View::make('panel.module.status', ['status' => $dynamicStatus])->render(),
                'deadline' => $view_dead_line_form,
                'advisor' => $name_advisor,
                'link' => "/panel/action-form/controlDesk/{$history_id}/form?step={$dynamicIndex}&step_origin=null"
            ];

            $dynamicIndex++;
        }

        return $data;
    }

    public function listTasksStep2($history_id, $step_origin = null)
    {
        
        return self::ElementsTaskStep2($history_id, $step_origin);
        

    }

    public function ElementsTaskStep2($history_id, $step_origin = null)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        
        $percentages    = [
            1 => self::percentTask1Step2($history),
            2 => self::percentTask2Step2($history),
            3 => self::percentTask3Step2($history)
        ];
        
       

        $name_advisor = null;
        try {
            $user = User::find($advisor->id);
            $role = isset(User::$alias_role[$user->getRoleNames()[0]]) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor = $advisor->id == Auth::user()->id ? 'Tú' : $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        } catch (\Exception $th) {
            // No advisor data available.
        }

        $menu_options   = self::menuOptions($history, 1, $step_origin);
        $view_dead_line_upload  = self::deadLineUploadStep1($history);
        $view_dead_line_form    = self::deadLineStep1($history);

        $data = [];
        $subjects = [
            1 => HistoryLog::$label_subject[26],
            2 => HistoryLog::$label_subject[27],
            3 => HistoryLog::$label_subject[28]
        ];

        $statuses = [];
        $currentTaskInProgress = false;

        // Define statuses for fixed tasks (1-3)
        foreach ($percentages as $index => $percent) {
            $statuses[$index] = $currentTaskInProgress ? 'null' : ($percent >= 100 ? 'Concluido' : 'En curso');
            if ($statuses[$index] === 'En curso') {
                $currentTaskInProgress = true;
            }
        }

        for ($i = 1; $i <= 3; $i++) {
            
            $data[] = [
                'name' => $i.'- '. $subjects[$i],
                'subject' => ' '.$subjects[$i],
                'helpText' => null,
                'status' => $statuses[$i],
                'statusBadge' => $statuses[$i] === 'null' ? null : \View::make('panel.module.status', ['status' => $statuses[$i]])->render(),
                'deadline' => $i === 1 ? $view_dead_line_upload : $view_dead_line_form,
                'advisor' => $name_advisor,
                'link' => "/panel/action-form/controlDesk/{$history_id}/form?step=2_{$i}&step_origin=null",
                'id' => null
            ];
        }

        // Handle dynamic tasks
        $CreditPayOff = CreditPayOff::select('credit_pay_off.id', 'financial_products.name')
            ->join('financial_products', 'financial_products.id', 'credit_pay_off.financial_product_id')
            ->where(['new_kc_credit_id' => $credit->id])
            ->get();
        
        $dynamicIndex = 4;
        foreach ($CreditPayOff as $creditPayOff) {
            
            $dynamicPercent = self::DynamicPercentStep2($creditPayOff->id);
            
            $dynamicStatus = $currentTaskInProgress ? 'null' : ($dynamicPercent >= 100 ? 'Concluido' : 'En curso');
            if ($dynamicStatus === 'En curso') {
                $currentTaskInProgress = true;
            }

            $data[] = [
                'name' => "{$dynamicIndex}- Capturar {$creditPayOff->name}",
                'subject' => " ".$creditPayOff->name,
                'helpText' => null,
                'status' => $dynamicStatus,
                'statusBadge' => $dynamicStatus === 'null' ? null : \View::make('panel.module.status', ['status' => $dynamicStatus])->render(),
                'deadline' => $view_dead_line_form,
                'advisor' => $name_advisor,
                'link' => "/panel/action-form/controlDesk/{$history_id}/form?step=2_{$dynamicIndex}&step_origin=null",
                'id' => $creditPayOff->id
            ];

            $dynamicIndex++;
        }

        return $data;
    }

    public function percentTask1Step2($history)
    {
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $fields = ['ID_primer_apellido', 'ID_segundo_apellido', 'ID_nombres', 'ID_vigencia'];
        
        if ($client === null) {
            return 0; // Si no hay cliente, el porcentaje es 0.
        }
    
        // Contar los campos no nulos.
        $elements = count(array_filter($fields, fn($field) => !empty($client->$field)));
    
        // Calcular el porcentaje completado.
        $total = count($fields);
        $percent = ($elements / $total) * 100;
    
        return $percent;
    }

    public function listTasksStep3($history_id, $step_origin = null)
    {
        return self::ElementsTaskStep3($history_id, $step_origin);

        
    }

    public function ElementsTaskStep3($history_id, $step_origin = null)
    {
        $history = HistoryLog::find($history_id);
        $credit  = $history->historyCredit;
        $product = FinancialProduct::find($credit->applied_financial_product);
        $advisor = $credit->creditAdvisor;
       

        $name_advisor = null;
        try {
            $user = User::find($advisor->id);
            $role = isset(User::$alias_role[$user->getRoleNames()[0]]) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor = $advisor->id == Auth::user()->id ? 'Tú' : $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        } catch (\Exception $th) {
            // No advisor data available.
        }

        $menu_options   = self::menuOptions($history, 1, $step_origin);
        $view_dead_line_upload  = self::deadLineUploadStep1($history);
        $view_dead_line_form    = self::deadLineStep1($history);

        $data = [];
        if ($product->type_product_id != 3) {
            
            $percentages = [];
            $subjects = [];
            $idForm = [];
            $total = 5; // Recorrerá desde 1 hasta 5
            $contI = 1; // Índice inicial
        
            $percentages    = [
                1 => self::DynamicPercentStep3($credit->id, CreditsControlDesk::$labelValidate[1]),
                2 => self::DynamicPercentStep3($credit->id,  CreditsControlDesk::$labelValidate[2]),
                3 =>  self::DynamicPercentStep3($credit->id, CreditsControlDesk::$labelValidate[3]),
                4 =>  self::DynamicPercentStep3($credit->id, CreditsControlDesk::$labelValidate[4]),
                5 =>  self::DynamicPercentStep3($credit->id, CreditsControlDesk::$labelValidate[5]),
            ];
            $subjects = [
                1 => HistoryLog::$label_subject[HistoryLog::KC_CONTROL_DESK_TASK1_STEP3],
                2 => HistoryLog::$label_subject[HistoryLog::KC_CONTROL_DESK_TASK2_STEP3],
                3 => HistoryLog::$label_subject[HistoryLog::KC_CONTROL_DESK_TASK3_STEP3],
                4 => HistoryLog::$label_subject[HistoryLog::KC_CONTROL_DESK_TASK4_STEP3],
                5 => HistoryLog::$label_subject[HistoryLog::KC_CONTROL_DESK_TASK5_STEP3],
            ];
            $idForm = [
                1 => HistoryLog::KC_CONTROL_DESK_TASK1_STEP3,
                2 => HistoryLog::KC_CONTROL_DESK_TASK2_STEP3,
                3 => HistoryLog::KC_CONTROL_DESK_TASK3_STEP3,
                4 => HistoryLog::KC_CONTROL_DESK_TASK4_STEP3,
                5 => HistoryLog::KC_CONTROL_DESK_TASK5_STEP3,
            ];
        } else {
            $percentages = [
                5 => self::DynamicPercentStep3($credit->id, CreditsControlDesk::$labelValidate[5]),
            ];
            $subjects = [
                5 => HistoryLog::$label_subject[HistoryLog::KC_CONTROL_DESK_TASK5_STEP3],
            ];
            $idForm = [
                5 => HistoryLog::KC_CONTROL_DESK_TASK5_STEP3,
            ];
            $total = 5; // Recorrerá solo el índice 5
            $contI = 5; // Índice inicial y único
        }
        

        $statuses = [];
        $currentTaskInProgress = false;

        // Define statuses for fixed tasks (1-3)
        foreach ($percentages as $index => $percent) {
            $statuses[$index] = $currentTaskInProgress ? 'null' : ($percent >= 100 ? 'Concluido' : 'En curso');
            if ($statuses[$index] === 'En curso') {
                $currentTaskInProgress = true;
            }
        }

        //volver dinamico el barrido es o no ondemand
        $data = [];
        for ($i = $contI; $i <= $total; $i++) {
            $data[] = [
                'name' => $i . '- ' . $subjects[$i],
                'subject' => ' ' . $subjects[$i],
                'alias' => null,
                'helpText' => null,
                'status' => $statuses[$i] ?? null,
                'idForm' => $idForm[$i],
                'nameField' => Str::slug(CreditsControlDesk::$labelValidate[$i]),
                'statusBadge' => ($statuses[$i] ?? null) === 'null' ? null : \View::make('panel.module.status', ['status' => $statuses[$i]])->render(),
                'deadline' => $i === 1 ? $view_dead_line_upload : $view_dead_line_form,
                'advisor' => $name_advisor,
                'link' => "/panel/action-form/controlDesk/{$history_id}/form?step=3_{$i}&step_origin=null",
                'id' => null,
            ];
        }

        //  dynamic tasks

        if ($product->type_product_id != 3) {
            $CreditPayOff = CreditPayOff::select('credit_pay_off.id', 'financial_products.name', 'financial_products.alias')
                ->join('financial_products', 'financial_products.id', 'credit_pay_off.financial_product_id')
                ->where(['new_kc_credit_id' => $credit->id])
                ->get();
            
            $dynamicIndex = 6;
            foreach ($CreditPayOff as $creditPayOff) {
                $alias = 'Validar clabe '.$creditPayOff->alias;
                $dynamicPercent = self::DynamicPercentStep3($credit->id, CreditsControlDesk::$labelValidate[6], 0, $alias);
                
                $dynamicStatus = $currentTaskInProgress ? 'null' : ($dynamicPercent >= 100 ? 'Concluido' : 'En curso');
                if ($dynamicStatus === 'En curso') {
                    $currentTaskInProgress = true;
                }
    
                $data[] = [
                    'name' => "{$dynamicIndex}- Validar clabe {$creditPayOff->name}",
                    'subject' => " ".$creditPayOff->name,
                    'alias' => $creditPayOff->alias,
                    'helpText' => null,
                    'status' => $dynamicStatus,
                    'idForm' => HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP3,
                    'nameField' => Str::slug(CreditsControlDesk::$labelValidate[6]),
                    'statusBadge' => $dynamicStatus === 'null' ? null : \View::make('panel.module.status', ['status' => $dynamicStatus])->render(),
                    'deadline' => $view_dead_line_form,
                    'advisor' => $name_advisor,
                    'link' => "/panel/action-form/controlDesk/{$history_id}/form?step=3_{$dynamicIndex}&step_origin=null",
                    'id' => $creditPayOff->id
                ];
    
                $dynamicIndex++;
            }
        }

        return $data;
    }
    
    
    public function percentTask1Step3($history)
    {
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $fields = ['payroll_date', 'payroll_total'];
        
        if ($client === null) {
            return 0; // Si no hay cliente, el porcentaje es 0.
        }
    
        // Contar los campos no nulos.
        $elements = count(array_filter($fields, fn($field) => !empty($client->$field)));
    
        // Calcular el porcentaje completado.
        $total = count($fields);
        $percent = ($elements / $total) * 100;
    
        return $percent;
    }
   
    public function percentTask2Step2($history)
    {
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $fields = ['ID_CIC', 'ID_IDC'];
        
        if ($client === null) {
            return 0; // Si no hay cliente, el porcentaje es 0.
        }
    
        // Contar los campos no nulos.
        $elements = count(array_filter($fields, fn($field) => !empty($client->$field)));
    
        // Calcular el porcentaje completado.
        $total = count($fields);
        $percent = ($elements / $total) * 100;
    
        return $percent;
    }
   
    public function percentTask3Step2($history)
    {
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $fields = ['payroll_date', 'payroll_total'];
        
        if ($client === null) {
            return 0; // Si no hay cliente, el porcentaje es 0.
        }
    
        // Contar los campos no nulos.
        $elements = count(array_filter($fields, fn($field) => !empty($credit->$field)));
    
        // Calcular el porcentaje completado.
        $total = count($fields);
        $percent = ($elements / $total) * 100;
    
        return $percent;
    }

    public function listTasksStep4($history_id, $step_origin = null)
    {
        return self::ElementsTaskStep4($history_id, $step_origin);
    }

    public function ElementsTaskStep4($history_id, $step_origin = null)
    {
        $history = HistoryLog::find($history_id);
        $credit  = $history->historyCredit;
        $advisor = $credit->creditAdvisor;
        $product = FinancialProduct::find($credit->applied_financial_product);

        if ($product->type_product_id != 3) {
            # code...
        } else {
            

        }
        
        $percentages    = [
            1 => self::percentTask1Step4($history_id),
            2 => self::percentTask2Step4($history_id),
           
        ];

        $name_advisor = null;
        try {
            $user = User::find($advisor->id);
            $role = isset(User::$alias_role[$user->getRoleNames()[0]]) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor = $advisor->id == Auth::user()->id ? 'Tú' : $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        } catch (\Exception $th) {
            // No advisor data available.
        }

        $menu_options   = self::menuOptions($history, 1, $step_origin);
        $view_dead_line_upload  = self::deadLineUploadStep1($history);
        $view_dead_line_form    = self::deadLineStep1($history);

        $data = [];
        $subjectfirmaContrato = $product->type_product_id != 3 ? HistoryLog::$label_subject[HistoryLog::KC_CONTROL_DESK_TASK2_STEP4] : 'Firma Solicitud/Descuento SOD';
        $subjects = [
            1 => HistoryLog::$label_subject[HistoryLog::KC_CONTROL_DESK_TASK1_STEP4],
            2 => $subjectfirmaContrato,
        ];
        $idForm = [
            1 => HistoryLog::KC_CONTROL_DESK_TASK1_STEP4,
            2 => HistoryLog::KC_CONTROL_DESK_TASK2_STEP4,
        ];

        $statuses = [];
        $currentTaskInProgress = false;

        // Define statuses for fixed tasks (1-3)
        foreach ($percentages as $index => $percent) {
            $statuses[$index] = $currentTaskInProgress ? 'null' : ($percent >= 100 ? 'Concluido' : 'En curso');
            if ($statuses[$index] === 'En curso') {
                $currentTaskInProgress = true;
            }
        }

        for ($i = 1; $i <= 2; $i++) {
            
            $data[] = [
                'name' => $i.'- '. $subjects[$i],
                'subject' => ' '.$subjects[$i],
                'alias' => null,
                'helpText' => null,
                'status' => $statuses[$i],
                'idForm' => $idForm[$i],
                'nameField' => Str::slug(CreditsControlDesk::$labelValidate[$i]),
                'statusBadge' => $statuses[$i] === 'null' ? null : \View::make('panel.module.status', ['status' => $statuses[$i]])->render(),
                'deadline' => $i === 1 ? $view_dead_line_upload : $view_dead_line_form,
                'advisor' => $name_advisor,
                'link' => "/panel/action-form/controlDesk/{$history_id}/form?step=4_{$i}&step_origin=null",
                'id' => null
            ];
        }

        

        return $data;
    }

    public function percentTask1Step4($history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $fields = ['cm_agreement_sign'];

        $creditsValidate = CreditsControlDesk::where([
            'validation' => CreditsControlDesk::$labelValidate[9],
            'credit_id' => $credit->id,
        ])->count();
        
        
    
        return $creditsValidate > 0 ? 100 : 0;
    }
    
    public function percentTask2Step4($history_id)
    {
        $history = HistoryLog::find($history_id);
        $credit = $history->historyCredit;
        $client = $credit->creditClientPerson;
        $product = FinancialProduct::find($credit->applied_financial_product);

        if ($product->type_product_id == 3) {
            $fields = ['sod_agreement'];
        } else {
            $fields = ['credit_agreement_signed'];
        }
        
        if ($credit === null) {
            return 0; // Si no hay cliente, el porcentaje es 0.
        }
        $getFile = CreditsControlDesk::where([
            'validation' => CreditsControlDesk::$labelValidate[9],
            'credit_id' => $credit->id,
            
        ])->count();
        
        // Contar los campos no nulos.
        $elements = count(array_filter($fields, function($field) use ($credit) {
            return isset($credit->$field) && ($credit->$field === 1 || $credit->$field === 0);
        }));
        // Calcular el porcentaje completado.
        $total = count($fields) + 1;
        $elements = $getFile > 0 ? $elements + 1 : $elements;  
        
        $percent = ($elements / $total) * 100;
    
        return $percent;
    }

    public function deadLineStep2($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentTask1Step2($history);
        $max_hour                     = self::HOUR_STEP_2;
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_TASK3_STEP1], $credit->id)[0];
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    

    public function deadLineUploadStep3($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_file   = self::percentUpload($credit->id, 3);

        if ($percent_file == 100) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1, $credit->id, 1);
        }
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1], $credit->id)[0];
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
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1], $credit->id)[0];
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
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_TASK2_STEP2], $credit->id)[0];
        $max_hour                     = self::HOUR_STEP_3;
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form1, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        return $view_dead_line_inf_credit;
    }


    

    public function deadLineStep4($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form1                = self::percentFormStep4($history);
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP1], $credit->id)[0];
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
        $name_advisor   = null;

        try {
            $user               = User::find($advisor->id);
            $role               = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor       = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
            if ($advisor->id == Auth::user()->id) {
                $name_advisor = 'Tú';
            }
        } catch (\Exception $th) {
            //throw $th;
        }

        $menu_options       = self::menuOptionsStep4($history, $step_origin);

        $form_option        = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        $view_dead_line1    = self::deadLineStep4($history);
        $percent            = self::percentFormStep4($history);

        $status = $percent == 100 ? 'Concluido' : 'En curso';

     

        $data = array();

        $subject1 = HistoryLog::$label_subject[28];

        $viewStatus1 = \View::make('panel.module.status', ['status' => $status])->render();

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' =>  $viewStatus1,
            'deadline' => $view_dead_line1,
            'advisor' => $name_advisor,
            'options' => $form_option,
            'link' => '/panel/action-form/controlDesk/'.$history_id.'/form?step=4&step_origin='
        );

        return $data;
    }

    public function deadLineFormStep5($history)
    {
        try {
            $credit         = $history->historyCredit;
            $color_inf_credit             = 'success';
            $percent_form                 = self::percentFormStep5($history);
            if ($percent_form == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, $credit->id, 1);
            }
            $max_hour                     = self::HOUR_STEP_5;
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2], $credit->id)[0];
            $hour                         = $in_progress->date_status_progress;
            
            $hour                         = $history->created_at;
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];
            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            return $view_dead_line_inf_credit;
            } catch (\Exception $th) {
            
            }
            return null;
        }

    public function deadLineFormStep5_2($history)
    {
        try {
            $credit         = $history->historyCredit;
            $color_inf_credit             = 'success';
            $percent_form                 = self::percentFormStep5_2($history);
            $max_hour                     = self::HOUR_STEP_5_2;
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_TASK1_STEP3], $credit->id)[0];
            $hour                         = $in_progress->date_status_progress;
            $hour                         = $history->created_at;
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];
            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            return $view_dead_line_inf_credit;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return null;
    }
    
    public function deadLineUploadStep5_3($history)
    {
        try {
            $credit         = $history->historyCredit;
            $color_inf_credit             = 'success';
            $percent_form                 = self::percentFormStep5_3($credit->id, '5_3');
            if ($percent_form == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, $credit->id, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP3, $credit->id, 1);
            }
            $max_hour                     = self::HOUR_STEP_5_3;
            $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_CONTROL_DESK_TASK2_STEP3], $credit->id)[0];
            $hour                         = $in_progress->date_status_progress;
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];
            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            return $view_dead_line_inf_credit;
        } catch (\Exception $th) {
            //throw $th;
        }
        return null;
    }

    public function finish($creditId, $step)
    {
        $credit = Credit::find($creditId);
        $percent_form =  self::percentFormStep5_3($creditId, $step);
        
        if ($step == '5_3' && $percent_form == 100) {
            
            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_DYNAMIC_TASK_STEP2, $credit->id, 1);
            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK1_STEP3, $credit->id, 1);
            HistoryLog::updateStatusProgress(HistoryLog::KC_CONTROL_DESK_TASK2_STEP3, $credit->id, 1);
            
            

            $notification_add   = SendNotificationsValues::STRATEGY['pushCreditKcDelivery'];
            (new $notification_add)->send($credit->id);

        }
        
    }

    public function actionStep5($history_id, $step_origin = null)
    {

        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $name_advisor   = null;

        try {
            $user                 = User::find($advisor->id);
            $role                 = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor         = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
            if ($advisor->id == Auth::user()->id) {
                $name_advisor = 'Tú';
            }
        } catch (\Exception $th) {
            //throw $th;
        }

        $menu_options         = self::menuOptionsStep5($history, $step_origin);

        $percent_form_2         = self::percentFormStep5($history);
        $percent_form_2_2       = self::percentFormStep5_2($history);
        $percent_form_2_3       = self::percentFormStep5_3($credit->id, '5_3');

        $status_step5           = ($percent_form_2 >= 100) ? 'Concluido' : 'En curso';
        $status_step5_2         = ($percent_form_2_2 >= 100) ? 'Concluido' : 'En curso';
        $status_step5_3         = ($percent_form_2_3 >= 100) ? 'Concluido' : 'En curso';

        $view_dead_line_step5   = self::deadLineFormStep5($history);
        $view_dead_line_step5_2   = self::deadLineFormStep5_2($history);
        $view_dead_line_step5_3   = self::deadLineUploadStep5_3($history);

        $option1  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        $option2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form2']])->render();
        $option3  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();

        $viewStatus1= \View::make('panel.module.status', ['status' => $status_step5])->render();
        $viewStatus2= \View::make('panel.module.status', ['status' => $status_step5_2])->render();
        $viewStatus3= \View::make('panel.module.status', ['status' => $status_step5_3])->render();

        $data = array();

        $subject1 = HistoryLog::$label_subject[57];
        $subject2 = HistoryLog::$label_subject[58];
        $subject3 = HistoryLog::$label_subject[59];

        
        $data[] = array(
            'name' => 'Firma',
            'subject' => $subject1,
            'description' => 'Preparar documento',
            'status' => $viewStatus1,
            'deadline' => $view_dead_line_step5,
            'advisor' => $name_advisor,
            'options' => $option1,
            'link' =>  '/panel/action-form/controlDesk/'.$history_id.'/form?step=5',
        );
        $data[] = array(
            'name' => 'Firma',
            'subject' => $subject2,
            'description' => 'Confirmar',
            'status' => $viewStatus2,
            'deadline' => $view_dead_line_step5_2,
            'advisor' => $name_advisor,
            'options' => $option2,
            'link' =>  '/panel/action-form/controlDesk/'.$history_id.'/form?step=5_2',
        );
        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject3,
            'description' => 'Documento firmado',
            'status' => $viewStatus3,
            'deadline' => $view_dead_line_step5_3,
            'advisor' => $name_advisor,
            'options' => $option3,
            'link' =>  '/panel/template/action-document/controlDesk/'.$history_id.'?step=5_3',
        );

        return $data;
    }

    public function listStepReport($history_id)
    {
        $history                = HistoryLog::find($history_id);
        $credit                 = $history->historyCredit;
        $max_hour               = 12;
        $hour                   = $credit->created_at;
        $menu_options           = self::menuOptionReportStep($history);
        $advisor                = $credit->creditAdvisor;
        $name_advisor           = null;
        $name_module_response   = 'KaaxClub';
        
        try {
            $user = User::find($advisor->id);
            $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        } catch (\Exception $th) {
            //throw $th;
        }

        $color_desition   = 'success';

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
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=' . $step . '&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/template/action-document/controlDesk/' . $history->id . '?step=' . $step . '&step_origin=' . $step_origin,
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
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=3_1' . '&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=3_2' . '&step_origin=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/template/action-document/controlDesk/' . $history->id . '?step=3' . '&step_origin=' . $step_origin,
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
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=4' . '&step_origin=' . $step_origin,
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
            'file' => array(
                [
                    'link' => '/panel/template/action-document/controlDesk/' . $history->id . '?step=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

                ),
            'form' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step=' . $step_origin,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/action-form/controlDesk/' . $history->id . '/form?step='.$step_origin,
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
        $lbl_action = $type_lbl === 1 ? 'Lista de tareas' : 'Ver tareas';
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

    //TODO: BORRAR!!
    public function percent($history)
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

   

    public function percentFormStep3_1($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $total_valid = 0;
        if ($client != null && $client->sex != '') {
            $total_valid = $total_valid + 1;
        }
        if ($client != null && $client->rfc != null) {
            $total_valid = $total_valid + 1;
        }

        
        if ($client != null && $client->bank_name != null) {
            $total_valid = $total_valid + 1;
        }


        if ($client != null && $client->bank_clabe != null) {
            $total_valid = $total_valid + 1;
        }
        $percent =  ($total_valid / 4)  * 100;
        return reduceDecimal($percent);
    }

    public function percentFormStep3_2($history)
    {
        $percent = 0;
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $total_valid = 1;
        if ($credit != null && $credit->interviewer != '') {
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
            $total_valid = 1;
        }
        $percent =  ($total_valid / 1) * 100;
        return $percent;
    }

    public function percentFormStep5($history)
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

    public function percentFormStep5_2($history)
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
   
    public function percentFormStep5_3($id_rel, $step = null)
    {
        $model        = File::MODEL['controlDesk'];
        $count_file   = 0;
        $percent_file = 0;
        $config_files = self::configUpload($step);
        $total        = 0;
        //dd($config_files);
        foreach ($config_files as $key => $config_file) {
            $file = File::where([
                'model' => $model,
                'id_rel' => $id_rel,
                'template_config_id' => $key,
            ])
                ->first();
            //dd($model, $id_rel, $key, $file);
            if ($config_file['is_required'] == true) {
                $total = $total + 1;
            }
            if ($file != null && $config_file['is_required'] == true) {
                $count_file = $count_file + 1;
                $percent_file = $percent_file + 100;
            }
        }
        return ($count_file  )/ $total * 100;
    }

    public static function calculateStepAverage($historyId, $step)
    {
        $history     = HistoryLog::find($historyId);
        $credit      = Credit::find($history->id_rel);
        $financialProduct = FinancialProduct::find($credit->applied_financial_product);

        if ($financialProduct->type_product_id == 3) {
            if ($step == 1) {
                $step = 4;
            }
            
            if ($step == 2) {
                $step = 3;
            }
        }
        
        // Construir el nombre de la función dinámicamente
        $functionName = "ElementsTaskStep" . $step;
        
        // Verificar que la función exista
        if (!method_exists(self::class, $functionName)) {
            return 0; // Evitar errores si la función no existe
        }

        // Llamar a la función dinámica y obtener los elementos
        $elements = self::$functionName($historyId);

        // Filtrar los elementos con status "Concluido"
        $concluidos = array_filter($elements, function($element) {
            return isset($element['status']) && $element['status'] === 'Concluido';
        });

        // Calcular el promedio de esta tarea
        $totalElements = count($elements);
        $totalConcluidos = count($concluidos);
        
        return $totalElements > 0 ? ($totalConcluidos / $totalElements) * 100 : 0;
    }

    //* get all percentages of the shares
    public function getPercent($history, $show_current_show = false)
    {
        $credit  = $history->historyCredit;
        $product  = FinancialProduct::find($credit->applied_financial_product);

        if ($product->type_product_id != 3) {
            
            $totalSteps = 4; // Número total de tareas
            $totalAverage = 0;
    
            // Iterar sobre las tareas (1 a 4) y sumar los promedios
            for ($step = 1; $step <= $totalSteps; $step++) {
                $averageStep = self::calculateStepAverage($history->id, $step);
                $totalAverage += $averageStep;
            }
    
            // Calcular el promedio general
            return $totalSteps > 0 ? $totalAverage / $totalSteps : 0;
        } else {
            $averageStep1 = self::calculateStepAverage($history->id, 3);
            $averageStep2 = self::calculateStepAverage($history->id, 4);
            $totalAverage = $averageStep1 + $averageStep2;
            return 2 > 0 ? $totalAverage / 2 : 0;
        
        }
        
    }
    
    public function isFinish($history)
    {
        $statusAllTrue = CreditsControlDesk::where('credit_id', $history->id_rel)
                        ->get()
                        ->every(function ($credit) {
                            return $credit->status === 1;
                        });
        $creditControl = CreditsControlDesk::where('validation', 'Fondos suficientes')->where('credit_id', $history->id_rel)->first();
        //agregar validacion otorgar vobo
        $credit = Credit::find($history->id_rel);
        $agreement = $credit->creditAgreement;
        $productName = $credit ? $credit->getProduct() : null;
        if(($productName == 'Soluciona tu deuda' || $productName == 'Crédito personal') && 
            $agreement && $agreement->auto_go_ahead === 0 && $credit->go_ahead != 2)
        {
            return false;
        }
        
        return  $creditControl != null  && $creditControl->status == 1 && $statusAllTrue  ? true : false;
    }

    public function getFile($template_config_id, $creditId = null,  $step = null)
    {
        // Priorizar retornos directos para pasos específicos
        if ($step === '3_3') {
            return ['name' => 'Evidencia CP'];
        }
        if ($step === '3_5') {
            return ['name' => 'CEP'];
        }

        /* $taks = self::ElementsTaskStep1($history_id, null);
        $templateId = $step -1;
        $task = $taks[$templateId];
        $task['subject'] */
        
        if ($step == 1) {
            $elements = array(
                1 => [
                    'name' => 'Anverso INE',
                ],
                2 => [
                    'name' => 'Reverso INE',
                ],
                3 => [
                    'name' => 'Última nómina',
                ],
    
            );
            $CreditPayOffs = CreditPayOff::select('credit_pay_off.id', 'financial_products.name')
            ->join('financial_products', 'financial_products.id', 'credit_pay_off.financial_product_id')
            ->where(['new_kc_credit_id' => $creditId])
            ->get();
            $dynamicIndex = 3;
            foreach ($CreditPayOffs as $CreditPayOff) {
                $dynamicIndex = $dynamicIndex + 1;
                $elements[$dynamicIndex] = array(
                    'name' => "{$CreditPayOff->name}",
                );
            }
            /* $dynamicIndex = 4;
            'name' => "{$dynamicIndex}- Capturar {$creditPayOff->name}", */
        } else {
            $elements = array(
                1 => [
                    'name' => 'Contrato firmado',
                ],
                // Asegura que el template_config_id 4 (usado cuando step=4) también devuelva "Contrato firmado"
                4 => [
                    'name' => 'Contrato firmado',
                ],
            );
        }

        $config = null;
        // Selecciona configuración si existe; en caso contrario, aplica fallback para pasos distintos a 1
        if (isset($elements[$template_config_id])) {
            $config = $elements[$template_config_id];
        } else {
            // Fallback: cuando el paso es distinto a 1, devolver "Contrato firmado"
            if ($step != 1) {
                $config = ['name' => 'Contrato firmado'];
            }
        }
       

        return $config;
    }

    //*TODO: se deshabilito al ser opcional la caja de carga
    public function percentTask1Step1($id_rel, $step = null)
    {
        $model = File::MODEL['controlDesk'];
        $percent = 0;


        $getFile = File::where([
            'model' => $model,
            'id_rel' => $id_rel,
            'template_config_id' => 1,
        ])->count();

        //$percent =  (100 / 100) * $percent_file;
        
        $percent = $getFile > 0 ? 100 : 0;
        return $percent;
    }
    
    public function percentUpload($id_rel, $templateId = 1)
    {
        $model = File::MODEL['controlDesk'];
        $percent = 0;


        $getFile = File::where([
            'model' => $model,
            'id_rel' => $id_rel,
            'template_config_id' => $templateId,
        ])->count();
        
        //$percent =  (100 / 100) * $percent_file;
        
        $percent = $getFile > 0 ? 100 : 0;
        return $percent;
    }

    public function DynamicPercentStep2($creditPayOffId)
    {
        $payOff = CreditPayOff::find($creditPayOffId);
        $fields = ['deadline_date', 'ammount', 'bank_clabe'];
        
        if ($payOff === null) {
            return 0; // Si no hay cliente, el porcentaje es 0.
        }
    
        // Contar los campos no nulos.
        $elements = count(array_filter($fields, fn($field) => !empty($payOff->$field)));
    
        // Calcular el porcentaje completado.
        $total = count($fields);
        $percent = ($elements / $total) * 100;
    
        return $percent;
    }
    
    /**
     * $elements = sirve para saber si se valida que exista al menos 1 elemento o en algunos casos donde se necesite validar mas de 1 elemento como en el caso de Validar última nómina
     * $validate sirve para la etapa 3 en las tareas dinamicas para validar dinamicamente la etiqueta asignada con el producto
     */
    public function DynamicPercentStep3($creditId, $validation, $elements = 0, $validate = null)
    {
        $percent = 0;
        
        // Check if CEP exists first
        $cepExists = File::isExistCep($creditId);
        
        if ($validation == CreditsControlDesk::$labelValidate[1] || $validation == CreditsControlDesk::$labelValidate[2] || $validation == CreditsControlDesk::$labelValidate[4] || $validation == CreditsControlDesk::$labelValidate[5] || $validation == CreditsControlDesk::$labelValidate[6]) {

            if ($validation == CreditsControlDesk::$labelValidate[6]) {
                $validation = $validate;
            }
            $credits = CreditsControlDesk::where([
                'credit_id' => $creditId,
                'validation' => $validation,
            ]);
            
            $total = $credits->count();
            if($validation == CreditsControlDesk::$labelValidate[5])
            {
                $percent = ($total > $elements && $cepExists) ? 100 : 0;
            } else {
                $percent = ($total > $elements ) ? 100 : 0;
            }
            return $percent;
        } elseif ($validation == CreditsControlDesk::$labelValidate[3]) {
            $credit = Credit::find($creditId);
            $percent = ($credit->payroll_payment_capacity != null) ? 100 : 0 ;
        }
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
                'title' => 'KC - Control desk',
                'link' => '/panel/kc-control-desk',
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

    private function getTitles($history)
    {
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $task = null;

        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $task) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }
        if ($task == null) {
            $elements = self::ElementsTaskStep1($history->id);
            $totalTaks = count($elements);
            $titles = array();
            $step = isset($_GET['step']) ? $_GET['step'] : null;
            foreach ($elements as $key => $element) {
                $titles[$key + 1] = 'E1/4 - T'.$step.'-'.$totalTaks.$element['subject'];
            }
        }
        if ($step === 2) {
            
            $elements = self::ElementsTaskStep2($history->id);
            $totalTaks = count($elements);
            $titles = array();
            $step = isset($_GET['step']) ? $_GET['step'] : null;
            foreach ($elements as $key => $element) {
                $titles[$key + 1] = 'E2/4 - T'.$task.'-'.$totalTaks.$element['subject'];
            }
            
        }
        if ($step === 3) {
            
            $elements = self::ElementsTaskStep3($history->id);
            $totalTaks = count($elements);
            $titles = array();
            $step = isset($_GET['step']) ? $_GET['step'] : null;
            foreach ($elements as $key => $element) {
                $titles[$key + 1] = 'E3/4 - T'.$task.'-'.$totalTaks.$element['subject'];
            }
            
        }
        
        if ($step === 4) {
            
            $elements = self::ElementsTaskStep4($history->id);
            $totalTaks = count($elements);
            $titles = array();
            $step = isset($_GET['step']) ? $_GET['step'] : null;
            foreach ($elements as $key => $element) {
                $titles[$key + 1] = 'E4/4 - T'.$task.'-'.$totalTaks.$element['subject'];
            }
            
        }
        
      
        return $titles;
    }
   
    private function getTitlesFiles()
    {
        $titles = array(
            '1' => 'Docs Solicitante',
            '3' => 'Edo Cta',
        );
        return $titles;
    }

    public function optionBreadcumblistAction($history, $step)
    {
        $section = \Request::segment(2);
        $titles = $this->getTitles($history);
        $credit = Credit::find($history->id_rel);
        $title = $credit->id.' - '. $credit->client->name.' '.$credit->client->last_name.' '.$credit->client->second_last_name;
        $breadcumbs = array(
            0 => array(
                'title' => $title,
                'link' => '/panel/credit/'.$history->id_rel,
                'active' => null
            ),
           
        );
        
        /* if ($section == 'action-form') {
            $breadcumbs[4] = array(
                'title' => $titles[$step],
                'link' => null,
                'active' => true
            );
        } */
        return $breadcumbs;
    }

    public function breadcrumb($history, $type = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == null) {
            $breadcumbs = self::optionBreadcumbStep($history);
        }
        if ($step >= 1) {
            $breadcumbs = self::optionBreadcumblistAction($history, $step);
        }
        $view_breadcumb    = \View::make('panel.module.breadcumb', ['breadcumbs' => $breadcumbs])->render();
        return $view_breadcumb;
    }

    public function setTitle($history)
    {
        $stepParam = isset($_GET['step']) ? $_GET['step'] : null;

        $step = null;
        $task = null;

        if ($stepParam !== null) {
            if (strpos($stepParam, '_') !== false) {
                list($step, $task) = array_map('intval', explode('_', $stepParam));
            } else {
                $step = intval($stepParam);
            }
        }

        $titles = $this->getTitles($history);
        if ($task == null) {
            return isset($titles[$step]) ? $titles[$step] : 'Acción formulario';
        }
        if ($task != null) {
            return isset($titles[$task]) ? $titles[$task] : 'Acción formulario';
        }
    }
    
    public function setTitleDocument()
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        $titles = $this->getTitlesFiles();
        return isset($titles[$step]) ? 'Carga - '.$titles[$step] : 'Acción carga';
    }
    
}
