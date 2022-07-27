<?php
namespace App\Lib;

require '../vendor/autoload.php';

class Csendgrid
{
    public $from;
    public $to;
    public $subject;
    public $content;

    public function __construct($to, $subject, $content, $from = 'notificaciones@sidecc.online')
    {
        $this->from       = $from;
        $this->to         = $to;
        $this->subject    = $subject;
        $this->content    = $content;
    }

    public function send()
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->from);
        $email->setSubject($this->subject);
        $email->addTo($this->to);
        $email->addContent("text/html", $this->content);
        $email->setTemplateId('d-a125fbfe0cde40bb984ebc9a6cf45c38');
        $sendgrid = new \SendGrid('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');
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (\Exception $e) {
            return 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}