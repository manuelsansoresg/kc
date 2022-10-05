<?php

namespace App\Models;

use App\Strategies\Values\SendNotificationsValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_rel',
        'title',
        'body',
        'model',
        'status' //* 0 = enviado pero no recibido 1 = enviado y recibido
    ];

    //* constante para modelos
    const CREATE_PROSPECT         = 1;
    const ADD_PROSPECT            = 2;
    const BTN_NEXT_LEAD           = 3;

    public static function getByModel($model, $status = null)
    {
        $notification = Notification::
                        wherein('model', $model);
        if ($status != null) {
            $notification->where('status', $status);
        }
        $notification->orderBy('created_at', 'desc');
        return $notification->get();
    }

    public function notificationCredit()
    {
        return $this->belongsTo(Credit::class, 'id_rel');
    }
    
    public static function getMyNotifications($limit = null)
    {
        $user_id = Auth::user()->id;
        
        $lead_new_prospect        = SendNotificationsValues::STRATEGY['leadNewProspect'];
        $list_lead_new_prospect   = (new $lead_new_prospect)->get($user_id, null);

        $lead_add_prospect        = SendNotificationsValues::STRATEGY['leadAddProspect'];
        $list_lead_add_prospect   = (new $lead_add_prospect)->get($user_id, null);

        $btn_next_lead            = SendNotificationsValues::STRATEGY['btnNextLead'];
        $list_btn_next_lead       = (new $btn_next_lead)->get($user_id, null);
        
        $newCredit                = SendNotificationsValues::STRATEGY['newCredit'];
        $list_newCredit           = (new $newCredit)->get($user_id, null);
        
        $debt_reduction           = SendNotificationsValues::STRATEGY['debtReduction'];
        $list_debt_reduction      = (new $debt_reduction)->get($user_id, null);

        $list_notificacions = array_merge(
            $list_lead_new_prospect,
            $list_lead_add_prospect,
            $list_btn_next_lead,
            $list_newCredit,
            $list_debt_reduction,
        );
        
        $new_list = array();
        $cont = 0;
        
        foreach ($list_notificacions as $notification) {
            $cont = $cont + 1;
            if ($limit != null  && $limit == $cont) {
                break;
            }
            $new_list[$notification['id']] = $notification;
        }
        arsort($new_list);
        return $new_list;
    }
}
