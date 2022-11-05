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
        'status' //* 0 = enviado pero no leido 1 = enviado y leido
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

    public static function showMyNotification($limit)
    {
        $notifications = self::getMyNotifications($limit);
        $list = $notifications['list'];
        $content_notification   = \View::make('panel.notification', [ 'notifications' => $list])->render();
        $data = array('list' => $content_notification, 'is_notification' => $notifications['is_notification']);
        return $data;
    }

    public static function readAllMyNotification()
    {
        $notifications = self::getMyNotifications();
        $list = $notifications['list'];
        foreach ($list as $notification) {
            $id = $notification['id'];
            $getNotification = Notification::find($id);
            $getNotification->status = 1;
            $getNotification->update();
        }
    }
    

    public static function getMyNotifications($limit = null)
    {
        $user_id = Auth::user()->id;
        $is_notification = 0;
        
        $lead_new_prospect        = SendNotificationsValues::STRATEGY['leadNewProspect'];
        $list_lead_new_prospect   = (new $lead_new_prospect)->get($user_id, 0);

        $lead_add_prospect        = SendNotificationsValues::STRATEGY['leadAddProspect'];
        $list_lead_add_prospect   = (new $lead_add_prospect)->get($user_id, 0);
       
        $new_kc_check_up           = SendNotificationsValues::STRATEGY['pushNewCreditKcCheckUp'];
        $list_new_kc_check_up      = (new $new_kc_check_up)->get($user_id, 0);
        
        $new_kc_control_desk           = SendNotificationsValues::STRATEGY['pushCreditKcControlDesk'];
        $list_new_kc_control_desk      = (new $new_kc_control_desk)->get($user_id, 0);
        
        $new_kc_delivery           = SendNotificationsValues::STRATEGY['pushCreditKcDelivery'];
        $list_new_new_kc_delivery      = (new $new_kc_delivery)->get($user_id, 0);

        $list_notificacions = array_merge(
            $list_lead_new_prospect,
            $list_lead_add_prospect,
            $list_new_kc_check_up,
            $list_new_kc_control_desk,
            $list_new_new_kc_delivery
        );
        
        $list_no_order = array();
        $new_list = array();
        $cont = -1;
        
        foreach ($list_notificacions as $notification_no_order) {
            $list_no_order[$notification_no_order['created_at'].$notification_no_order['id']] = $notification_no_order;
        }
        krsort($list_no_order);
        foreach ($list_no_order as $notification) {
            $cont = $cont + 1;
            if ($limit != null  && $limit == $cont) {
                break;
            }
            if ($notification['status'] == 0) {
                $is_notification = 1;
            }
            $new_list[$notification['id'] ] = $notification;
        }
        //dd($list_no_order, $new_list);
        $data = array('list' => $new_list, 'is_notification' => $is_notification);
        return $data;
    }

    public function notificationCredit()
    {
        return $this->belongsTo(Credit::class, 'id_rel');
    }
}
