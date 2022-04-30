<?php

namespace App\Domains\Auth\Notifications\Frontend;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class OneMonthInactivity.
 */
class OneMonthInactivity extends Notification
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
            ->subject(__('Do You Remember BillTime.io?'))
            ->line(__('I\'m Peter, from BillTime.io. We noticed that it\'s been a month since your last login and we would like to see if you\'re still interested in using our service.'))
            ->line(__('Could you please share your experience with us? What made you quit and what do you think could bring you back? We would like to keep you as a user, and we\'re always looking for ways to improve our tool.'))
            ->line(__('You can send me your feedback directly as a reply to this email.'))
            ->salutation(__('Best regards, Peter'));
    }
}
