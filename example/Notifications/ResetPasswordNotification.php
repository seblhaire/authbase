<?php

namespace App\Notifications;

//based on  Illuminate\Auth\Notifications;

use \Illuminate\Notifications\Messages\MailMessage;
use \Illuminate\Support\Facades\Lang;
use Seblhaire\Authbase\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword {

    public function buildMessage($url, $user): MailMessage{
        return (new MailMessage)
                        //->from('webmaster@mysite.com', "Webmaster mysite")
                        //->replyTo('no-reply@mysite.com')
                        ->theme('authbase::public.emails.themes.default')
                        ->markdown('authbase::public.emails.email')
                        ->subject(Lang::get('specialauth::messages.resetpassnotif'))
                        ->line(Lang::get('authbase::messages.passwordreset'))
                        ->action(Lang::get('specialauth::messages.resetpass'), $url)
                        ->line(Lang::get('authbase::messages.expirereset', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
                        ->line(Lang::get('authbase::messages.nofurtheraction'));
    }
    
    public function getRoute(): string{
        return 'password.reset';
    }
}
