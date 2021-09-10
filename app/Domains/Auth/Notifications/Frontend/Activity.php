<?php

namespace App\Domains\Auth\Notifications\Frontend;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class Activity.
 */
class Activity extends Notification
{
    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('We Noticed You\'re Not Using The Tool'))
            ->line(__('I noticed that it\'s been already three days since you registered, and your account still didn\'t add any time records or invoices. Did you encounter any problems? Or is it just that the tool isn\'t what you were looking for?'))
            ->line(__('If you do find our tool hard to use, please let me know. We\'re trying our best to improve the experience we\'re giving our users, and I would like to help you if I can!'))
            ->salutation(__('Best regards, Peter'));
    }
}
