<?php

namespace App\Strategies\Templates;

use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\File;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\User;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use stdClass;

class NewCreditStrategyTemplate implements TemplateInterface
{
    public function move($id)
    {
    }

    public function configUpload()
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
            ]
        );
        return $elements;
    }

    public function configForm($id_rel, $history_id = null)
    {
        $name_form = 'frm-template_new_credit';
        $type_form = HistoryLog::KC_CHECK_UP_ACTION_FORM;
        $options_agreement = Agreement::getAllActive();
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
                'title' => 'Organización',
                'name_field' => 'agreement_id',
                'id_field' => 'lead-agreement',
                'comment_admin' => ' Empresa donde labora el cliente',
                'comment_webApp' => ' Empresa donde laboras',
                'placeholder' => 'Escribe para buscar',
                'type' => 'select2',
                'is_option_array' => false,
                'options' => $options_agreement,
                'is_required' => true,
                'is_disabled' => null
            ],
            3 => [
                'title_section' => null,
                'title' => 'Nombres',
                'name_field' => 'name',
                'id_field' => 'name',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            4 => [
                'title_section' => null,
                'title' => 'Primer apellido',
                'name_field' => 'last_name',
                'id_field' => 'last_name',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
                'is_disabled' => null
            ],
            5 => [
                'title_section' => null,
                'title' => 'Segundo apellido',
                'name_field' => 'second_last_name',
                'id_field' => 'second_last_name',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
                'is_disabled' => null
            ],
            6 => [
                'title_section' => null,
                'title' => 'Celular',
                'name_field' => 'cellphone',
                'id_field' => 'cellphone',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
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

    public function saveForm($request)
    {
        $id_rel         = $request->id_rel;
        $agreement_id   = $request->agreement_id;
        $history        = HistoryLog::find($request->history_id);

        if (isset($request->agreement_id) && $request->agreement_id == 0) { //si es  0 se insertara el nuevo agreement
            $agreement = new Agreement(['name' => $request->new_agreement, 'status' => 1]);
            $agreement->save();
            $agreement_id = $agreement->id;
        }

        $credit                 = Credit::find($id_rel);
        $credit->agreement_id   = $agreement_id;
        $credit->update();

        $client                     = ClientPerson::find($credit->client_person_id);
        $client->agreement_id       = $agreement_id;
        $client->name               = $request->name;
        $client->last_name          = $request->last_name;
        $client->second_last_name   = $request->second_last_name;
        $client->cellphone          = $request->cellphone;
        $client->update();
        
        if ($history != null) {
            $percent_form   = self::percentForm($history);
            if ($percent_form == 100) {
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_FORM, $credit->id, 1); //*marcar como completada la tarea
                //*inicializar las acciones de la siguiente etapa en curso
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_REPORT, $credit->id, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_ACTION_DESITION, $credit->id, 0);
            }
        }
        
    }

    public function listStep($history_id)
    {
        $history              = HistoryLog::find($history_id);
        $credit               = $history->historyCredit;
        $max_hour             = 12;
        $hour                 = $credit->created_at;
        $percent_form         = self::percentForm($history);
        $percent_form_step2   = self::percentDesition($history);
        $percent_file         = 100;
        $color_inf_credit     = 'success';
        $color_report         = 'success';
        $option_inf_report    = null;
        $total_percent        = $percent_file + $percent_form;
        $status_report        = 'En espera';
        $menu_options         = self::menuOptionsStep($history);
        $status_inf_credit    = ($percent_form >= 100) ? 'Concluido' : 'En curso';
        $status_report        = ($percent_form_step2 >= 100) ? 'Concluido' : 'En curso';
        $total_credit_percent = ($total_percent> 100) ? 100 : 50;
        $data_deadline        = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit     = $data_deadline['color'];
        $hour                 = $data_deadline['lbl_hour'];

        $option_inf_credit  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actions']])->render();
        if ($status_inf_credit == 'Concluido') {
            $option_inf_report  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['reports']])->render();
        }


        $view_percent_inf_credit    = \View::make('panel.module.view_percent', ['percent' => $percent_form])->render();
        $view_count_inf_credit      = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        $view_percent_report        = \View::make('panel.module.view_percent', ['percent' => $percent_form_step2])->render();
        $view_count_report          = \View::make('panel.module.view_count', ['number' => 'Dos'])->render();
        

        $data = array();
        $data[] = array(
            'name' => $view_count_inf_credit,
            'step' => 'Información del crédito',
            'status' => $status_inf_credit,
            'progress' => $view_percent_inf_credit,
            'deadline' => $view_dead_line_inf_credit,
            'options' => $option_inf_credit,
        );
        $data[] = array(
            'name' => $view_count_report,
            'step' => 'Reporte',
            'status' => $status_report,
            'progress' => $view_percent_report,
            'deadline' => '',
            'options' => $option_inf_report,
        );
        return $data;
    }

    public function moduleDeadline($history)
    {
        $max_hour           = 24;
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
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_file   = 100;
        $percent_form   = self::percentForm($history);
        $status[]       = 'Opcional';
        $status[]       = $percent_form == 100 ? 'Concluido' : 'En curso';
        $max_hour       = 12;
        
        $in_progress    = HistoryLog::getByStatus([HistoryLog::KC_CHECK_UP_ACTION_FORM], $credit->id)[0];
        $hour           = $in_progress->date_status_progress;

        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]]))? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role.' - '.$advisor->name.' '.$advisor->last_name;
        $menu_options   = self::menuOptions($history);
        $color_inf_credit = 'success';

        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        $deadline[]  = 'N/A';
        $deadline[]  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        $option[]  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        $option[]  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }
        
        $name[] = 'Carga';
        $name[] = 'Formulario';

        $subject[] = HistoryLog::$label_subject[7];
        $subject[] = HistoryLog::$label_subject[8];

        $data_actions = array(
            HistoryLog::KC_CHECK_UP_ACTION_UPLOAD,
            HistoryLog::KC_CHECK_UP_ACTION_FORM,
        );
      
        $get_actions = HistoryLog::getByStatus($data_actions, $credit->id);
        foreach ($get_actions as $key => $get_action) {
            $data[] = array(
                'name' =>  $name[$key],
                'subject' => $subject[$key],
                'status' => $status[$key],
                'deadline' => $deadline[$key],
                'advisor' => $name_advisor,
                'options' => $option[$key],
            );
        }
        return $data;
    }

    public function listStepReport($history_id)
    {
        $history                = HistoryLog::find($history_id);
        $credit                 = $history->historyCredit;
        $max_hour               = 12;
        $percent_desition       = self::percentDesition($history);
        $in_progress            = HistoryLog::getByStatus([HistoryLog::KC_CHECK_UP_ACTION_DESITION], $credit->id)[0];
        $hour                   = $in_progress->date_status_progress;

        $menu_options           = self::menuOptionReportStep($history);
        $advisor                = $credit->creditAdvisor;
        
        $name_module_response   = 'KaaxClub';
        $user                   = User::find($advisor->id);
        $role                   = (isset(User::$alias_role[$user->getRoleNames()[0]]))? User::$alias_role[$user->getRoleNames()[0]] : '';
        $color_desition         = 'success';
        $name_advisor           = $role.' - '.$advisor->name.' '.$advisor->last_name;
        
        $data_deadline          = deadline($hour, $max_hour, $percent_desition, 'success');
        $color_desition         = $data_deadline['color'];
        $hour                   = $data_deadline['lbl_hour'];
        
        $deadline[]   = 'N/A';
        $deadline[]   = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_desition])->render();

        $option[]     = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['progress']])->render();
        $option[]     = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['desition']])->render();

        $data         = array();
        $status[]     = 'Concluida';
        $status[]     = $percent_desition == 100 ? 'Concluido' : 'En curso';

        $name[]       = 'Respuesta de módulo';
        $name[]       = 'Decisión';

        $subject[]    = HistoryLog::$label_subject[9];
        $subject[]    = HistoryLog::$label_subject[14];

        $data_actions = array(
            HistoryLog::KC_CHECK_UP_ACTION_REPORT,
            HistoryLog::KC_CHECK_UP_ACTION_DESITION,
        );
      
        $get_actions  = HistoryLog::getByStatus($data_actions, $credit->id);

        foreach ($get_actions as $key => $get_action) {
            $data[] = array(
                'name' =>  $name[$key],
                'subject' => $subject[$key],
                'status' => $status[$key],
                'deadline' => $deadline[$key],
                'advisor' => $name_advisor,
                'options' => $option[$key],
            );
        }

        return $data;
    }

    public function dinamicDeadline($history)
    {
        $percent            = self::percentDesition($history);
        $status_id          = $history->status_id;
        $credit             = $history->historyCredit;
        $in_progress        = HistoryLog::getByStatus([$status_id], $credit->id)[0];
        $hour               = $in_progress->date_status_progress;
        $max_hour           = 12;
        $color_inf_credit   = '';

        if ($status_id == HistoryLog::KC_CHECK_UP_ACTION_FORM) {
            $percent = self::percentForm($history);
        }

        $data_deadline  = deadline($hour, $max_hour, $percent, $color_inf_credit);
        $color_inf_credit             = $data_deadline['color'];
        $hour                         = $data_deadline['lbl_hour'];

        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function menuOptions($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/template/action-document/newCredit/'.$history->id,
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/action-form/newCredit/'.$history->id.'/form',
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
            'actions' => array(
                [
                    'link' => '/panel/template/actions/newCredit/'.$history->id.'/show',
                    'onclick' => '',
                    'name' => 'Lista de acciones',
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'reports' => array(
                [
                    'link' => '/panel/template/report/newCredit/'.$history->id.'/show',
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
                    'link' => '/panel/kc-check-up/report/answer_module/'.$history->id.'/show/',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut',
                ]
            ),
            'desition' => array(
                [
                    'link' => '/panel/kc-check-up/report/desition/'.$history->id.'/show?type=1',
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
        $client     = $credit->creditClientPerson;
        $percent = 0;
        $total_valid = 0;
        if ($credit != null && $credit->agreement_id != '' && $client != null && $client->agreement_id != '') {
            $total_valid = $total_valid + 25;
        }

        if ($client != null && $client->name != null) {
            $total_valid = $total_valid + 25;
        }

        if ($client != null && $client->last_name != null) {
            $total_valid = $total_valid + 25;
        }

        if ($client != null && $client->cellphone != null) {
            $total_valid = $total_valid + 25;
        }
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    public function percentDesition($history)
    {
        $credit = $history->historyCredit;
        $percent = 0;
        if ($credit->applied_financial != null) {
            $percent = 100;
        }
        return $percent;
    }

    

    //* get all percentages of the shares
    public function getPercent($history, $show_current_show = false)
    {
        $credit     = $history->historyCredit;
        $data_actions = array(
            HistoryLog::KC_CHECK_UP_ACTION_FORM,
            HistoryLog::KC_CHECK_UP_ACTION_DESITION,
        );
        
        $get_actions = HistoryLog::getByStatus($data_actions, $credit->id);
        $status_progress = 0;
        $current_show = null;

        foreach ($get_actions as $key => $get_action) {
            $status = $get_action->status_progress;
            $status_progress += $status != null ? $status : 0;
            $current_show = $status < 100 && $get_action->status_id == HistoryLog::KC_CHECK_UP_ACTION_FORM ? 'Información del crédito': 'Reporte';
        }

        $percent =  (($status_progress) / 2) * 100;

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
    public function percentFile($id_rel)
    {
        $model = File::MODEL['newCredit'];
        $percent = 0;
        $total_valid = 0;

        $file = File::where([
            'model' => $model,
            'template_config_id' => 2,
            'id_rel' => $id_rel
        ])
        ->wherein('template_config_id', [2])
        ->count();
        
        if ($file > 0) {
            $total_valid = 100;
        }
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }
    public function breadcrumb($history, $type = null)
    {
        return null;
    }
}
