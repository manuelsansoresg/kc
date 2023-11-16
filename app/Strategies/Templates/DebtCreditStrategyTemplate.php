<?php

namespace App\Strategies\Templates;

use App\Models\Agreement;
use App\Models\ClientPerson;
use App\Models\Credit;
use App\Models\CurrentFinancialProduct;
use App\Models\File;
use App\Models\FinancialProduct;
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

    public function configForm($id_rel, $history_id = null)
    {
        $name_form = 'frm-template_debt_credit';
        $type_form = HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM;
        $options_agreement = Agreement::getAllActive();
        $option_financials = config('financial_enums.periodicity_products');
        $financial_products = FinancialProduct::getAllByTemplate();
        $type_products = config('financial_enums.type_products');
        
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
                'onchange' => 'organizationChange(null,null)',
                'is_required' => true,
                'is_disabled' => null
            ],
            3 => [
                'title_section' => null,
                'title' => 'Productos financieros',
                'name_field' => 'products[]',
                'id_field' => 'lead-financial-product-id',
                'comment_admin' => 'Selecciona los productos que tiene el credito.',
                'comment_webApp' => '',
                'placeholder' => 'Escribe para buscar',
                'type' => 'select2multiple',
                'is_option_array' => false,
                'options' => $financial_products,
                'is_required' => true,
                'is_disabled' => null
            ],
            4 => [
                'title_section' => null,
                'title' => 'Tipo de crédito que desea el prospecto',
                'name_field' => 'tipo_credito',
                'id_field' => 'tipo_credito',
                'comment_admin' => 'Categoría de crédito.',
                'comment_webApp' => '',
                'placeholder' => '',
                'type' => 'select2',
                'is_option_array' => true,
                'options' => $type_products,
                'is_required' => false,
                'is_disabled' => null
            ],
            5 => [
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
            6 => [
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
            7 => [
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
            8 => [
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
                'is_required' => false,
                'is_disabled' => null
            ],
            9 => [
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
                'is_disabled' => null
            ],
            10 => [
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
                'is_disabled' => null
            ],
            11 => [
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
                'is_disabled' => null
            ],
            12 => [
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
                'is_disabled' => null
            ],
            13 => [
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
                'is_disabled' => null
            ],
            14 => [
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
                'is_disabled' => null
            ],
            15 => [
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
                'is_disabled' => null
            ],
            16 => [
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
                'value' => '/panel/template/steps/debtCredit/'.$history_id.'/show/',
                'col' => 'col-12'
            ],
        );
        $list = \View::make('panel.module.form', ['elements' => $elements, 'name_form' => $name_form, 'history_id' => $history_id, 'id_rel' => $id_rel, 'type_form' => $type_form])->render();
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

        CurrentFinancialProduct::saveEdit($id_rel, $request, 2);

        if ($history != null) {
            $percent_form   = self::percentForm($history);
            if ($percent_form == 100) {
                HistoryLog::move($id_rel, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_REPORT, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_REPORT, null, false);
                HistoryLog::move($id_rel, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION, null, false);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM, $credit->id, 1);//*marcar como completada la tarea
                //*inicializar las acciones de la siguiente etapa en curso
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_REPORT, $credit->id, 1);
                HistoryLog::updateStatusProgress(HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION, $credit->id, 0);
            }
        }
    }

    public function listStep($history_id)
    {
        $history            = HistoryLog::find($history_id);
        $credit             = $history->historyCredit;
        $max_hour           = 12;
        $hour               = $credit->created_at;
        $percent_form       = reduceDecimal(self::percentForm($history));
        $percent_form_step2   = reduceDecimal(self::percentDesition($history));
        $percent_file       = 100;
        $color_inf_credit   = 'success';
        $color_report       = 'success';
        $option_inf_report = null;
        $menu_options       = self::menuOptionsStep($history);
        $total_percent      = $percent_file + $percent_form;
        $status_inf_credit        = 'En espera';
        $status_report        = 'En espera';
        //$percent_form = $percent_form;
        //$total_credit_percent   = $percent_file;
       
        $status_inf_credit    = ($percent_form >= 100) ? 'Concluido' : 'En curso';
        if ($percent_form == 100) {
            $status_report        = ($percent_form_step2 >= 100) ? 'Concluido' : 'En curso';
        }
        
        $total_credit_percent = ($percent_form >= 100) ? 100 : $percent_form;
        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        
        $option_inf_credit          = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['actions']])->render();
        
        $view_percent_inf_credit    = \View::make('panel.module.view_percent', ['percent' => $percent_form])->render();
        $view_count_inf_credit      = \View::make('panel.module.view_count', ['number' => 'Uno'])->render();
        $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        
        $view_percent_report        = \View::make('panel.module.view_percent', ['percent' => 0])->render();
        $view_count_report          = \View::make('panel.module.view_count', ['number' => 'Dos'])->render();
        if ($status_inf_credit == 'Concluido') {
            $option_inf_report          = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['reports']])->render();
        }
        
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

    public function listActionByStep($history_id, $step)
    {
        if ($step == 2) {
            return self::listStepReport($history_id);
        }

        return self::listAction($history_id);
    }

    public function listAction($history_id)
    {
        $history                = HistoryLog::find($history_id);
        $credit                 = $history->historyCredit;
        $advisor                = $credit->creditAdvisor;
        $percent_file           = 100;
        $percent_form           = self::percentForm($history);
        $status_percent_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
        $max_hour               = 12;
        $in_progress            = HistoryLog::getByStatus([HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM], $credit->id)[0];
        $hour                   = $in_progress->date_status_progress;
        

        $status[]               = \View::make('panel.module.status', ['status' => 'Opcional'])->render();
        $status[]               = \View::make('panel.module.status', ['status' => $status_percent_form])->render();

        $name_advisor = null;
        try {
            $user = User::find($advisor->id);
            $role = (isset(User::$alias_role[$user->getRoleNames()[0]]))? User::$alias_role[$user->getRoleNames()[0]] : '';
            $name_advisor   = $role.' - '.$advisor->name.' '.$advisor->last_name;
            if ($advisor->id == Auth::user()->id) {
                $name_advisor = 'Tú';
            }
        } catch (\Exception $th) {
            //throw $th;
        }
        

        $menu_options   = self::menuOptions($history);
        $color_inf_credit   = 'success';
        $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
        
        $color_inf_credit = $data_deadline['color'];
        $hour             = $data_deadline['lbl_hour'];

        $deadline[]  = 'N/A';
        $deadline[]  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

        $option[]  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
        $option[]  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();

        

        $name[] = 'Carga';
        $name[] = 'Formulario';
        
        $subject[] = HistoryLog::$label_subject[11];
        $subject[] = HistoryLog::$label_subject[12];

        $data_actions = array(
            HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_UPLOAD,
            HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM,
        );
      
        $get_actions = HistoryLog::getByStatus($data_actions, $credit->id);

        $link[] = '/panel/template/action-document/debtCredit/'.$history_id.'?step=1';
        $link[] = '/panel/action-form/debtCredit/'.$history_id.'/form?step=1';


        foreach ($get_actions as $key => $get_action) {
            $data[] = array(
                'name' =>  $name[$key],
                'subject' => $subject[$key],
                'status' => $status[$key],
                'deadline' => $deadline[$key],
                'advisor' => $name_advisor,
                'options' => $option[$key],
                'link' => $link[$key]
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
        $data = null;
        try {
            $in_progress            = HistoryLog::getByStatus([HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION], $credit->id)[0];
            $hour                   = $in_progress->date_status_progress;
            $menu_options           = self::menuOptionReportStep($history);
            $name_advisor           = null;
            try {
                $advisor        = $credit->creditAdvisor;
                $user           = User::find($advisor->id);
                $role           = (isset(User::$alias_role[$user->getRoleNames()[0]]))? User::$alias_role[$user->getRoleNames()[0]] : '';
                $name_advisor   = $role . ' - ' . $advisor->name . ' ' . $advisor->last_name;
            } catch (\Exception $th) {
                        //throw $th;
            }

            
        
            $name_module_response   = 'KaaxClub';
            $color_desition         = 'success';
            $data_deadline          = deadline($hour, $max_hour, 0, 'success');
            $color_desition         = $data_deadline['color'];
            $hour                   = $data_deadline['lbl_hour'];

            $deadline[]   = 'N/A';
            $deadline[]   = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_desition])->render();

            $option[]     = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['progress']])->render();
            $option[]     = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['desition']])->render();

            
            $data           = array();

            $name[]         = 'Respuesta de módulo';
            $name[]         = 'Decisión';

            $subject[]      = HistoryLog::$label_subject[13];
            $subject[]      = HistoryLog::$label_subject[15];

            $data_actions   = array(
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_REPORT,
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION,
            );
        
            $get_actions    = HistoryLog::getByStatus($data_actions, $credit->id);

            $link[] = '/panel/kc-check-up/report/answer_module/'.$history_id.'/show';
            $link[] = '/panel/kc-check-up/report/desition/'.$history_id.'/show?type=2';

            $status_percent_form    = $percent_desition == 100 ? 'Concluido' : 'En curso';
            $status[]               = \View::make('panel.module.status', ['status' => 'Concluida'])->render();
            $status[]               = \View::make('panel.module.status', ['status' => $status_percent_form])->render();


            foreach ($get_actions as $key => $get_action) {
                $data[] = array(
                    'name' =>  $name[$key],
                    'subject' => $subject[$key],
                    'status' => $status[$key],
                    'deadline' => $deadline[$key],
                    'advisor' => $name_advisor,
                    'options' => $option[$key],
                    'link' => $link[$key]
                );
            }
        } catch (\Exception $th) {
            //throw $th;
        }
        
        return $data;
    }

    public function dinamicDeadline($history)
    {
        $status_id          = $history->status_id;
        $credit             = $history->historyCredit;
        $in_progress        = HistoryLog::getByStatus([$status_id], $credit->id)[0];
        $hour               = $in_progress->date_status_progress;
        $percent            = $in_progress->status_progress / 1 * 100;
        $max_hour           = 12;
        $color_inf_credit   = '';
        $data_deadline      = deadline($hour, $max_hour, $percent, $color_inf_credit);
        $color_inf_credit   = $data_deadline['color'];
        $hour               = $data_deadline['lbl_hour'];

        $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
        return $view_dead_line_inf_credit;
    }

    public function menuOptions($history)
    {
        $menu = array(
            'form' => array(
                [
                    'link' => '/panel/template/action-document/debtCredit/'.$history->id.'?step=1',
                    'onclick' => '',
                    'name' => 'Ver acción',
                    'icon' => 'icon ni ni-check-circle-cut'
                ]
            ),
            'file' => array(
                [
                    'link' => '/panel/action-form/debtCredit/'.$history->id.'/form'.'?step=1',
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
                    'link' => '/panel/template/actions/debtCredit/'.$history->id.'/show',
                    'onclick' => '',
                    'name' => 'Lista de tareas',
                    'icon' => 'icon ni ni-view-list-wd',
                ]
            ),
            'reports' => array(
                [
                    'link' => '/panel/template/report/debtCredit/'.$history->id.'/show',
                    'onclick' => '',
                    'name' => 'Lista de tareas',
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
                    'link' => '/panel/kc-check-up/report/desition/'.$history->id.'/show?type=2',
                    'onclick' => '',
                    'name' => 'Ver acción',
                ]
            )
        );
        return $menu;
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

    public function percentForm($history)
    {
        $credit         = $history->historyCredit;
        $client         = $credit->creditClientPerson;
        $percent        = 0;
        $total_valid    = 0;
        $products = CurrentFinancialProduct::where(['id_rel' => $credit->id, 'type' => 2])->count();

        if ($credit != null && $credit->agreement_id != '' && $client != null && $client->agreement_id != '') {
            $total_valid = $total_valid + 20;
        }
        
        if ($products > 0 ) {
            $total_valid = $total_valid + 20;
        }

        if ($client != null && $client->name != null) {
            $total_valid = $total_valid + 20;
        }

        if ($client != null && $client->last_name != null) {
            $total_valid = $total_valid + 40;
        }

        
        $percent =  (100 / 100) * $total_valid;
        return $percent;
    }

    //* get all percentages of the shares
    public function getPercent($history, $show_current_show = false)
    {
        $credit     = $history->historyCredit;
        $data_actions = array(
            HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM,
            HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION,
        );
        $get_actions = HistoryLog::getByStatus($data_actions, $credit->id);
        $status_progress = 0;
        $current_show = null;
        foreach ($get_actions as $key => $get_action) {
            $status = $get_action->status_progress;
            $status_progress += $status != null ? $status : 0;
            $current_show = $status < 100 && $get_action->status_id == HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM ? 'Información del crédito': 'Reporte';
        }

        $percent =  (($status_progress) / 2) * 100;

        if ($show_current_show == true) {
            return reduceDecimal($current_show);
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
    
    public function optionBreadcumbStep($history)
    {
        $breadcumbs = array(
            0 => array(
             'title' => 'Inicio',
             'link' => '/panel/home',
             'active' => null
            ),
            1 => array(
             'title' => 'KC - Check up',
             'link' => '/panel/kc-check-up',
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
             'title' => 'KC - Check up',
             'link' => '/panel/kc-check-up',
             'active' => null
            ),
            2 => array(
                'title' => 'etapas',
                'link' => '/panel/template/steps/debtCredit/'.$history->id.'/show',
                'active' => true
            ),
            3 => array(
                'title' => 'tareas',
                'link' => '/panel/template/steps/debtCredit/'.$history->id.'/show',
                'active' => null
               ),
               4 => array(
                'title' => 'Información laboral y contacto',
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
        if ($step == 1) {
            $breadcumbs = self::optionBreadcumblistAction($history);
        }
        $view_breadcumb    = \View::make('panel.module.breadcumb', ['breadcumbs' => $breadcumbs])->render();
        return $view_breadcumb;
    }

    public function setTitle()
    {
        return 'Acción formulario';
    }
}
