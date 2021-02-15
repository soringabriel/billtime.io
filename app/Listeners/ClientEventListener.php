<?php

namespace App\Listeners;

use App\Events\Client\ClientCreated;
use App\Events\Client\ClientDeleted;
use App\Events\Client\ClientUpdated;

/**
 * Class ClientEventListener.
 */
class ClientEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        activity('client')
            ->performedOn($event->client)
            ->withProperties([
                'client' => [
                    'name' => $event->client->name,
                    'company_name' => $event->client->company_name,
                    'tax_number' => $event->client->tax_number,
                    'vat_number' => $event->client->vat_number,
                    'address' => $event->client->address,
                ],
            ])
            ->log(':causer.name created client :subject.name');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('client')
            ->performedOn($event->client)
            ->withProperties([
                'client' => [
                    'name' => $event->client->name,
                    'company_name' => $event->client->company_name,
                    'tax_number' => $event->client->tax_number,
                    'vat_number' => $event->client->vat_number,
                    'address' => $event->client->address,
                ],
            ])
            ->log(':causer.name updated client :subject.name');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('client')
            ->performedOn($event->client)
            ->log(':causer.name deleted client :subject.name');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            ClientCreated::class,
            'App\Listeners\ClientEventListener@onCreated'
        );

        $events->listen(
            ClientUpdated::class,
            'App\Listeners\ClientEventListener@onUpdated'
        );

        $events->listen(
            ClientDeleted::class,
            'App\Listeners\ClientEventListener@onDeleted'
        );
    }
}