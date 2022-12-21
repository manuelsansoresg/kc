<?php

namespace App\Lib;

use App\Models\Credit;
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

    public function __construct($to = '', $subject = '', $content = '', $from = 'contacto@kaaxclub.com', $cc = '', $attach = [])
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
        if (count($this->attach) > 0) {
            foreach ($this->attach as $files) {
                $attach = $files->name;
                $file = asset($this->path.'/'. $attach);
                $file_encoded = base64_encode(file_get_contents($this->path.'/'. $attach));
                $email->addAttachment(
                    $file_encoded,
                    "application/text",
                    $file,
                    "attachment"
                );
            }
        }
        if ($this->content != '') {
            $email->addContent("text/html", $this->content);
        }

        $email->setTemplateId($this->idTemplate);
        $email->addDynamicTemplateDatas($this->params);
        try {
            $response = $this->sendgrid->send($email);
            return $response;
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

    public function createEmail($credit_id)
    {
        $nick_name = self::createNick($credit_id);
        $new_email = $nick_name.'@kaaxclub.com';
        return $new_email;
    }

    public function createNick($credit_id)
    {
        $credit         = Credit::find($credit_id);
        $client         = $credit->creditClientPerson;
        $email          = $client->email;
        $explode_email = explode('@', $email);
        $nick_name = $explode_email[0];
        return $nick_name;
    }

    public function createSender($credit_id)
    {
        $credit         = Credit::find($credit_id);
        $client         = $credit->creditClientPerson;
        $client_name    = $client->last_name.' '.$client->second_last_name.' '.$client->name;

        $nick_name      = self::createNick($credit_id);
        $new_email      = $client->name.' '.$client->last_name;

        $request_body = json_decode('{
            "nickname": "' . $nick_name . '",
            "from": {
                "email": "' . $new_email . '",
                "name": "'.$client_name.'"
            },
            "reply_to": {
                "email": "solicitudes@kaaxclub.com",
                "name": "kaaxclub"
            },
            "address": "23 210 Garcia Gineres",
            "address_2": "",
            "city": "Merida",
            "state": "Yucatan",
            "zip": "97070",
            "country": "Mexico"
        }');

        try {
            $response = $this->sendgrid->client->marketing()->senders()->post($request_body);
            return $new_email;
        } catch (Error $err) {
            return null;
        }
    }
}
