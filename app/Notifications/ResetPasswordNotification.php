<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
   
     public function toMail($notifiable)
     {
         $url = url(route('password.reset', [
             'token' => $this->token,
             'email' => $notifiable->getEmailForPasswordReset(),
         ], false));
 
         return (new MailMessage)
             ->subject('Recuperación de contraseña')
             ->greeting('¡Hola!')
             ->line('Estás recibiendo este correo porque recibimos una solicitud de recuperación de contraseña para tu cuenta.')
             ->action('Recuperar Contraseña', $url)
             ->line('Este enlace de recuperación caducará en 60 minutos.')
             ->line('Si no solicitaste una recuperación de contraseña, no se requiere ninguna acción.')
             ->salutation('Saludos, Kaaxclub');
     }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
