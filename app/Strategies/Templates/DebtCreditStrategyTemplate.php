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

class DebtCreditStrategyTemplate implements TemplateInterface
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
                'name' => 'Edo Cta financiera actual',
                'comment' => 'Más reciente',
                'is_required' => false,
                'is_date' => false,
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
        $name_form = 'frm-template_debt_credit';
        $options_agreement = Agreement::getAllActive();
        $option_financials = config('financial_enums.periodicity_products');
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
            ],
            3 => [
                'title_section' => null,
                'title' => 'Financiera',
                'name_field' => 'financial_id',
                'id_field' => 'lead-financial_id',
                'comment_admin' => 'Financiera donde tiene su crédito el cliente.',
                'comment_webApp' => 'Financiera con la que tienes tu crédito actual.',
                'placeholder' => 'Escribe para buscar',
                'type' => 'select2',
                'is_option_array' => false,
                'options' => null,
                'is_required' => true,
            ],
            4 => [
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
            ],
            5 => [
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
            ],
            6 => [
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
            ],
            7 => [
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
            ],
            8 => [
                'title_section' => 'Crédito actual',
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
            ],
            9 => [
                'title_section' => null,
                'title' => 'pago actual',
                'name_field' => 'current_payment',
                'id_field' => 'current_payment',
                'comment_admin' => 'Pago periódico actual del crédito',
                'comment_webApp' => 'Pago periódico actual del crédito',
                'placeholder' => null,
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
            ],
            10 => [
                'title_section' => null,
                'title' => 'Periodicidad actual',
                'name_field' => 'current_periodicity',
                'id_field' => 'current_periodicity',
                'comment_admin' => 'Periodicidad del crédito actual del cliente',
                'comment_webApp' => 'Periodicidad de tu crédito actual',
                'placeholder' => null,
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $option_financials,
                'is_required' => false,
            ],
            11 => [
                'title_section' => null,
                'title' => 'Crédito actual',
                'name_field' => 'current_loan',
                'id_field' => 'current_loan',
                'comment_admin' => 'Préstamo otorgado al cliente',
                'comment_webApp' => 'Préstamo que obtuviste con la financiera actual',
                'placeholder' => null,
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
            ],
            12 => [
                'title_section' => null,
                'title' => 'Plazo actual',
                'name_field' => 'current_term',
                'id_field' => 'current_term',
                'comment_admin' => 'Plazo del crédito',
                'comment_webApp' => 'Plazo del crédito (número de pagos)',
                'placeholder' => null,
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
            ],
            13 => [
                'title_section' => null,
                'title' => 'Saldo insoluto actual',
                'name_field' => 'current_principal_balance',
                'id_field' => 'current_principal_balance',
                'comment_admin' => 'Saldo de capital',
                'comment_webApp' => 'Saldo de capital pendiente (no incluye interés)',
                'placeholder' => null,
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
            ],
            14 => [
                'title_section' => null,
                'title' => 'Saldo total actual',
                'name_field' => 'current_total_balance',
                'id_field' => 'current_total_balance',
                'comment_admin' => 'Saldo del crédito',
                'comment_webApp' => 'Saldo del crédito (total de los pagos pendientes)',
                'placeholder' => null,
                'type' => 'number',
                'is_option_array' => false,
                'options' => null,
                'is_required' => false,
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

        $credit                               = Credit::find($id_rel);
        $credit->agreement_id                 = $agreement_id;
        $credit->financial_id                 = $request->financial_id;
        $credit->current_payment              = $request->current_payment * 100;
        $credit->current_periodicity          = $request->current_periodicity;
        $credit->current_loan                 = $request->current_loan * 100;
        $credit->current_term                 = $request->current_term;
        $credit->current_principal_balance    = $request->current_principal_balance * 100;
        $credit->current_total_balance        = $request->current_total_balance * 100;
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
        $hour               = $credit->created_at;
        $percent_form       = self::percentForm($history);
        $percent_file       = 100;
        $color_inf_credit   = 'success';
        $color_report       = 'success';
        $menu_options       = self::menuOptionsStep($history);
        $total_percent      = $percent_file + $percent_form;
        //$total_credit_percent   = $percent_file;
       
        $status_inf_credit = ($total_percent > 100) ? 'Concluido' : 'En curso';
        //TODO: change validation when the decision action is carried out in the report
        $status_report = ($total_percent > 100) ? 'En curso' : 'En espera';
        
        $total_credit_percent = ($percent_form > 100) ? 100 : $percent_form;

        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        
        $option_inf_credit          = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actions']])->render();
        
        $view_percent_inf_credit    = \View::make('panel.module.view_percent', ['percent' => $total_credit_percent])->render();
        $view_count_inf_credit      = \View::make('panel.module.view_count', ['number' => 1])->render();
        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        
        $view_percent_report        = \View::make('panel.module.view_percent', ['percent' => 0])->render();
        $view_count_report          = \View::make('panel.module.view_count', ['number' => 2])->render();
        $option_inf_report          = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['reports']])->render();
        

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
        $color_inf_credit   = 'success';

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
        $hour           = Carbon::parse($credit->created_at)->hour;
        $menu_options   = self::menuOptionReportStep($history);
        $advisor        = $credit->creditAdvisor;
        $user = User::find($advisor->id);
        $role = (isset(User::$alias_role[$user->getRoleNames()[0]]))? User::$alias_role[$user->getRoleNames()[0]] : '';
        $name_module_response   = 'KaaxClub';
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

    public function menuOptions($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/template/action-document/debtCredit/'.$history->id,
                    'onclick' => '',
                    'name' => 'Ver acción',
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/action-form/debtCredit/'.$history->id.'/form',
                    'onclick' => '',
                    'name' => 'Ver acción',
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
                    'link' => '/panel/template/actions/debtCredit/'.$history->id.'/show',
                    'onclick' => '',
                    'name' => 'Lista de acciones',
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'reports' => array(
                [
                    'link' => '/panel/template/report/debtCredit/'.$history->id.'/show',
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
                ]
            ),
            'desition' => array(
                [
                    'link' => '/panel/kc-check-up/report/desition/'.$history->id.'/show/',
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
            $total_valid = $total_valid + 20;
        }
        
        if ($credit != null && $credit->financial_id != '') {
            $total_valid = $total_valid + 20;
        }

        if ($client != null && $client->name != null) {
            $total_valid = $total_valid + 20;
        }

        if ($client != null && $client->last_name != null) {
            $total_valid = $total_valid + 20;
        }

        if ($client != null && $client->cellphone != null) {
            $total_valid = $total_valid + 20;
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

    //*TODO: se deshabilito al ser opcional la caja de carga
    public function percentFile($id_rel)
    {
        $model = File::MODEL['debtCredit'];
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
