<?php
namespace App\Lib;

use Error;

require '../vendor/autoload.php';

class Csendgrid
{
    public $from;
    public $to;
    public $subject;
    public $content;
    public $idTemplate;
    public $params;
    public $sendgrid;

    public function __construct($to = '', $subject = '', $content = ' ', $from = 'contacto@kaaxclub.com')
    {
        $this->from       = $from;
        $this->to         = $to;
        $this->subject    = $subject;
        $this->content    = $content;
        $this->sendgrid   = new \SendGrid('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');
    }
    public function setTemplate($id_template)
    {
        $this->idTemplate = $id_template;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

   
    public function send()
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->from);
        $email->setSubject($this->subject);
        $email->addTo($this->to);
        $email->addContent("text/html", $this->content);

        $email->setTemplateId($this->idTemplate);
        
        $email->addDynamicTemplateDatas($this->params);
        try {
            $response = $this->sendgrid->send($email);
        } catch (\Exception $e) {
            return 500;
        }
    }

    public function createContact($email, $first_name, $last_name)
    {
        //*crear contacto sendgrid
        $request_body = json_decode('{
            "contacts": [
                {
                    "email": "'.$email.'",
                    "first_name": "'.$first_name.'",
                    "last_name": "'.$last_name.'"
                }
            ],
            "list_ids": [
                "f752e02b-c2f8-462f-962f-fff4634223c4"
            ]
        }');
        
        try {
            $response = $this->sendgrid->client->marketing()->contacts()->put($request_body);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Error $err) {
            return 500;
        }
    }
}
