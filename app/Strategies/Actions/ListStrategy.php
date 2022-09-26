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
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM,
                HistoryLog::KC_CHECK_UP_ACTION_DESITION,
                HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION,
            ];
        }

        $history_logs = HistoryLog::getByStatus($list_actions, $id_rel);

        $data = array();
        
        foreach ($history_logs as $history_log) {
            //*saber si el usuario es admin
            $is_admin   = Auth::user()->hasRole('Administrador');
            $is_adviser = Auth::user()->hasRole('Asesor');
            $credit         = $history_log->historyCredit;
            $client         = $credit->creditClientPerson;
            $advisor        = $credit->creditAdvisor;
            $module         = ($history_log->status_id == 8 || $history_log->status_id == 12 || $history_log->status_id == 14 || $history_log->status_id == 15) ? 'KC- Check up' : '';
            $name           = $credit->id.' '.$client->last_name.' '.$client->second_last_name.' '.$client->name;
            $name_advisor   = $advisor->name.' '.$advisor->last_name;
            $max_hour       = 12;
            $hour           = Carbon::parse($credit->created_at)->hour;
            $templateStrategy   = TemplateValues::STRATEGY['newCredit']; //TODO: cambiar dinamico
            $menu_options   = (new $templateStrategy)->menuOptions($history_log);
            
            $percent_file   = (new $templateStrategy)->percentFile($history_log->id_rel);
            $percent_form   = (new $templateStrategy)->percentForm($history_log);

            $user = User::find($advisor->id);
            $role = (isset(User::$alias_role[$user->getRoleNames()[0]]))? User::$alias_role[$user->getRoleNames()[0]] : '';

            $name_responsable   = $role.' - '.$advisor->name.' '.$advisor->last_name;

            if ($advisor->id == Auth::user()->id) {
                $name_responsable = 'Tú';
            }
            $color_inf_credit = 'success';

            $data_deadline    = deadline($hour, $max_hour, $percent_form, $color_inf_credit);
            $color_inf_credit = $data_deadline['color'];
            $hour             = $data_deadline['hour'];

            if ($history_log->status_id === HistoryLog::KC_CHECK_UP_ACTION_FORM || $history_log->status_id === HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM) {
                $status_form    = $percent_form == 100 ? 'Concluido' : 'En curso';
            }

            if ($history_log->status_id === HistoryLog::KC_CHECK_UP_ACTION_DESITION || $history_log->status_id === HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_DESITION) {
                $status_form = 'En curso';
            }

            $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
            $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

            $option = ($history_log->status_id == 7) ? $file_option : $form_option;

            //TODO:  si eres admin o asesor debes poder ver todos y si no solo puedes ver los tuyos como responsable revisar cual campo sera el responsable

            if ($is_admin) {
                if ($name_status == 'completed' && ($percent_file == 100 || $percent_form == 100)) {
                    $data[] = array(
                        'action' => HistoryLog::$label_status[$history_log->status_id],
                        'module' => $module,
                        'name' => $name,
                        'deadline' => $view_dead_line_inf_credit,
                        'advisor' => $name_advisor,
                        'options' => $option,
                        'responsable' => $name_responsable,
                        'status' => $status_form
                    );
                } elseif ($name_status == 'in_progress' && ($percent_file < 100 || $percent_form < 100)) {
                    $data[] = array(
                        'action' => HistoryLog::$label_status[$history_log->status_id],
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
                    if ($name_status == 'completed' && ($percent_file == 100 || $percent_form == 100)) {
                        $data[] = array(
                            'action' => HistoryLog::$label_status[$history_log->status_id],
                            'module' => $module,
                            'name' => $name,
                            'deadline' => $view_dead_line_inf_credit,
                            'advisor' => $name_advisor,
                            'options' => $option,
                            'responsable' => $name_responsable,
                            'status' => $status_form
                        );
                    } elseif ($name_status == 'in_progress' && ($percent_file < 100 || $percent_form < 100)) {
                        $data[] = array(
                            'action' => HistoryLog::$label_status[$history_log->status_id],
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
