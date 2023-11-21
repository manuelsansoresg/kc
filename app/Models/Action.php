<?php

namespace App\Models;

use App\Lib\Slack;
use App\Strategies\Values\ActionValues;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Action extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'subject',
        'section',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'description',
        'advisor_id',
        'id_rel',
        'status',
        'is_notification_slack',
    ];

    const STATUS = [
        'in_progress' => 0,
        'completed' => 1,
        'credit_in_progress' => 2,
        'credit_completed' => 2,
    ];
    const MODEL = [
        'lead' => 1,
        'credit' => 2,
    ];
    
    const KEY_MODEL = [
        1 => 'lead',
        2 => 'credit',
    ];
    const NAME_MODEL = [
        1 => 'Prospectos',
        2 => 'Creditos',
    ];

    public static function saveEdit($request)
    {
        $data = $request->data;
        $data['start_time'] = date('H:i:s', strtotime($data['start_time']));
        if (isset($data['end_time'])) {
            $data['end_time'] = date('H:i:s', strtotime($data['end_time']));
        }
        $action = null;

        if ($request->action_id == 'null') {
            $action = Action::create($data);
        } else {
            $action = Action::find($request->action_id);
            $action->fill($data);
            $action->update();
        }

        //*assign advisor if not exist in lead
        $lead = Lead::find($data['id_rel']);
        if ($lead != null && $lead->asesor_id == '') {
            $lead->asesor_id = $data['advisor_id'];
            $lead->update();
            
        }

        return $action;
    }

    public static function accionesVencidas()
    {

        $now = now();  // Obtener la fecha y hora actual del servidor
        $actionsProximasOVencidas = Action::
            where('is_notification_slack', 0)
            ->where(function ($query) use ($now) {
                $query->where(function ($query) use ($now) {
                    // Filtra las acciones que están programadas para ejecutarse en este momento o que ya deberían haberse ejecutado
                    $query->where(function ($query) use ($now) {
                        $query->whereDate('start_date', '=', $now->toDateString())
                            ->whereTime('start_time', '<=', $now->format('H:i'));
                    });
                })
                ->orWhere(function ($query) use ($now) {
                    // Filtra las acciones que ya han vencido (han pasado su fecha y hora de finalización)
                    $query->whereDate('start_date', '<', $now->toDateString());
                });
            })->get();
        
        foreach ($actionsProximasOVencidas as $actionsProximasOVencida) {
            $title = 'Acción prospecto';
            if ($actionsProximasOVencida->section == 1 ) {
                $lead = Lead::find($actionsProximasOVencida->id_rel);
                $name = $lead->name.' '. $lead->last_name;
            } else {
                $credit = Credit::find($actionsProximasOVencida->id_rel);
                $client = $credit->creditClientPerson;
                $name = $client->name.' '. $client->last_name;
                $title = 'Acción módulo';
            }

            if ($lead != null) {
                
                $type    = isset(config('enums.type_actions')[$actionsProximasOVencida->type])? config('enums.type_actions')[$actionsProximasOVencida->type] : null;
                $notification_slack = new Slack('kaaxClub', $title.' - '.$type.' - '.$name);
                $notification_slack->sendMessage();
    
                $get_action = Action::find($actionsProximasOVencida->id);
                $get_action->is_notification_slack = 1;
                $get_action->update();
            }
        }
    }

    public static function getByModel($id_rel, $model, $status = 0)
    {
        return Action::where(['id_rel' => $id_rel, 'section'=> $model, 'status' => $status])->get();
    }
    
    public static function getByStatus($status = 0, $model = 1)
    {
        return Action::where(['status' => $status, 'section' => $model])->get();
    }

    public static function updateByModel($id, $status=1)
    {
        $action = Action::find($id);
        $action->status = $status;
        $action->update();
        return $action;
    }

    public static function getById($id, $model)
    {
        
        $path_model   = ActionValues::STRATEGY[$model];
        $action   = new $path_model;
        $get_action = $action->get($id);
        $get_advisor = $action->getAdvisor($get_action->advisor_id);
        $get_lead = $action->getLead($get_action->id_rel);
        $data_action = array(
            'action' => $get_action,
            'advisor' => $get_advisor,
            'lead' => $get_lead
        );
        return $data_action;
    }

    public static function listDt($status, $model)
    {
        $status         = Action::STATUS[$status];
        $list_actions   = Action::getByStatus($status, $model);
        $data           = array();
        foreach ($list_actions as $list_action) {
            $model          = Action::KEY_MODEL[$list_action->section];
            $get_strategy   = ActionValues::STRATEGY[$model];
            $data[]           = (new $get_strategy)->listDt($status, $list_action);
        }
        return $data;
    }
}
