<?php
namespace App\Lib;
use Illuminate\Support\Facades\Mail;

class Cemail
{
    public $to;
    public $from;
    public $subject;
    public $content;
    public $template;
    public $cc;

    public function __construct($to = null, $template, $subject = '', $content= '', $cc= '')
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