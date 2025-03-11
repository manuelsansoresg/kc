<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('¡Bienvenido a KaaxClub! Establece tu contraseña')
            ->greeting('Hola! ¡Bienvenido a KaaxClub! Para acceder a tu cuenta, es necesario que establezcas tu contraseña.')
            ->action('Establecer Contraseña', url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)))
            ->line('Este enlace expirará en 60 minutos, así que asegúrate de completar el proceso a tiempo.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')])
            ->line('Si no esperabas este correo, puedes ignorarlo sin problemas.')
            ->salutation('Saludos, El equipo de KaaxClub')
            ;
    }
}
