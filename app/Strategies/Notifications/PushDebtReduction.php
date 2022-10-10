<?php

namespace App\Strategies\Notifications;

use App\Models\HistoryLog;
use App\Models\Notification;
use App\Strategies\Notifications\Models\Pusher;
use App\Strategies\SendNotificationsInterface;
use Illuminate\Support\Facades\Auth;

class PushDebtReduction implements SendNotificationsInterface
{
    public function send($id, $type = 1)
    {
        $title = 'Acciones';
        $body = 'Tienes una nueva acción';
        $model = HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM;
        if ($type == 2) {
            $body = 'Se generó un reporte en KC - Check up';
            $model = HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_REPORT;
        }

        $data_notification = array(
            'id_rel' => $id,
            'title' => $title,
            'body' => $body,
            'model' => $model ,
        );

        $is_exist = Notification::where($data_notification)->count();
        if ($is_exist == 0) {
            Notification::create($data_notification);
            $push  = new Pusher;
            $push->send(['model' => 'leadNewProspect']);
        }
    }
    
    public function get($user_id = null, $status = 0)
    {
        $get_notifications = Notification::getByModel([HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_FORM, HistoryLog::KC_CHECK_UP_DEBT_REDUCTION_REPORT]);
        $notifications = array();
        foreach ($get_notifications as $notification) {
            $credit = $notification->notificationCredit;
            $advisor = $credit->creditAdvisor;
            $toast  = \View::make('panel.toast', ['title' => $notification->title, 'body' => $notification->body])->render();
            $data_array = array(
                'user_id' => $advisor->id,
                'title' => $notification->title,
                'body' => $notification->body,
                'toast' => $toast,
                'id' => $notification->id,
                'created_at' => date('Y-m-d H:i:s', strtotime($notification->created_at)),
                'date' => $notification->created_at,
                'status' => $notification->status,
            );
            if ($advisor->id == Auth::user()->id) {
                if ($user_id == null) {
                    $notifications[] = $data_array;
                } elseif ($user_id != null && $user_id == $advisor->id) {
                    $notifications[] = $data_array;
                }
            }
            //*activate recieve push
           /*  $get_notification = Notification::find($notification->id);
            $get_notification->status = 1;
            $get_notification->update(); */
        }
        return $notifications;
    }
}
