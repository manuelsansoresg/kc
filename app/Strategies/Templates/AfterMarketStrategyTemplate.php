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

class AfterMarketStrategyTemplate implements TemplateInterface
{
    const HOUR_STEP_1  = 72;
    const HOUR_STEP_2  = 72;
    const HOUR_STEP_3  = 2;

    public function move($id)
    {
    }

    public function configUpload()
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
    }

    public function configForm($id_rel, $history_id = null)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;

        if ($step == 1) {
            return self::configFormStep1($id_rel, $history_id);
        }
    }

    public function configFormStep1($id_rel, $history_id)
    {
        $name_form    = 'frm-template_control_desk_step1';
        $type_form    = HistoryLog::KC_AFTER_FORM;
        $credit       = Credit::find($id_rel);
        $client_person = $credit->creditClientPerson;

        $elements = array(
            1 => [
                'title_section' => 'Encuesta',
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
                'title' => 'Enviar por email',
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
                'col' => 'col-12 col-md-4'
            ],
            3 => [
                'title_section' => null,
                'title' => 'Copiar URL',
                'name_field' => null,
                'id_field' => null,
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'href',
                'link' => null,
                'onclick' => 'copyToClipBoardReport()',
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'col' => 'col-12 col-md-4'
            ],
            4 => [
                'title_section' => null,
                'title' => null,
                'name_field' => null,
                'id_field' => 'url_report',
                'comment_admin' => null,
                'comment_webApp' =>  null,
                'placeholder' => '',
                'type' => 'hidden',
                'link' => null,
                'value' => asset('/survey/'.$credit->id),
                
                'class' => 'btn btn-primary',
                'target' => null,
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null,
                'col' => null
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
                'value' => '/panel/template/steps/afterMarket/'.$history_id.'/show',
                'col' => 'col-12'
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
            
        }
    }

    public function listStep($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $percent_form   = reduceDecimal(self::percentForm($history));
        
        //$percent_form = $percent_form;
        $menu_options         = self::menuOptionsStep($history);
        $status_step1         = $percent_form == 100 ? 'Concluido' : 'En curso';
        $option_step1               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actionstep1']])->render();
        
        $view_percent_step1         = \View::make('panel.module.view_percent', ['percent' => $percent_form])->render();
        $view_count_inf_credit      = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();


        $data = array();
        $data[] = array(
            'name' => $view_count_inf_credit,
            'step' => 'Encuesta',
            'status' => $status_step1,
            'progress' => $view_percent_step1,
            'deadline' => '',
            'options' => $option_step1,
        );
        
       
        return $data;
    }

    public function moduleDeadline($history)
    {
        
        return 'N/A';
    }

    public function listAction($history_id)
    {
        $step = isset($_GET['step']) ? $_GET['step'] : null;
        return self::actionStep1($history_id);
    }

    public function listActionByStep($history_id, $step)
    {
        return self::actionStep1($history_id);
    }

    
    
    public function deadLineStep1($history, $percent, $show_max_hour = false)
    {
        $color_inf_credit             = 'success';
        $credit                       = $history->historyCredit;
        $percent_form                 = self::percentForm($history);
        $max_hour                     = self::HOUR_STEP_1;
        $in_progress                  = HistoryLog::getByStatus([HistoryLog::KC_AFTER_FORM], $credit->id)[0];
        $hour                         = $in_progress->date_status_progress;
        $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit, $show_max_hour);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];
        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        if ($show_max_hour == true) {
            return $data_deadline['lbl_hour'];
        }
        return $view_dead_line_inf_credit;
    }

    public function actionStep1($history_id)
    {
        $history                = HistoryLog::find($history_id);
        $credit                 = $history->historyCredit;
        $advisor                = $credit->creditAdvisor;
        $status_file            = 'Concluida';
        $hour                   = $history->created_at;
        //$percent_form   = self::percentForm($history);
        $percent_form           = self::percentForm($history);
        $name_advisor = null;

        try {
            $user                   = User::find($advisor->id);
            $role                   = (isset(User::$alias_role[$user->getRoleNames()[0]])) ? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor           = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
            if ($advisor->id == Auth::user()->id) {
                $name_advisor = 'Tú';
            }
        } catch (\Exception $th) {
            //throw $th;
        }

        $menu_options           = self::menuOptions($history, 1);

        $view_dead_line_step1   = self::deadLineStep1($history, 100);
        $option                 = null;

        

        $option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        

        $data = array();
        $subject1 = HistoryLog::$label_subject[48];
        $viewStatus1 = \View::make('panel.module.status', ['status' => $status_file])->render();

        $data[] = array(
            'name' => 'Encuesta',
            'subject' => $subject1,
            'status' => $viewStatus1,
            'deadline' => $view_dead_line_step1,
            'advisor' => $name_advisor,
            'options' => $option,
            'link' => '/panel/action-form/afterMarket/'.$history_id.'/form?step=1'
        );
        return $data;
    }

    public function dinamicDeadline($history)
    {
        $credit             = $history->historyCredit;
        $color_inf_credit   = 'success';
        $percent            = self::getPercent($credit->id);
        $in_progress        = HistoryLog::getByStatus([$history->status_id], $credit->id)[0];
        $hour               = $in_progress->date_status_progress;
        $menu_options       = self::menuOptions($history, 1);
        $menu               = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        $view_dead_line     = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return array('deadline' => $view_dead_line, 'percent' => $percent, 'menu' => $menu);
    }


    public function menuPrincipalOptions($history)
    {
        $credit     = $history->historyCredit;
        $client     = $credit->creditClientPerson;

        $menu = array(
            'options' => array(
                [
                    'link' => '/panel/template/steps/afterMarket/'.$history->id.'/show',
                    'onclick' => '',
                    'name' => 'Ver etapas',
                    'icon' => 'icon ni ni-list-thumb-fill',
                    'class' => 'text-dark'
                ],
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
                    'link' => 'https://web.whatsapp.com/send/?phone='.$client->cellphone.'&text&type=phone_number&app_absent=0 ',
                    'target' => '_blank',
                    'onclick' => '',
                    'name' => 'Whatsapp',
                    'icon' => 'icon ni ni-whatsapp'
                ],
                
            ),
        );

        return $menu;
    }
    
    public function menuOptions($history, $step = 1)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-form/afterMarket/' . $history->id . '/form?step=' . $step,
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
                    'name' => 'Ver tareas',
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
                    'link' => '/panel/template/actions/afterMarket/' . $history->id . '/show?step=1',
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
        $credit     = $history->historyCredit;
        try {
            $in_progress  = HistoryLog::getByStatus([HistoryLog::KC_AFTER_FORM], $credit->id)[0];
            $percent = ($in_progress->status_progress == 1) ? 100 : 0;
        } catch (\Throwable $th) {
            return 0;
        }
        return $percent;
    }
    
    public function percentFile($history)
    {
       
        return 0;
    }


    //* get all percentages of the shares
    public function getPercent($history, $show_current_show = false)
    {
        try {
            $credit     = $history->historyCredit;
            $data_actions = array(
                HistoryLog::KC_AFTER_FORM,
            );
            
            $get_actions = HistoryLog::getByStatus($data_actions, $credit->id);
            $status_progress = 0;
            $current_show = null;

            foreach ($get_actions as $key => $get_action) {
                $status = $get_action->status_progress;
                $status_progress += $status != null ? $status : 0;
                $current_show = 'Encuesta';
            }

            $percent =  (($status_progress) / 1) * 100;

            if ($show_current_show == true) {
                return $current_show;
            }
            
            return reduceDecimal($percent);
        } catch (\Throwable $th) {
            return 0;
        }
    }

    

    public function getFile($template_config_id)
    {
        $config = self::configUpload()[$template_config_id];
        return $config;
    }

    //*TODO: se deshabilito al ser opcional la caja de carga
    

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
             'title' => 'KC - Aftermarket',
             'link' => '/panel/kc-aftermarket',
             'active' => null
            ),
            2 => array(
                'title' => 'etapas',
                'link' => '/panel/template/steps/afterMarket/'.$history->id.'/show',
                'active' => true
            ),
            3 => array(
                'title' => 'tareas',
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
             'title' => 'KC - AFTERMARKET',
             'link' => '/panel/afterMarket',
             'active' => null
            ),
            2 => array(
             'title' => 'etapas',
             'link' => '/panel/template/steps/afterMarket/'.$history->id.'/show',
             'active' => null
            ),
            3 => array(
             'title' => 'tareas',
             'link' => '/panel/template/steps/afterMarket/'.$history->id.'/show',
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
        return 'Acción formulario';
    }
}
