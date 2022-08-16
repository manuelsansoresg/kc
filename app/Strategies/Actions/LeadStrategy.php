<?php
namespace App\Strategies\Actions;

use App\Models\Action;
use App\Models\Lead;
use App\Models\User;
use App\Strategies\ActionInterface;
use Illuminate\Support\Facades\DB;

class LeadStrategy implements ActionInterface
{
    public $lead;
    public $advisor;

    public function get($id)
    {
        $action = Action::select(
            'id',
            'type',
            'subject',
            'start_date',
            DB::raw('TIME_FORMAT(start_time, "%h:%i %p") as start_time'),
            'end_date',
            DB::raw('TIME_FORMAT(end_time, "%h:%i %p") as end_time'),
            'description',
            'advisor_id',
            'id_rel',
            'section',
            'status',
        )->where('id', $id)->first();
        if ($action != null) {
            $this->advisor = User::find($action->advisor_id);
            $this->lead = Lead::find($action->id_rel);
        }
        return $action;
    }

    public function getAdvisor()
    {
        return $this->advisor;
    }

    public function getLead()
    {
        return $this->lead;
    }
    public function list($id, $model, $status)
    {
        $status   = Action::STATUS[$status];
        $model    = Action::MODEL[$model];
        
        $actions   = Action::getByModel($id, $model, $status);
        $list = \View::make('panel.action.list_action', [ 'actions' => $actions, 'status' => $status, 'model' => $model])->render();
        return $list;
    }
    /**
     * print dinamic datatable action #dt-acctions
     *
     * @param object $model_action model
     * @return void
     */
    public function listDt($status, $model_action)
    {
        $lead           = Lead::find($model_action->id_rel);
        $advisor        = User::find($model_action->advisor_id);
        $type_actions   = config('enums.type_actions');
        $data_option = array(
            'status' => $status,
            'model' => $model_action
        );
        $option         = \View::make('panel.action.add_option_dt', $data_option)->render();

        $data = array(
            'type' => $type_actions[$model_action->type],
            'subject' => $model_action->subject,
            'section' => Action::NAME_MODEL[$model_action->section],
            'name' => $lead->name.' '.$lead->last_name,
            'date_in' => formatDateNameMonth($model_action->start_date),
            'date_fin' => formatDateNameMonth($model_action->end_date),
            'advisor' => $advisor->name,
            'options' => $option
        );
        return $data;
    }
}
