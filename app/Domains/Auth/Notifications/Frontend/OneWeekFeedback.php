<?php

namespace App\Domains\Auth\Notifications\Frontend;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class OneWeekFeedback.
 */
class OneWeekFeedback extends Notification
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
            ->subject(__('Share With Us Your Feedback'))
            ->line(__('Let me start by telling you that we\'re happy to have you on board! It\'s been already a week since you registered, and I would like to know what\'s the general feeling you have about our tool.'))
            ->line(__('We would really love if you could share with us your feedback by filling out this small form:'))
            ->action(__('Feedback'), 'https://www.trustpilot.com/evaluate/timotrack.com')
            ->line(__('We know how precious your time is, so we want to keep it simple. Your feedback it\'s important to us because it tells us if we\'re heading into a good direction, or if not, what we can do to get back on the good path.'))
            ->line(__('If you encounter any problems with the form, let me know and I will answer back as soon as I see the message!'))
            ->salutation(__('Best regards, Peter'));
    }
}
