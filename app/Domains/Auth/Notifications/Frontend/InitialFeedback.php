<?php

namespace App\Domains\Auth\Notifications\Frontend;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class InitialFeedback.
 */
class InitialFeedback extends Notification
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
            ->subject(__('What Do You Think Of Timo-Track'))
            ->line(__('I\'m happy to see that you went ahead and register on our tool at timotrack.com'))
            ->line(__('It\'s been a day since you joined, and I wanted to ask you how you feel about our product. Do you think it provides the value you and your company need? Or what would you like us to change to make your experience better? You can leave your feedback at the following link or by responding to this email:'))
            ->action(__('Leave Feedback'), 'https://surveys.userleap.io/4150716f724f50532d6f7e7369643a3332383138')
            ->line(__('We believe that our client comes first so we are looking constantly for ways to improve our tool. If you have any questions I\'m here to answer them or you can just contact us via the chat on the website.'))
            ->salutation(__('Best regards, Peter'));
    }
}
