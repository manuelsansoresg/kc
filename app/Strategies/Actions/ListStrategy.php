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
            ];
        }

        $history_logs = HistoryLog::getByStatus($list_actions, $id_rel);

        $data = array();
        
        foreach ($history_logs as $history_log) {
            //*saber si el usuario es admin
            $is_admin       = Auth::user()->hasRole('Administrador');
            $credit         = $history_log->historyCredit;
            $client         = $credit->creditClientPerson;
            $advisor        = $credit->creditAdvisor;
            $module         = ($history_log->status_id == 8 || $history_log->status_id == 12) ? 'KC- Check up' : '';
            $name           = $credit->id.' '.$client->last_name.' '.$client->second_last_name.' '.$client->name;
            $name_advisor   = $advisor->name.' '.$advisor->last_name;
            $max_hour       = 12;
            $hour           = Carbon::parse($credit->created_at)->hour;
            $templateStrategy   = TemplateValues::STRATEGY['newCredit']; //TODO: cambiar dinamico
            $menu_options   = (new $templateStrategy)->menuOptions($history_log);
            
            $percent_file   = (new $templateStrategy)->percentFile($history_log->id_rel);
            $percent_form   = (new $templateStrategy)->percentForm($history_log);

            

            if ($hour > 5) {
                $color_inf_credit = ($hour >= $max_hour) ? 'danger' : 'warning';
            }
            $view_dead_line_inf_credit  = \View::make('panel.module.view_dead_line', ['hour' => $hour, 'color_inf_credit' => $color_inf_credit])->render();
            $form_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['file']])->render();
            $file_option  = \View::make('panel.module.checkup.actions.add_option_dt', ['options' => $menu_options['form']])->render();

            $option = ($history_log->status_id == 7) ? $file_option : $form_option;

            if ($is_admin) {

                if ($name_status == 'completed' && ($percent_file == 100 || $percent_form == 100)) {
                    $data[] = array(
                        'action' => HistoryLog::$label_status[$history_log->status_id],
                        'module' => $module,
                        'name' => $name,
                        'deadline' => $view_dead_line_inf_credit,
                        'advisor' => $name_advisor,
                        'options' => $option,
                    );
                } elseif ($name_status == 'in_progress' && ($percent_file < 100 || $percent_form < 100)) {
                    $data[] = array(
                        'action' => HistoryLog::$label_status[$history_log->status_id],
                        'module' => $module,
                        'name' => $name,
                        'deadline' => $view_dead_line_inf_credit,
                        'advisor' => $name_advisor,
                        'options' => $option,
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
                        );
                    } elseif ($name_status == 'in_progress' && ($percent_file < 100 || $percent_form < 100)) {
                        $data[] = array(
                            'action' => HistoryLog::$label_status[$history_log->status_id],
                            'module' => $module,
                            'name' => $name,
                            'deadline' => $view_dead_line_inf_credit,
                            'advisor' => $name_advisor,
                            'options' => $option,
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
