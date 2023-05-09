<?php
namespace App\Lib;

use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;

class Slack 
{
    protected $title;
    protected $message;
    protected $hook;

    public function __construct($title, $message) {
        $this->title = $title;
        $this->message = $message;
        $this->hook = 'https://hooks.slack.com/services/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';
    }

    public function sendMessage()
    {
        Notification::route('slack', $this->hook)
            ->notify(new SlackNotification($this->title, $this->message));
    }

}