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
    ];
    const MODEL = [
        'lead' => 1,
    ];
    
    const KEY_MODEL = [
        1 => 'lead',
    ];
    const NAME_MODEL = [
        1 => 'Prospectos',
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

        //*assign advisir if not exist in lead
        $lead = Lead::find($data['id_rel']);
        if ($lead != null && $lead->asesor_id == '') {
            $lead->asesor_id = $data['advisor_id'];
            $lead->update();
            
        }

        return $action;
    }

    public static function accionesVencidas()
    {

        // Obtiene la fecha y hora actual del servidor
        $now = Carbon::now();

        // Define la cantidad de minutos que deseas verificar
        $minutosDeseados = 10;

        // Calcula la fecha y hora límite para las acciones que faltan 10 minutos o menos para vencer
        $limiteFuturo = $now->copy()->addMinutes($minutosDeseados);

        // Calcula la fecha y hora límite para las acciones que ya han vencido (pasaron los 10 minutos)
        $limitePasado = $now->copy()->subMinutes($minutosDeseados);

        // Obtiene todas las acciones que faltan 10 minutos o menos para vencer o que ya han pasado esos 10 minutos
        $actionsProximasOVencidas = Action::
            where('is_notification_slack', 0)
            ->where(function ($query) use ($now, $limiteFuturo, $limitePasado) {
            $query->where(function ($query) use ($now, $limiteFuturo) {
                // Filtra las acciones que faltan 10 minutos o menos para vencer
                $query->whereDate('start_date', '=', $now->toDateString())
                    ->whereTime('start_time', '>', $now->toTimeString())
                    ->whereTime('start_time', '<=', $limiteFuturo->toTimeString());
            })->orWhere(function ($query) use ($limitePasado, $now) {
                // Filtra las acciones que ya han vencido (pasaron los 10 minutos)
                $query->whereDate('start_date', '=', $now->toDateString())
                    ->whereTime('start_time', '<', $limitePasado->toTimeString());
            });
        })->get();

        foreach ($actionsProximasOVencidas as $actionsProximasOVencida) {
            $lead = Lead::find($actionsProximasOVencida->id_rel);
            $name = $lead->name.''. $lead->last_name;
            $type    = isset(config('enums.type_actions')[$actionsProximasOVencida->type])? config('enums.type_actions')[$actionsProximasOVencida->type] : null;
            $notification_slack = new Slack('kaaxClub', 'Acción prospecto - '.$type.' - '.$name);
            $notification_slack->sendMessage();

            $get_action = Action::find($actionsProximasOVencida->id);
            $get_action->is_notification_slack = 1;
            $get_action->update();
        }
    }

    public static function getByModel($id_rel, $model, $status = 0)
    {
        return Action::where(['id_rel' => $id_rel, 'section'=> $model, 'status' => $status])->get();
    }
    
    public static function getByStatus($status = 0)
    {
        return Action::where(['status' => $status])->get();
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

    public static function listDt($status)
    {
        $status         = Action::STATUS[$status];
        $list_actions   = Action::getByStatus($status);
        $data           = array();
        foreach ($list_actions as $list_action) {
            $model          = Action::KEY_MODEL[$list_action->section];
            $get_strategy   = ActionValues::STRATEGY[$model];
            $data[]           = (new $get_strategy)->listDt($status, $list_action);
        }
        return $data;
    }
}
