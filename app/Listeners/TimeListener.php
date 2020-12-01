<?php

namespace App\Listeners;

use App\Events\Time\TimeCreated;
use App\Events\Time\TimeDeleted;
use App\Events\Time\TimeUpdated;

/**
 * Class TimeListener.
 */
class TimeListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        activity('time')
            ->performedOn($event->time)
            ->withProperties([
                'time' => [
                    'start' => $event->time->start,
                    'end' => $event->time->end,
                    'task' => $event->time->task,
                    'details' => $event->time->details,
                ],
            ])
            ->log(':causer.name created time');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('time')
            ->performedOn($event->Time)
            ->withProperties([
                'time' => [
                    'start' => $event->time->start,
                    'end' => $event->time->end,
                    'task' => $event->time->task,
                    'details' => $event->time->details,
                ],
            ])
            ->log(':causer.name updated time');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('time')
            ->performedOn($event->time)
            ->log(':causer.name deleted time');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            TimeCreated::class,
            'App\Listeners\TimeListener@onCreated'
        );

        $events->listen(
            TimeUpdated::class,
            'App\Listeners\TimeListener@onUpdated'
        );

        $events->listen(
            TimeDeleted::class,
            'App\Listeners\TimeListener@onDeleted'
        );
    }
}