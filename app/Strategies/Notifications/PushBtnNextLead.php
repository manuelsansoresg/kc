<?php

namespace App\Strategies\Notifications;

use App\Models\Notification;
use App\Models\User;
use App\Strategies\Notifications\Models\Pusher;
use App\Strategies\SendNotificationsInterface;

class PushBtnNextLead implements SendNotificationsInterface
{
    public function send($id)
    {
        $data_notification = array(
            'id_rel' => $id,
            'title' => 'Prospectos',
            'body' => 'Se ha creado un nuevo crédito',
            'model' => Notification::BTN_NEXT_LEAD,
        );
        Notification::create($data_notification);
        $push  = new Pusher;
        $push->send(['model' => 'btnNextLead']);
    }
    
    public function get($user_id = null, $status = 0)
    {
        $get_notifications = Notification::getByModel([Notification::BTN_NEXT_LEAD], $status);
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
