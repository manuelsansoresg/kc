<?php
namespace App\Strategies\Notifications\Models;

class Pusher
{
    public $push;

    public function __construct()
    {
        $options = array(
            'cluster' => 'us2',
            'useTLS' => true
        );
        $this->push = new \Pusher\Pusher(
            'cb2d06fb80592c4ce5f2',
            '31b0d4dd6beb7cfe9225',
            '1458836',
            $options
        );
    }

    public function send($data)
    {
        $this->push->trigger('kaaxclub', 'kaaxclub-event', $data);
    }
}
