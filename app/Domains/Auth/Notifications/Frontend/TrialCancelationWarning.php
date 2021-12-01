<?php

namespace App\Domains\Auth\Notifications\Frontend;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class TrialCancelationWarning.
 */
class TrialCancelationWarning extends Notification
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
            ->subject(__('Your Free Unlimited Trial Is About To Expire'))
            ->line(__('As a new user you received two weeks of trial on https://timotrack.com with all of the features of the service. There are still 3 more days, while you benefit from this free trial.'))
            ->line(__('Once this trial ends however, your account will be automatically downgraded to the Freelancer plan. This means you will no longer have access to invoices and your organization will have a limit of only one user. '))
            ->line(__('To continue using all of the features, or just the ones that you need, please check out our plans page, and upgrade to the plan that fits you the most:'))
            ->action(__('Check Out Plans'), 'https://timotrack.com/plan')
            ->line(__('If you need any help in choosing a plan, you can ask me directly on this email, or just contact the team via the chat on the website 😄'))
            ->salutation(__('Best regards, Peter'));
    }
}
