<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        $url = config('app.frontend_url');
        $url .= '/reset-password';
        $url .= '?token='.$this->token;
        $url .= '&email='.$notifiable->getEmailForPasswordReset();

        return $url;
    }
}
