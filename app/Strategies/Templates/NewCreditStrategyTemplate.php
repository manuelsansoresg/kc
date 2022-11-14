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
    }

    public function listStep($history_id)
    {
        $history            = HistoryLog::find($history_id);
        $credit             = $history->historyCredit;
        $max_hour           = 12;
        $hour           = $credit->created_at;
        $percent_form       = self::percentForm($history);
        $percent_file       = 100;
        $color_inf_credit   = 'success';
        $color_report       = 'success';
        $option_inf_report = null;
        $total_percent = $percent_file + $percent_form;
        //$percent_form = $percent_form;
        $status_report              = 'En espera';
        $menu_options   = self::menuOptionsStep($history);
       
        $status_inf_credit = ($percent_form >= 100) ? 'Concluido' : 'En curso';
        //TODO: change validation when the decision action is carried out in the report
        $status_report = ($percent_form >= 100) ? 'En curso' : 'En espera';
        
        $total_credit_percent = ($total_percent> 100) ? 100 : 50;

        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        $option_inf_credit  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actions']])->render();
        if ($status_report == 'En curso') {
            $option_inf_report  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['reports']])->render();
        }


        $view_percent_inf_credit    = \View::make('panel.module.view_percent', ['percent' => $percent_form])->render();
        $view_count_inf_credit      = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        $view_percent_report        = \View::make('panel.module.view_percent', ['percent' => 0])->render();
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

    public function listAction($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_file   = 100;
        $percent_form   = self::percentForm($history);
        $status_file    = 'Opcional';
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $max_hour       = 12;
        $hour           = $credit->created_at;


        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]]))? User::$alias_role[$user->getRoleNames()[0]] : '';

        $name_advisor   = $role.' - '.$advisor->name.' '.$advisor->last_name;
        $menu_options   = self::menuOptions($history);
        $color_inf_credit = 'success';

        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
        $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        if ($advisor->id == Auth::user()->id) {
            $name_advisor = 'Tú';
        }

        $data = array();
        $data[] = array(
            'name' => 'Carga',
            'status' => $status_file,
            'deadline' => 'N/A',
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
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]]))? User::$alias_role[$user->getRoleNames()[0]] : '';
        $color_desition   = 'success';
        $name_advisor   = $role.' - '.$advisor->name.' '.$advisor->last_name;
        
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

    //* get all percentages of the shares
    public function getPercent($history, $show_current_show = false)
    {
        $credit     = $history->historyCredit;
        $percent_desition = Credit::percentApplyDecision($credit->id);
        $percent_form = self::percentForm($history);
        
        $new_percent_form = $percent_desition == 100 ? 50 : 0;
        $new_percent_desition = $percent_form == 100 ? 50 : 0;

        $total_valid = $new_percent_form  + $new_percent_desition;

        $percent =  (100 / 100) * $total_valid;
        
        $current_show = $new_percent_desition < 100 ? 'Información del crédito': 'Reporte';

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
