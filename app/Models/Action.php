<?php

namespace App\Models;

use App\Strategies\Values\ActionValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Action extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'subject',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'description',
        'advisor_id',
        'id_rel',
        'section',
        'status',
    ];

    const STATUS = [
        'programed' => 0,
        'completed' => 1,
    ];
    const MODEL = [
        'lead' => 1,
    ];

    public static function saveEdit($request)
    {
        $data = $request->data;
        $data['start_time'] = date('H:i:s', strtotime($data['start_time']));
        $data['end_time'] = date('H:i:s', strtotime($data['end_time']));
        if ($request->action_id == null) {
            $action = Action::create($data);
        } else {
            $action = Action::find($request->action_id);
            $action->fill($data);
            $action->update();
        }
        return $action;
    }

    public static function getByModel($id_rel, $model, $status = 0)
    {
        return Action::where(['id_rel' => $id_rel, 'section'=> $model, 'status' => $status])->get();
    }

    public static function updateByModel($id)
    {
        $action = Action::find($id);
        $action->status = 1;
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

}
