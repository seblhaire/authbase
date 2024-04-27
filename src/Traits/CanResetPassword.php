<?php

namespace Seblhaire\Authbase\Traits;

/* based on Illuminate\Auth\Passwords\CanResetPassword */

trait CanResetPassword {

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset() {
        return $this->email;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @param  string  $email
     * @return void
     */
    public function sendPasswordCreateNotification($token, $email) {
        $class = config('authbase.createpasswordnotification');

        $this->notify(new $class($token, $email));
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @param  string  $email
     * @return void
     */
    public function sendPasswordResetNotification($token, $email) {
        $class = config('authbase.resetpasswordnotification');
        $this->notify(new $class($token, $email));
    }
}
