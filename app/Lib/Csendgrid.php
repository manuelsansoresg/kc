<?php

namespace App\Lib;

use Error;

require '../vendor/autoload.php';

class Csendgrid
{
    public $from;
    public $to;
    public $cc;
    public $subject;
    public $content;
    public $idTemplate;
    public $params;
    public $sendgrid;
    public $attach;
    public $path;

    public function __construct($to = '', $subject = '', $content = '', $from = 'contacto@kaaxclub.com', $cc = '', $attach = '')
    {
        $this->from       = $from;
        $this->to         = $to;
        $this->subject    = $subject;
        $this->content    = $content;
        $this->cc         = $cc;
        $this->attach     = $attach;
        $this->sendgrid   = new \SendGrid('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');
        $this->path       = 'files_upload';
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
        if ($this->cc != '') {
            $email->addCc($this->to);
        }

        if ($this->attach != '') {
            $file = asset($this->path.'/'. $this->attach);
            $file_encoded = base64_encode(file_get_contents($this->path.'/'. $this->attach));
            $email->addAttachment(
                $file_encoded,
                "application/text",
                $file,
                "attachment"
            );
        }
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
                    "email": "' . $email . '",
                    "first_name": "' . $first_name . '",
                    "last_name": "' . $last_name . '"
                }
            ],
            "list_ids": [
                "f752e02b-c2f8-462f-962f-fff4634223c4"
            ]
        }');

        try {
            $response = $this->sendgrid->client->marketing()->contacts()->put($request_body);
        } catch (Error $err) {
            return 500;
        }
    }

    public function createSender($nick_name, $email, $email_reply)
    {
        $request_body = json_decode('{
            "nickname": "' . $nick_name . '",
            "from": {
                "email": "' . $email . '",
                "name": "Example Orders"
            },
            "reply_to": {
                "email": "' . $email_reply . '",
                "name": "Example Support"
            },
            "address": "1234 Fake St.",
            "address_2": "",
            "city": "San Francisco",
            "state": "CA",
            "zip": "94105",
            "country": "United States"
        }');

        try {
            $response = $this->sendgrid->client->marketing()->senders()->post($request_body);
        } catch (Error $err) {
            return 500;
        }
    }
}
