<?php

namespace App\Strategies\Notifications;

use App\Models\HistoryLog;
use App\Models\Notification;
use App\Models\User;
use App\Strategies\Notifications\Models\Pusher;
use App\Strategies\SendNotificationsInterface;

class PushnewCredit implements SendNotificationsInterface
{
    public function send($id)
    {
        $data_notification = array(
            'id_rel' => $id,
            'title' => 'Acción',
            'body' => 'Tienes una nueva acción',
            'model' => HistoryLog::KC_CHECK_UP_ACTION_FORM,
        );
        Notification::create($data_notification);
        $push  = new Pusher;
        $push->send(['model' => 'leadNewProspect']);
    }
    
    public function get()
    {
        $get_notifications = Notification::getByModel(HistoryLog::KC_CHECK_UP_ACTION_FORM);
        $notifications = array();
        foreach ($get_notifications as $notification) {
            $credit = $notification->notificationCredit;
            $advisor = $credit->creditAdvisor;

            $notifications[] = array(
                'user_id' => $advisor->id,
                'title' => $notification->title,
                'body' => $notification->body,
            );

            //*activate recieve push
            $get_notification = Notification::find($notification->id);
            $get_notification->status = 1;
            $get_notification->update();
        }
        return $notifications;
    }
}
