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
            'title' => 'Créditos',
            'body' => 'Se ha creado un nuevo crédito',
            'model' => Notification::BTN_NEXT_LEAD,
        );
        $is_exist = Notification::where($data_notification)->count();
        
        if ($is_exist == 0) {
            Notification::create($data_notification);
            $push  = new Pusher;
            $push->send(['model' => 'btnNextLead']);
        }
    }
    
    public function get($user_id = null, $status = 0)
    {
        $get_notifications = Notification::getByModel([Notification::BTN_NEXT_LEAD]);
        $notifications = array();
        foreach ($get_notifications as $notification) {
            $users = User::getUserRole('Administrador');
            foreach ($users as $user) {

                $toast  = \View::make('panel.toast', ['title' => $notification->title, 'body' => $notification->body])->render();
                $data_array = array(
                    'user_id' => $user->id,
                    'title' => $notification->title,
                    'body' => $notification->body,
                    'toast' => $toast,
                    'id' => $notification->id,
                    'created_at' => $notification->created_at,
                    'is_add_adviser' => false,
                );
                
                $notifications[] = $data_array;
            }
            //*activate recieve push
            $get_notification = Notification::find($notification->id);
            $get_notification->status = 1;
            $get_notification->update();
        }
        return $notifications;
    }
}
