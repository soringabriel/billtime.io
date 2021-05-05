<?php

namespace App\Listeners;

use Laravel\Paddle\Events\SubscriptionPaymentSucceeded;
use Laravel\Paddle\Events\SubscriptionUpdated;
use Laravel\Paddle\Events\SubscriptionCancelled;
use App\Models\Plan;
use App\Services\OrganizationService;
use Laravel\Paddle\Exceptions\PaddleException;

class CashierPaddleEventListener
{
    /**
     * CashierPaddleEventListener constructor.
     *
     * @param  OrganizationService  $organizationService
     */
    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * @param $event
     */
    public function onSubscriptionPaymentSucceeded(SubscriptionPaymentSucceeded $event)
    {
        $plan = Plan::find(json_decode($event->payload['passthrough'])->plan_id);
        $organization = $event->billable;
        $this->organizationService->update($organization, [
            'plan_id' => $plan->id,
            'next_plan_id' => $plan->id,
            'subusers_quota' => $plan->subusers_quota,
        ]);
        activity('subscription-organization')
            ->performedOn($organization)
            ->withProperties($event)
            ->log('Subscription Payment Succeded');
    }

    /**
     * @param $event
     */
    public function onSubscriptionUpdated(SubscriptionUpdated $event)
    {
        $plan = Plan::find(json_decode($event->payload['passthrough'])->plan_id);
        $organization = $event->subscription->billable;
        $this->organizationService->update($organization, [
            'next_plan_id' => $plan->id,
        ]);
        activity('subscription-organization')
            ->performedOn($organization)
            ->withProperties($event)
            ->log('Subscription Updated');
    }

    /**
     * @param $event
     */
    public function onSubscriptionCancelled(SubscriptionCancelled $event)
    {
        $organization = $event->subscription->billable;
        $default_plan = Plan::find(env('DEFAULT_PLAN'));
        $this->organizationService->update($organization, [
            'plan_id' => $default_plan->id,
            'next_plan_id' => $default_plan->id,
            'subusers_quota' => $default_plan->subusers_quota,
        ]);
        activity('subscription-organization')
            ->performedOn($organization)
            ->withProperties($event)
            ->log('Subscription Cancelled');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Laravel\Paddle\Events\SubscriptionPaymentSucceeded',
            'App\Listeners\CashierPaddleEventListener@onSubscriptionPaymentSucceeded'
        );

        $events->listen(
            'Laravel\Paddle\Events\SubscriptionUpdated',
            'App\Listeners\CashierPaddleEventListener@onSubscriptionUpdated'
        );

        $events->listen(
            'Laravel\Paddle\Events\SubscriptionCancelled',
            'App\Listeners\CashierPaddleEventListener@onSubscriptionCancelled'
        );
    }
}