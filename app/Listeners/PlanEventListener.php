<?php

namespace App\Listeners;

use App\Events\Plan\PlanCreated;
use App\Events\Plan\PlanDeleted;
use App\Events\Plan\PlanUpdated;

/**
 * Class PlanEventListener.
 */
class PlanEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        activity('plan')
            ->performedOn($event->plan)
            ->withProperties([
                'plan' => [
                    'name' => $event->plan->name,
                    'price' => $event->plan->price,
                    'currency' => $event->plan->currency,
                    'billing_type' => $event->plan->billing_type,
                    'paddle_id' => $event->plan->paddle_id,
                    'subusers_quota' => $event->plan->subusers_quota,
                ],
            ])
            ->log(':causer.name created plan :subject.name');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('plan')
            ->performedOn($event->plan)
            ->withProperties([
                'plan' => [
                    'name' => $event->plan->name,
                    'price' => $event->plan->price,
                    'currency' => $event->plan->currency,
                    'billing_type' => $event->plan->billing_type,
                    'paddle_id' => $event->plan->paddle_id,
                    'subusers_quota' => $event->plan->subusers_quota,
                ],
            ])
            ->log(':causer.name updated plan :subject.name');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('plan')
            ->performedOn($event->plan)
            ->log(':causer.name deleted plan :subject.name');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            PlanCreated::class,
            'App\Listeners\PlanEventListener@onCreated'
        );

        $events->listen(
            PlanUpdated::class,
            'App\Listeners\PlanEventListener@onUpdated'
        );

        $events->listen(
            PlanDeleted::class,
            'App\Listeners\PlanEventListener@onDeleted'
        );
    }
}