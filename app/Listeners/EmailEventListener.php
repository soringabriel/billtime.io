<?php

namespace App\Listeners;

use App\Events\Email\EmailCreated;

/**
 * Class EmailEventListener.
 */
class EmailEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        activity('email')
            ->performedOn($event->email)
            ->withProperties([
                'email' => [
                    'invoice_id' => $event->email->invoice_id,
                    'from' => $event->email->from,
                    'to' => $event->email->to,
                    'locale' => $event->email->locale,
                ],
            ])
            ->log(':causer.name created email :subject.subject');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            EmailCreated::class,
            'App\Listeners\EmailEventListener@onCreated'
        );
    }
}