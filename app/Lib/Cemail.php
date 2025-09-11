<?php
namespace App\Lib;

use App\Models\Agreement;
use App\Models\Credit;
use App\Models\Investor;
use App\Models\InvestorsAgreement;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class Cemail
{
    public $to;
    public $from;
    public $subject;
    public $content;
    public $template;
    public $cc;

    public function __construct($to = null, $template = null, $subject = '', $content= '', $cc= '')
    {
        $this->to       = $to;
        $this->subject  = $subject;
        $this->content  = $content;
        if ($content == '') {
            $this->content  = array('title' => $this->subject);
        } else {
            // Si el content no tiene la clave 'title', se agrega
            if (!isset($this->content['title'])) {
                $this->content['title'] = $this->subject;
            }
        }
        $this->template = $template;
        $this->cc       = $cc;
    }

    public function nuevaSolicitud($credit_id)
    {
        $credit = Credit::find($credit_id);
        $client = $credit->client;
        $product = $credit->creditProduct;
        $investor_ids = InvestorsAgreement::where('agreement_id', $credit->agreement_id)->pluck('investor_id');
        $investors = Investor::whereIn('id', $investor_ids)->pluck('user_id');
        $users = User::whereIn('id', $investors)->get();
        $emails = $users->pluck('email')->implode(',');
        $nombre_completo = $credit->id.' '.$client->name.' '.$client->lastname. ' '. $client->second_last_name;
        $subject = 'Nueva solicitud de ' . $product->alias . '  - '. $nombre_completo;
        $data_email = array(
            'nombre_completo' => $nombre_completo,
            'product' => $product,
        );

        $sendEmail = new Cemail($emails, 'nueva_solicitud',  $subject, $data_email);
        $sendEmail->sendEmail();
    }

    public function sendEmail()
    {
        // Convertir la lista de destinatarios en un array
       try {
            if ($this->to === null) {
                $getNotification = EmailNotification::find(1);
                $recipients = array_map('trim', explode(',', $getNotification->email));
            } else {
                $recipients = array_map('trim', explode(',', $this->to));
            }
            
            
            // Preparar el correo utilizando la vista en la carpeta "template"
            Mail::send("email.{$this->template}", $this->content, function ($message) use ($recipients) {
                $message->to($recipients); // Enviar a múltiples destinatarios

                if ($this->cc) {
                    // Si hay direcciones en 'cc', convertirlas en array y añadirlas
                    $ccRecipients = array_map('trim', explode(',', $this->cc));
                    $message->cc($ccRecipients);
                }

                $message->subject($this->subject);
            });
       } catch (\Exception $e) {
        //throw $th;
       }
    }
}