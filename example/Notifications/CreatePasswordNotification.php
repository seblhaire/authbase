<?php

namespace App\Notifications;

// based on
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Seblhaire\Authbase\Notifications\ResetPassword;

class CreatePasswordNotification extends ResetPassword {

    public function buildMessage($url, $user): MailMessage{
        return (new MailMessage)
                        //->from('webmaster@mysite.com', "Webmaster mysite")
                        //->replyTo('no-reply@mysite.com')
                        ->theme('authbase::public.emails.themes.default')
                        ->markdown('authbase::public.emails.email')
                        ->subject(Lang::get('specialauth::messages.createpass'))
                        ->line(Lang::get("authbase::messages.passwordcreation", ['user' => $user]))
                        ->action(Lang::get('specialauth::messages.createpass'), $url)
                        ->line(Lang::get('authbase::messages.expirecreation', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]));
    }
    
    public function getRoute(): string{
        return 'password.create';
    }
    
}
