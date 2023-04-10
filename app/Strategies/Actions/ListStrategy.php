<?php
namespace App\Strategies\Actions;

use App\Models\Action;
use App\Models\CreditNotes;
use App\Models\CreditTag;
use App\Models\HistoryLog;
use App\Models\Lead;
use App\Models\LeadNote;
use App\Models\Note;
use App\Models\User;
use App\Strategies\ActionInterface;
use App\Strategies\Values\TemplateValues;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListStrategy implements ActionInterface
{
    /**
     * List all actions in modules
     *
     * @param string $name_status
     * @return void
     */
    public function get($name_status, $list_actions = null, $id_rel = null)
    {
        if ($list_actions === null) {
            $list_actions = [

                HistoryLog::KC_CHECK_UP_ACTION_FORM,
                HistoryLog::KC_CHECK_UP_ACTION_DESITION,
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM,
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION,

                HistoryLog::KC_CONTROL_DESK_UPLOAD,
                HistoryLog::KC_CONTROL_DESK_FORM,

                HistoryLog::KC_CONTROL_DESK_FORM_STEP_2,

                HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1,
                HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1,
                HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2,
                
                HistoryLog::KC_CONTROL_DESK_FORM_STEP_4,
                HistoryLog::KC_CONTROL_DESK_FORM_STEP_5,

                HistoryLog::KC_SWAP_UPLOAD,
                HistoryLog::KC_SWAP_FORM,
                HistoryLog::KC_SWAP_UPLOAD_2,
                
                HistoryLog::KC_SWAP_FORM_STEP_2,
                HistoryLog::KC_SWAP_FORM_STEP_2_2,
                HistoryLog::KC_SWAP_UPLOAD_STEP_2_3,
                HistoryLog::KC_SWAP_FORM_STEP_2_3,
                
                HistoryLog::KC_SWAP_UPLOAD_STEP_3,
                HistoryLog::KC_SWAP_FORM_STEP_3,
                HistoryLog::KC_SWAP_FORM_STEP_3_2,
                
                HistoryLog::KC_DELIVERY_FORM,
                HistoryLog::KC_DELIVERY_FORM_STEP_3,
                
                //HistoryLog::KC_AFTER_FORM,
                
            ];
        }

        $history_logs = HistoryLog::getByStatus($list_actions, $id_rel);
        $data = array();
        $array_model = array('newCredit' => 'KC- Check up', 'debtCredit' => 'KC- Check up', 'controlDesk' => 'KC- Control desk', 'delivery' => 'Delivery', 'swap' => 'swap',  'afterMarket' => 'After Market');

        foreach ($history_logs as $history_log) {
            //*saber si el usuario es admin
            $is_admin       = Auth::user()->hasRole('Administrador');
            $is_adviser     = Auth::user()->hasRole('Asesor');
            $credit         = $history_log->historyCredit;
            $client         = $credit->creditClientPerson;
            $advisor        = $credit->creditAdvisor;
            $model          = HistoryLog::$name_model[$history_log->status_id];

            $module         = $array_model[$model];
            $percent_file    = null;
            $percent_form    = null;
            $file_option    = null;
            $file_option    = null;
            

            $name           = $credit->id.' '.$client->last_name.' '.$client->second_last_name.' '.$client->name;
            $name_advisor = null;
            $name_responsable = null;

            try {
                $name_advisor   = $advisor->name.' '.$advisor->last_name;
                $user = User::find($advisor->id);
                $role = (isset(User::$alias_role[$user->getRoleNames()[0]]))? User::$alias_role[$user->getRoleNames()[0]] : '';
                $name_responsable   = $role.' - '.$advisor->name.' '.$advisor->last_name;
                if ($advisor->id == Auth::user()->id) {
                    $name_responsable = 'Tú';
                }
            } catch (\Exception $th) {
                //throw $th;
            }

            $max_hour       = 12;
            $hour           = $credit->created_at;
            $templateStrategy   = TemplateValues::STRATEGY[$model];
            
          

            $menu_options   = (new $templateStrategy)->menuOptions($history_log);
            
            try {
                $percent_file   = (new $templateStrategy)->percentFile($history_log->id_rel);
                $percent_form   = (new $templateStrategy)->percentForm($history_log);
                $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
                $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();
            } catch (\Throwable $th) {
                //throw $th;
            }

            
           

            
            $color_inf_credit = '';
            //TODO: change when the decision develops 
            $status_form                  = $percent_form == 100 ? 'Concluido' : 'En curso';
            $data_deadline                = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit             = $data_deadline['color'];
            $hour                         = $data_deadline['lbl_hour'];

            $view_dead_line_inf_credit    = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();

           /*  if ($history_log->status_id === HistoryLog::KC_CHECK_UP_ACTION_FORM || $history_log->status_id === HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM) {
            } */
            if ($history_log->status_id === HistoryLog::KC_CHECK_UP_ACTION_FORM || $history_log->status_id === HistoryLog::KC_CHECK_UP_ACTION_DESITION
                || $history_log->status_id === HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM || $history_log->status_id === HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION) {
                $view_dead_line_inf_credit =  (new $templateStrategy)->dinamicDeadline($history_log);
            }

            if ($history_log->status_id === HistoryLog::KC_CHECK_UP_ACTION_DESITION || $history_log->status_id === HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION) {
                $status_form =  $credit->applied_financial != '' ? 'Concluido' : 'En curso';
                $percent_form = $credit->applied_financial != '' ? 100 : 0;
                $menu_options   = (new $templateStrategy)->menuOptionReportStep($history_log);
                $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['desition']])->render();
            }

            if ($history_log->status_id === HistoryLog::KC_CONTROL_DESK_UPLOAD
                || $history_log->status_id === HistoryLog::KC_CONTROL_DESK_FORM
                || $history_log->status_id === HistoryLog::KC_CONTROL_DESK_FORM_STEP_2
                || $history_log->status_id === HistoryLog::KC_CONTROL_DESK_UPLOAD_3_1
                || $history_log->status_id === HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_1
                || $history_log->status_id === HistoryLog::KC_CONTROL_DESK_FORM_STEP_3_2
                || $history_log->status_id === HistoryLog::KC_CONTROL_DESK_FORM_STEP_4
                || $history_log->status_id === HistoryLog::KC_CONTROL_DESK_FORM_STEP_5
                ) {
                    $get_dinamic_percent =  (new $templateStrategy)->dinamicDeadline($history_log);
                    $view_dead_line_inf_credit = $get_dinamic_percent['deadline'];
                    $percent_form = $get_dinamic_percent['percent'];
                    $form_option = $get_dinamic_percent['menu'];
                    $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
            }

            if ($history_log->status_id === HistoryLog::KC_SWAP_UPLOAD
                || $history_log->status_id === HistoryLog::KC_SWAP_FORM
                || $history_log->status_id === HistoryLog::KC_SWAP_UPLOAD_2
                || $history_log->status_id === HistoryLog::KC_SWAP_FORM_STEP_2
                || $history_log->status_id === HistoryLog::KC_SWAP_FORM_STEP_2_2
                || $history_log->status_id === HistoryLog::KC_SWAP_UPLOAD_STEP_2_3
                || $history_log->status_id === HistoryLog::KC_SWAP_FORM_STEP_2_3
                || $history_log->status_id === HistoryLog::KC_SWAP_UPLOAD_STEP_3
                || $history_log->status_id === HistoryLog::KC_SWAP_FORM_STEP_3
                || $history_log->status_id === HistoryLog::KC_SWAP_FORM_STEP_3_2
                ) {
                    $get_dinamic_percent =  (new $templateStrategy)->dinamicDeadline($history_log);
                    $view_dead_line_inf_credit = $get_dinamic_percent['deadline'];
                    $percent_form = $get_dinamic_percent['percent'];
                    $form_option = $get_dinamic_percent['menu'];
                    $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
            }
            
            
            if ($history_log->status_id === HistoryLog::KC_DELIVERY_FORM ||  $history_log->status_id === HistoryLog::KC_DELIVERY_FORM_STEP_3) {
                $get_dinamic_percent =  (new $templateStrategy)->dinamicDeadline($history_log);
                $view_dead_line_inf_credit = $get_dinamic_percent['deadline'];
                $percent_form = $get_dinamic_percent['percent'];
                $form_option = $get_dinamic_percent['menu'];
                $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
            }
           
            if ($history_log->status_id === HistoryLog::KC_AFTER_FORM) {
                $get_dinamic_percent =  (new $templateStrategy)->dinamicDeadline($history_log);
                $view_dead_line_inf_credit = $get_dinamic_percent['deadline'];
                $percent_form = $get_dinamic_percent['percent'];
                $form_option = $get_dinamic_percent['menu'];
                $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
            }
            $option = ($history_log->status_id == 7) ? $file_option : $form_option;

            //TODO:  si eres admin o asesor debes poder ver todos y si no solo puedes ver los tuyos como responsable revisar cual campo sera el responsable
            $subject = isset(HistoryLog::$label_subject[$history_log->status_id])? HistoryLog::$label_subject[$history_log->status_id] : null;
            if ($is_admin) {
                if ($name_status == 'completed' && ($percent_form == 100)) {
                    $data[] = array(
                        'action' => HistoryLog::$label_status[$history_log->status_id],
                        'subject' => $subject,
                        'module' => $module,
                        'name' => $name,
                        'deadline' => $view_dead_line_inf_credit,
                        'advisor' => $name_advisor,
                        'options' => $option,
                        'responsable' => $name_responsable,
                        'status' => $status_form
                    );
                } elseif ($name_status == 'in_progress' && ($percent_form < 100)) {
                    $data[] = array(
                        'action' => HistoryLog::$label_status[$history_log->status_id],
                        'subject' => $subject,
                        'module' => $module,
                        'name' => $name,
                        'deadline' => $view_dead_line_inf_credit,
                        'advisor' => $name_advisor,
                        'options' => $option,
                        'responsable' => $name_responsable,
                        'status' => $status_form
                    );
                }
            } else {
                if (Auth::user()->id == $advisor->id) {
                    if ($name_status == 'completed' && ($percent_form == 100)) {
                        $data[] = array(
                            'action' => HistoryLog::$label_status[$history_log->status_id],
                            'subject' => $subject,
                            'module' => $module,
                            'name' => $name,
                            'deadline' => $view_dead_line_inf_credit,
                            'advisor' => $name_advisor,
                            'options' => $option,
                            'responsable' => $name_responsable,
                            'status' => $status_form
                        );
                    } elseif ($name_status == 'in_progress' && ($percent_form < 100)) {
                        $data[] = array(
                            'action' => HistoryLog::$label_status[$history_log->status_id],
                            'subject' => $subject,
                            'module' => $module,
                            'name' => $name,
                            'deadline' => $view_dead_line_inf_credit,
                            'advisor' => $name_advisor,
                            'options' => $option,
                            'responsable' => $name_responsable,
                            'status' => $status_form
                        );
                    }
                }
            }
        }
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
}
