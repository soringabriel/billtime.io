<?php

namespace App\Listeners;

use App\Events\Schedule\ScheduleCreated;
use App\Events\Schedule\ScheduleDeleted;
use App\Events\Schedule\ScheduleUpdated;

/**
 * Class ScheduleEventListener.
 */
class ScheduleEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        activity('schedule')
            ->performedOn($event->schedule)
            ->withProperties([
                'schedule' => [
                    'project_id' => $event->schedule->project_id,
                    'period' => $event->schedule->period,
                    'schedule_trigger' => $event->schedule->schedule_trigger,
                    'price_per_hour' => $event->schedule->price_per_hour,
                    'price_currency' => $event->schedule->price_currency,
                    'discount' => $event->schedule->discount,
                    'tax' => $event->schedule->tax,
                    'shipping' => $event->schedule->shipping,
                    'service_fee' => $event->schedule->service_fee,
                    'notes' => $event->schedule->notes,
                ],
            ])
            ->log(':causer.name created schedule');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('schedule')
            ->performedOn($event->schedule)
            ->withProperties([
                'schedule' => [
                    'project_id' => $event->schedule->project_id,
                    'period' => $event->schedule->period,
                    'schedule_trigger' => $event->schedule->schedule_trigger,
                    'price_per_hour' => $event->schedule->price_per_hour,
                    'price_currency' => $event->schedule->price_currency,
                    'discount' => $event->schedule->discount,
                    'tax' => $event->schedule->tax,
                    'shipping' => $event->schedule->shipping,
                    'service_fee' => $event->schedule->service_fee,
                    'notes' => $event->schedule->notes,
                ],
            ])
            ->log(':causer.name updated schedule');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('schedule')
            ->performedOn($event->schedule)
            ->log(':causer.name deleted schedule');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            ScheduleCreated::class,
            'App\Listeners\ScheduleEventListener@onCreated'
        );

        $events->listen(
            ScheduleUpdated::class,
            'App\Listeners\ScheduleEventListener@onUpdated'
        );

        $events->listen(
            ScheduleDeleted::class,
            'App\Listeners\ScheduleEventListener@onDeleted'
        );
    }
}