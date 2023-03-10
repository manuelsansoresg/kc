<?php

namespace App\Strategies\Notifications;

use App\Models\HistoryLog;
use App\Models\Notification;
use App\Models\User;
use App\Strategies\Notifications\Models\Pusher;
use App\Strategies\SendNotificationsInterface;
use Illuminate\Support\Facades\Auth;

class PushCreditKcControlDesk implements SendNotificationsInterface
{
    public function send($id)
    {
        $data_notification = array(
            'id_rel' => $id,
            'title' => 'Crédito',
            'body' => 'Nuevo Nuevo crédito en KC-Control desk',
            'model' => HistoryLog::KC_CONTROL_DESK,
        );
        $is_exist = Notification::where($data_notification)->count();
        
        if ($is_exist == 0) {
            Notification::create($data_notification);
            $push  = new Pusher;
            $push->send(['model' => 'pushCreditKcControlDesk']);
        }
    }
    
    public function get($user_id = null, $status = 0)
    {
        $get_notifications = Notification::getByModel([HistoryLog::KC_CONTROL_DESK]);
        $notifications = array();
        foreach ($get_notifications as $notification) {
            $users = User::getUserRole('Administrador');
            $credit = $notification->notificationCredit;
            $advisor = $credit->creditAdvisor;
            $toast  = \View::make('panel.toast', ['title' => $notification->title, 'body' => $notification->body])->render();
            
            foreach ($users as $user) {
                $data_array = array(
                    'user_id' => $user->id,
                    'title' => $notification->title,
                    'body' => $notification->body,
                    'toast' => $toast,
                    'id' => $notification->id,
                    'created_at' => date('Y-m-d H:i:s', strtotime($notification->created_at)),
                    'date' => $notification->created_at,
                    'status' => $notification->status,
                );
                //dd($user->id, Auth::user()->id);
                if ($user->id == Auth::user()->id) {
                    $notifications[] = $data_array;
                }
            }

            if ($advisor != null) {
                if ($advisor->id == Auth::user()->id) {
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
                    $notifications[] = $data_array;
                }
            }
        }
        return $notifications;
    }
}
