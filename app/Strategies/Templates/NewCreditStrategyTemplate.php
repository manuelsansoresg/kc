<?php

namespace App\Strategies\Templates;

use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\File;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Strategies\TemplateInterface;
use App\Strategies\Values\SendNotificationsValues;
use Carbon\Carbon;
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
                'is_required' => true,
                'is_date' => true,
                'max_size' => 2,
                'max_file' => 2,
                'type' => 'image/*',
                'comment_date' => 'Establece la fecha del comprobante más antigüo'
            ]
        );
        return $elements;
    }

    public function configForm($id_rel)
    {
        $name_form = 'frm-template_new_credit';
        $options_agreement = Agreement::getAllActive();
        $elements = array(
            1 => [
                'title' => 'Organización',
                'name_field' => 'agreement_id',
                'id_field' => 'lead-agreement',
                'comment_admin' => ' Empresa donde labora el cliente',
                'comment_webApp' => ' Empresa donde laboras',
                'placeholder' => 'Escribe para buscar',
                'type' => 'select2',
                'options' => $options_agreement,
                'is_required' => true,
            ],
            2 => [
                'title' => 'Nombres',
                'name_field' => 'name',
                'id_field' => 'name',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'options' => null,
                'is_required' => true,
            ],
            3 => [
                'title' => 'Primer apellido',
                'name_field' => 'last_name',
                'id_field' => 'last_name',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'options' => null,
                'is_required' => true,
            ],
            4 => [
                'title' => 'Segundo apellido',
                'name_field' => 'second_last_name',
                'id_field' => 'second_last_name',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'text',
                'options' => null,
                'is_required' => false,
            ],
            5 => [
                'title' => 'Celular',
                'name_field' => 'cellphone',
                'id_field' => 'cellphone',
                'comment_admin' => null,
                'comment_webApp' => null,
                'placeholder' => null,
                'type' => 'number',
                'options' => null,
                'is_required' => true,
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'name_form' => $name_form, 'id_rel' => $id_rel])->render();
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
        $hour               = Carbon::parse($credit->created_at)->hour;
        $percent_form       = self::percentForm($history);
        $percent_file       = self::percentFile($history->id_rel);
        $color_inf_credit   = 'success';
        $color_report       = 'success';
        $total_percent = $percent_file + $percent_form;
        $total_credit_percent = $percent_file + $percent_form;
        $status_report              = 'En espera';
       
        $status_inf_credit = ($total_percent > 100) ? 'Cerrado' : 'Abierto';
        
        $total_credit_percent = ($total_percent> 100) ? 100 : 50;

        if ($hour > 5) {
            $color_inf_credit = ($hour >= $max_hour) ? 'danger' : 'warning';
        }

        if ($hour > 5) {
            $color_inf_credit = ($hour >= $max_hour) ? 'danger' : 'warning';
        }

        $view_option  = \View::make('panel.module.checkup.steps.add_option_dt', ['id' => $history_id])->render();
        $view_percent_inf_credit    = \View::make('panel.module.view_percent', ['percent' => $total_credit_percent])->render();
        $view_count_inf_credit      = \View::make('panel.module.view_count', ['number' => 1])->render();
        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        $view_percent_report        = \View::make('panel.module.view_percent', ['percent' => 0])->render();
        $view_count_report          = \View::make('panel.module.view_count', ['number' => 2])->render();
        

        

        $data = array();
        $data[] = array(
            'name' => $view_count_inf_credit,
            'step' => 'Información del crédito',
            'status' => $status_inf_credit,
            'progress' => $view_percent_inf_credit,
            'deadline' => $view_dead_line_inf_credit,
            'options' => $view_option,
        );
        $data[] = array(
            'name' => $view_count_report,
            'step' => 'Reporte',
            'status' => $status_report,
            'progress' => $view_percent_report,
            'deadline' => '',
            'options' => $view_option,
        );
        return $data;
    }

    public function listAction($history_id)
    {
        $history        = HistoryLog::find($history_id);
        $credit         = $history->historyCredit;
        $advisor        = $credit->creditAdvisor;
        $percent_file   = self::percentFile($history->id_rel);
        $percent_form   = self::percentForm($history);
        $status_file    = $percent_file == 100 ? 'Concluido' : 'En curso';
        $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $max_hour       = 12;
        $hour           = Carbon::parse($credit->created_at)->hour;
        $name_advisor   = $advisor->name.' '.$advisor->last_name;
        $menu_options   = self::menuOptions($history);

        if ($hour > 5) {
            $color_inf_credit = ($hour >= $max_hour) ? 'danger' : 'warning';
        }
        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
        $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

        //dd(json_encode($option_file));

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

    public function menuOptions($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/action-document/'.$history->id_rel,
                    'onclick' => '',
                    'name' => 'Ver acción',
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/action-form/newCredit/'.$history->id_rel.'/form',
                    'onclick' => '',
                    'name' => 'Ver acción',
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
}
