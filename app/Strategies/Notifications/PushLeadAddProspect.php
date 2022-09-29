<?php

namespace App\Strategies\Notifications;

use App\Models\Lead;
use App\Models\Notification;
use App\Strategies\Notifications\Models\Pusher;
use App\Strategies\SendNotificationsInterface;

class PushLeadAddProspect implements SendNotificationsInterface
{
    public function send($id)
    {
        $data_notification = array(
            'id_rel' => $id,
            'title' => 'Prospectos',
            'body' => 'Se te ha asignado un prospecto persona',
            'model' => Notification::ADD_PROSPECT,
        );
        Notification::create($data_notification);
        $push  = new Pusher;
        $push->send(['model' => 'leadAddProspect']);
    }
    
    public function get($user_id = null, $status = 0)
    {
        $get_notifications = Notification::getByModel([Notification::ADD_PROSPECT]);
        $notifications = array();
        foreach ($get_notifications as $notification) {
            $lead     = Lead::find($notification->id_rel);
            if ($lead != null) {
                $data_array = array(
                    'user_id' => $lead->asesor_id,
                    'title' => $notification->title,
                    'body' => $notification->body,
                    'id' => $notification->id,
                    'created_at' => $notification->created_at,
                );
                if ($user_id == null) {
                    $notifications[] = $data_array;
                } elseif ($user_id != null && $user_id == $lead->id) {
                    $notifications[] = $data_array;
                }
            }
            //*activate recieve push
            $get_notification = Notification::find($notification->id);
            $get_notification->status = 1;
            $get_notification->update();
        }
        return $notifications;
    }
}
