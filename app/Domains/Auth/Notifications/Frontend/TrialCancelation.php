<?php

namespace App\Domains\Auth\Notifications\Frontend;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class TrialCancelation.
 */
class TrialCancelation extends Notification
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
            ->subject(__('Today Is Your Last Day Of Free Trial'))
            ->line(__('As a new user you benefit of 2 weeks of free trial, while being able to use all of our services at https://timotrack.com'))
            ->line(__('However, it looks like this period is coming to an end for your account. This will mean that you will no longer have access to invoices and your account will only have one user associated to it.'))
            ->line(__('To prevent losing these features, you can upgrade to one of our plans:'))
            ->action(__('Plans'), 'https://timotrack.com/plan')
            ->line(__('In case you don\'t know what plan to pick, I\'m here to help you! Just send a reply to this email or contact our team via the chat from the website.'))
            ->salutation(__('Best regards, Peter'));
    }
}
