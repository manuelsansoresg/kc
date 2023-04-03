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

class PaymentStrategyTemplate implements TemplateInterface
{
    const HOUR_STEP_1  = 0;
    const HOUR_STEP_2  = 192;
    const HOUR_STEP_3  = 8;

    public function move($id)
    {
    }

    public function configUpload()
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == 3) {
            return self::uploadStep3();
        }
        return self::uploadStep2();
    }

    public function uploadStep2()
    {
        $elements = array(
            1 => [
                'name' => 'Comprobante de pago',
                'comment' => '',
                'is_required' => true,
                'is_date' => true,
                'max_size' => 2, //* size in MB
                'max_file' => 2,
                'type' => 'image/*, .pdf',
                'comment_date' => null
            ],

            
        );
        return $elements;
    }

    public function uploadstep3()
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
        } elseif ($step == '3') {
            return self::configFormstep3($id_rel, $history_id);
        } elseif ($step == '4') {
            return self::configFormstep4($id_rel, $history_id);
        }
    }

    public function configFormStep1($id_rel, $history_id)
    {
        $name_form    = 'frm-template_control_desk_step1';
        $type_form    = HistoryLog::KC_DELIVERY_FORM;
        $credit       = Credit::find($id_rel);
        $client_person = $credit->creditClientPerson;

        $elements = array(
            1 => [
                'title_section' => 'Entrega',
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
                'title' => 'Enviar email',
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'href',
                'link' => null,
                'onclick' => 'deliverysendEmail('.$history_id.')',
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'col' => 'col-12 col-md-4'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }


    public function configFormstep2($id_rel, $history_id)
    {
        $credit = Credit::find($id_rel);
        $name_form = 'frm-template_payment_step2';
        $type_form = HistoryLog::KC_DELIVERY_FORM_STEP_2;
        $financial = Financial::select('id', 'commercial_name as name')->get();
        $product = FinancialProduct::getProductByFinancial($credit->applied_financial);
        $loan_type = config('enums.loan_type');
        $sign_type = config('enums.sign_type');
        $periodicity = config('enums.periodicity');

        $elements = array(
            1 => [
                'title_section' => 'Cambios en la comisión',
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
                'title' => 'Nueva comisión',
                'name_field' => 'credit[changed_commission]',
                'id_field' => 'changed_commission',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            3 => [
                'title_section' => null,
                'title' => 'Comentario',
                'name_field' => 'credit[changed_commission_note]',
                'id_field' => 'changed_commission_note',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'textarea',
                'col' => 'col-12',
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
                'value' => '/panel/template/actions/payment/'.$history_id.'/show?step=2',
                'col' => 'col-12'
            ],
            
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }

    public function configFormstep3($id_rel, $history_id)
    {
        $name_form    = 'frm-template_payment_step3';
        $type_form    = HistoryLog::KC_DELIVERY_FORM_STEP_3;
        $option_payment    = array(1 => 'Sí', 2 => 'No');

        $elements = array(
            1 => [
                'title_section' => 'Verificar pago',
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
                'title' => 'Comprobar pago',
                'name_field' => 'credit[payment_check]',
                'id_field' => 'payment_check',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $option_payment,
                'col' =>  'col-12 col-md-6',
                'is_required' => true,
                'is_disabled' => null
            ],
            
            3 => [
                'title_section' => null,
                'title' => 'Comentario',
                'name_field' => 'credit[payment_check_note]',
                'id_field' => 'payment_check_note',
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
                'value' => '/panel/credit/product/35',
                'col' => 'col-12'
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
            
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
        return $list;
    }
    
    //when save comprobante pago
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
            $percent_form_step3 = self::percentFormStep2($history);
            if ($percent_form_step3 == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT_FORM_STEP_2, $credit->id, 1);

                HistoryLog::move($credit->id, HistoryLog::KC_PAYMENT_PAID_ARCHIVE, $history->old_status_id);
                HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT_PAID_ARCHIVE, $credit->id, 0);
                /* $notification_add   = SendNotificationsValues::STRATEGY['pushCreditKcDelivery'];
                (new $notification_add)->send($credit->id); */
            }
        }
    }

    public function listStep($history_id)
    {
        $history              = HistoryLog::find($history_id);

        $credit               = $history->historyCredit;
        $max_hour             = 12;
        $hour                 = $credit->created_at;
        
        $percent_file_step1   = self::percentFile($credit->id);
        $percent_form_2         = self::percentFormStep2($history);

        $color_inf_credit     = 'success';
        $option_step1         = null;
        $option_step2         = null;
        
        //$percent_form = $percent_form;
        $menu_options         = self::menuOptionsStep($history);
        $status_step1         = 'En espera';
        $status_step2         = 'En espera';

        //TODO: change validation when the decision action is carried out in the report
        if ($percent_file_step1 == 100) {
            $status_step2 = ($percent_file_step1 >= 100) ? 'Concluido' : 'En curso';
            $status_step1               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();
        }
        
        if ($percent_form_2 == 100) {
            $status_step2 = ($percent_form_2 >= 100) ? 'Concluido' : 'En curso';
            $option_step2               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep2']])->render();
        }

        $option_step1               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();
        
        $view_percent_step1         = \View::make('panel.module.view_percent', ['percent' => $percent_file_step1])->render();
        $view_percent_step2         = \View::make('panel.module.view_percent', ['percent' => $percent_form_2])->render();

        $view_count_step1           = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_count_step2           = \View::make('panel.module.view_count', ['number' => 'Dos'])->render();


        $data = array();
        $data[] = array(
            'name' => $view_count_step1,
            'step' => 'Comprobar pago',
            'status' => $status_step2,
            'progress' => $view_percent_step1,
            'deadline' => '',
            'options' => $option_step1,
        );
       
        $data[] = array(
            'name' => $view_count_step2,
            'step' => 'Verificar pago',
            'status' => $status_step2,
            'progress' => $view_percent_step2,
            'deadline' => '',
            'options' => $option_step2,
        );

        /* if ($percent_form == 100) {
            $data[] = array(
                'name' => $view_count_step4,
                'step' => 'Captura de información',
                'status' => $status_step3,
                'progress' => $view_percent_step3,
                'deadline' => '',
                'options' => null,
            );
        } */
       
        return $data;
    }

    public function moduleDeadline($history)
    {
        $max_hour           = 200;
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
        }
        return self::actionStep1($history_id);
    }

    public function percentForm($history)
    {
        $credit                       = $history->historyCredit;
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_PAYMENT_FORM_STEP_1], $credit->id)[0];
        $percent_form                 = $in_progress->status_progress == 1 ? 100 : 0;
        return $percent_form;
    }
    
    public function deadLineStep1($history)
    {
        $color_inf_credit             = 'success';
        $credit                       = $history->historyCredit;
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_DELIVERY_FORM], $credit->id)[0];
        $percent_form                 = self::percentForm($history);

        if ($percent_form == 100) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT_UPLOAD_STEP_1, $credit->id, 1);
            //*inicializar las acciones de la siguiente etapa en curso
            HistoryLog::move($credit->id, HistoryLog::KC_PAYMENT_FORM_STEP_2, HistoryLog::KC_PAYMENT_FORM_STEP_2, null, false);
            HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT_FORM_STEP_2, $credit->id, 0);
        }
        $max_hour                     = self::HOUR_STEP_1;
        $hour                         = $history->created_at;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function actionStep1($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_form   = self::percentForm($history);
        $status_file    = $percent_form == 100 ? 'Concluido' : 'En curso';

        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptions($history, 1);

        $view_dead_line  = self::deadLineStep1($history);

        $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();

        $subject1 = HistoryLog::$label_subject[31];

        $data[] = array(
            'name' => 'Email',
            'subject' => $subject1,
            'status' => $status_file,
            'deadline' => $view_dead_line,
            'advisor' => $name_advisor,
            'options' => $file_option,
        );
        return $data;
    }

    public function deadLineStep2($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFile($credit->id);
        if ($percent_form == 100) {
            HistoryLog::updateStatusProgress(HistoryLog::KC_PAYMENT_UPLOAD_STEP_1, $credit->id, 1);
            //*inicializar las acciones de la siguiente etapa en curso
            HistoryLog::move($credit->id, HistoryLog::KC_DELIVERY_FORM_STEP_3, HistoryLog::KC_DELIVERY_FORM_STEP_3, null, false);
            HistoryLog::updateStatusProgress(HistoryLog::KC_DELIVERY_FORM_STEP_3, $credit->id, 0);
        }
        $max_hour                     = self::HOUR_STEP_2;
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_PAYMENT_UPLOAD_STEP_1], $credit->id)[0];
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    //este es la accion 1
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
        //$view_dead_line_step2  = '';

        $view_dead_line_inf_credit  = 'N/A';
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form2']])->render();
        $form_option_2  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();

        $subject1 = HistoryLog::$label_subject[32];
        $subject2 = HistoryLog::$label_subject[33];
        
        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' =>  'Opcional',
            'deadline' => $view_dead_line_inf_credit,
            'advisor' => $name_advisor,
            'options' => $form_option_2,
        );
        $data[] = array(
            'name' => 'Carga',
            'subject' => $subject2,
            'status' => $status_form,
            'deadline' => $view_dead_line_step2,
            'advisor' => $name_advisor,
            'options' => $form_option,
        );
        
        

        return $data;
    }

    public function deadLineStep3($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFormStep2($history);
        $max_hour                     = self::HOUR_STEP_3;
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_PAYMENT_FORM_STEP_2], $credit->id)[0];
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function actionStep3($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_form   = self::percentFormStep2($history);
        $status_form    =  $percent_form == 100 ? 'Concluido' : 'En curso';

        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptionsStep3($history);
        $view_dead_line_inf_credit  =self::deadLineStep3($history);
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();
        $subject1 = HistoryLog::$label_subject[34];
        
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
    
    public function actionStep4($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;

        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options   = self::menuOptionsStep4($history);

        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();
        
        $subject1 = null;

        $data[] = array(
            'name' => 'Formulario',
            'subject' => $subject1,
            'status' =>  'Opcional',
            'deadline' => 'N/A',
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

    public function dinamicDeadline($history)
    {
        $credit                       = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent   = self::percentFile($credit->id);
        $in_progress        = HistoryLog::getByStatus([$history->status_id], $credit->id)[0];
        $hour               = $in_progress->date_status_progress;

        $menu_options   = self::menuOptions($history, 2);
        $menu  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form2']])->render();
        

        if ($history->status_id == HistoryLog::KC_DELIVERY_FORM_STEP_3) {
            $percent         = self::percentFormStep2($history);
            $menu_options   = self::menuOptionsStep3($history);
            $menu  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        }

        $view_dead_line     = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return array('deadline' => $view_dead_line, 'percent' => $percent, 'menu' => $menu);
    }

    public function menuOptions($history, $step = 1)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/payment/' . $history->id . '/form?step=' . $step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/template/action-document/payment/' . $history->id . '?step='.$step,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => null,
                    'onclick' => null,
                    'name' => null,
                    'icon' => null
                ]
            ),
        );

        return $menu;
    }

    public function menuOptionsStep3($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/payment/' . $history->id . '/form?step=3',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/action-form/payment/' . $history->id . '/form?step=3_2',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/template/action-document/payment/' . $history->id . '?step=3',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]

            )
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
                    'link' => '/panel/template/actions/payment/' . $history->id . '/show?step=2',
                    'onclick' => '',
                    'name' => $lbl_action,
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'actionstep2' => array(
                [
                    'link' => '/panel/template/actions/payment/' . $history->id . '/show?step=3',
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
        $client     = $credit->creditClientPerson;

        $total_valid = 0;
        
        if ($credit != null && $credit->payment_check != null) {
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
            HistoryLog::KC_PAYMENT_UPLOAD_STEP_1,
            HistoryLog::KC_PAYMENT_FORM_STEP_2,
        );
        
        $get_actions = HistoryLog::getByStatus($data_actions, $credit->id);
        $status_progress = 0;
        $current_show = null;

        foreach ($get_actions as $key => $get_action) {
            $status = $get_action->status_progress;
            $status_progress += $status != null ? $status : 0;
            //$current_show = $status < 100 && $get_action->status_id == HistoryLog::KC_DELIVERY_UPLOAD_STEP_2 ? 'Comprobar pago': 'Verificar pago';
        }

        if ($status_progress <= 1) {
            $current_show = 'Confirmación de entrega';
        } elseif ($status_progress > 1) {
            $current_show = 'Reducción de análisis';
        }

        $percent =  (($status_progress) / 3) * 100;

        if ($show_current_show == true) {
            return $current_show;
        }
        
        return reduceDecimal($percent);
    }

    public function getFile($template_config_id)
    {
        $config = self::configUpload()[$template_config_id];
        return $config;
    }

    //*TODO: se deshabilito al ser opcional la caja de carga
    public function percentFile($id_rel)
    {
        $model = File::MODEL['payment'];
        $percent = 0;
        $total_valid = 1;
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
            if ($file != null && $config_file['is_required'] == true) {
                $count_file = $count_file + 1;
                $percent_file = $percent_file + 100;
            }
        }

        $percent =  (100 / 100) * $percent_file;
        return $percent;
    }

    public function menuPrincipalOptions($history)
    {
        $credit           = $history->historyCredit;
        $client           = $credit->creditClientPerson;
        $status_cancel    = HistoryLog::CREDIT_CANCELED;
        $status_reject    = HistoryLog::CREDIT_REJECTED;
        $status_archive   = HistoryLog::CREDIT_ARCHIVE;
        $old_status       = $history->old_status_id;
        $is_user_financial = Auth::user()->hasRole('Cliente financiera');
        if ($is_user_financial === true ) {
            $menu = array(
                'options' => array(
                    [
                        'link' => '/credit-resume/'.$credit->id,
                        'onclick' => '',
                        'name' => 'Ver resumen',
                        'icon' => 'icon ni ni-list-round'
                    ],
                    [
                        'link' => 'panel/template/action-document/payment/'.$history->id.'?step=2',
                        'onclick' => '',
                        'name' => 'Comprobar pago',
                        'icon' => 'icon ni ni-list-round'
                    ],
                ),
            );
        } else {

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
                        'link' => '/panel/template/steps/payment/'.$history->id.'/show',
                        'onclick' => '',
                        'name' => 'Ver etapas',
                        'icon' => 'icon ni ni-list-thumb-fill'
                    ],
                    [
                        'link' => null,
                        'onclick' => 'moveModal("Cancelar",'.$credit->id.','.$status_cancel.','.$old_status.',"dt-delivery")',
                        'name' => 'Cancelar',
                        'icon' => 'icon ni ni-cross-circle-fill'
                    ],
                    [
                        'link' => null,
                        'onclick' => 'moveModal("Rechazar",'.$credit->id.','.$status_reject.','.$old_status.',"dt-delivery")',
                        'name' => 'Rechazar',
                        'icon' => 'icon ni ni-cross-round-fill'
                    ],
                    [
                        'link' => null,
                        'onclick' => 'moveModal("Archivar",'.$credit->id.','.$status_archive.','.$old_status.',"dt-delivery")',
                        'name' => 'Archivar',
                        'icon' => 'icon ni ni-archive-fill'
                    ],
                    [
                        'link' => '/credit-resume/'.$credit->id,
                        'onclick' => '',
                        'name' => 'Ver resumen',
                        'icon' => 'icon ni ni-list-round'
                    ],
                    [
                        'link' => 'panel/template/action-document/delivery/'.$history->id.'?step=2',
                        'onclick' => '',
                        'name' => 'Comprobar pago',
                        'icon' => 'icon ni ni-list-round'
                    ],
                ),
            );
        }
        
        return $menu;
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
             'title' => 'KC - Payment',
             'link' => '/panel/kc-payments',
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
             'title' => 'KC - Payment',
             'link' => '/panel/kc-payments',
             'active' => null
            ),
            2 => array(
                'title' => 'etapas',
                'link' => '/panel/template/steps/payment/'.$history->id.'/show',
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
             'title' => 'KC - Payment',
             'link' => '/panel/kc-payments',
             'active' => null
            ),
            2 => array(
             'title' => 'etapas',
             'link' => '/panel/template/steps/payment/'.$history->id.'/show',
             'active' => null
            ),
            3 => array(
             'title' => 'acciones',
             'link' => '/panel/template/actions/payment/'.$history->id.'/show?step='.$step,
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

    public function setTitle()
    {
        return 'Acción email';
    }
}
