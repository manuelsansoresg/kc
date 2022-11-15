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
use App\Models\Survey;
use App\Models\User;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use stdClass;

class SwapStrategyTemplate implements TemplateInterface
{
    const HOUR_STEP_1  = 6;
    const HOUR_STEP_2  = 72;
    const HOUR_STEP_3  = 2;

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
            return self::uploadStep2();
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

    public function uploadstep2()
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

    public function configForm($id_rel, $history_id = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;

        if ($step == 1) {
            return self::configFormStep1($id_rel, $history_id);
        } elseif ($step == 2) {
            return self::configFormstep2($id_rel, $history_id);
        }
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
        $name_form = 'frm-template_delivery_step2';
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
            
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'history_id' => $history_id, 'name_form' => $name_form, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
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
            $percent_form_step5 = self::percentFormStep3($history);
            if ($percent_form_step5 == 100) {
                HistoryLog::move($credit->id, HistoryLog::CREDITS_PAID, HistoryLog::KC_CONTROL_DESK);
               /*  $notification_add   = SendNotificationsValues::STRATEGY['pushCreditKcDelivery'];
                (new $notification_add)->send($credit->id); */
            }
        }
    }

    public function listStep($history_id)
    {
        $history            = HistoryLog::find($history_id);
        $credit             = $history->historyCredit;
        
        $percent_file       = self::percentFile($credit->id);
        $percent_file_2     = self::percentFile($credit->id, '1_2');
        $percent_form       = self::percentForm($history);
        $new_percent_file   = $percent_file == 100 ? 33 : $percent_file;
        $new_percent_file2  = $percent_file_2 == 100 ? 33 : $percent_file_2;
        $new_percent_form   = $percent_form == 100 ? 34 : $percent_form;
        
        $total_percent      = $new_percent_file + $new_percent_file2 + $new_percent_form;
        $status_step1       = ($total_percent >= 100) ? 'Concluido' : 'En curso';

        $menu_options       = self::menuOptionsStep($history);


        $option_step1   = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();
        $view_count_1   = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_percent   = \View::make('panel.module.view_percent', ['percent' => $total_percent])->render();

        $data = array();
        $data[] = array(
            'name' => $view_count_1,
            'step' => 'Información de crédito actual',
            'status' => $status_step1,
            'progress' => $view_percent,
            'deadline' => '',
            'options' => $option_step1,
        );
       
        return $data;
    }

    public function listAction($history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        if ($step == 2) {
            return self::actionStep2($history_id);
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
        $percent_file_2     = self::percentFile($credit->id, '1_2');
        $percent_form       = self::percentForm($history);
        

        $user                   = User::find($advisor->id);
        $role                   = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor           = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
        $menu_options           = self::menuOptions($history, 1);

        $view_dead_line_step1   = self::deadLineStep1($history);
        $view_dead_line_step2   = self::deadLineStep1_2($history);
        $view_dead_line_step3   = self::deadLineStep1_3($history);

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
        if ($percent_file_2 == 100) {
            $option3  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file2']])->render();
        }
       

        $data = array();
        $data[] = array(
            'name' => 'Carga',
            'status' => $status_file,
            'deadline' => $view_dead_line_step1,
            'advisor' => $name_advisor,
            'options' => $option1,
        );
        $data[] = array(
            'name' => 'Formulario',
            'status' => $status_form,
            'deadline' => $view_dead_line_step2,
            'advisor' => $name_advisor,
            'options' => $option2,
        );
        $data[] = array(
            'name' => 'Carga',
            'status' => $status_file_2,
            'deadline' => $view_dead_line_step3,
            'advisor' => $name_advisor,
            'options' => $option3,
        );
        return $data;
    }

    public function deadLineStep2($history)
    {
        $credit         = $history->historyCredit;
        $color_inf_credit             = 'success';
        $percent_form                 = self::percentFile($credit->id);
        
        $max_hour                     = self::HOUR_STEP_2;
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

    public function menuOptionsStep3($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/delivery/' . $history->id . '/form?step=3',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'form2' => array(
                [
                    'link' => '/panel/action-form/delivery/' . $history->id . '/form?step=3_2',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/template/action-document/delivery/' . $history->id . '?step=3',
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

    public function percentFormStep3($history)
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
        $model = File::MODEL['delivery'];
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
