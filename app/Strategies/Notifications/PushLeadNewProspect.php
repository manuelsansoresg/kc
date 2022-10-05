<?php

namespace App\Strategies\Notifications;

use App\Models\Notification;
use App\Models\User;
use App\Strategies\Notifications\Models\Pusher;
use App\Strategies\SendNotificationsInterface;

class PushLeadNewProspect implements SendNotificationsInterface
{
    public function send($id)
    {
        $data_notification = array(
            'id_rel' => $id,
            'title' => 'Prospectos',
            'body' => 'Se ha creado un nuevo prospecto persona',
            'model' => Notification::CREATE_PROSPECT,
        );
        Notification::create($data_notification);
        $push  = new Pusher;
        $push->send(['model' => 'leadNewProspect']);
    }
    
    public function get($user_id = null, $status = 0)
    {
        $get_notifications = Notification::getByModel([Notification::CREATE_PROSPECT]);
        $notifications = array();
        foreach ($get_notifications as $notification) {
            $users = User::getUserRole('Administrador');
            foreach ($users as $user) {
                $data_array = array(
                    'user_id' => $user->id,
                    'title' => $notification->title,
                    'body' => $notification->body,
                    'id' => $notification->id,
                    'created_at' => $notification->created_at,
                    'is_add_adviser' => false,
                );
                if ($user_id == null) {
                    $notifications[] = $data_array;
                } elseif ($user_id != null && $user_id == $user->id) {
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
