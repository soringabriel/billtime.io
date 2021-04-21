<?php

namespace App\Listeners;

use App\Events\Organization\OrganizationCreated;
use App\Events\Organization\OrganizationDeleted;
use App\Events\Organization\OrganizationUpdated;
use App\Domains\Auth\Services\UserService;

/**
 * Class OrganizationEventListener.
 */
class OrganizationEventListener
{
    /**
     * OrganizationEventListener constructor.
     *
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param $event
     */
    public function onCreated($event)
    {
        $this->userService->updateOrganization($event->organization->owner()->first(), [
            'organization_id' => $event->organization->id
        ]);
        activity('organization')
            ->performedOn($event->organization)
            ->withProperties([
                'organization' => [
                    'owner_id' => $event->organization->owner_id,
                    'company_name' => $event->organization->company_name,
                    'tax_number' => $event->organization->tax_number,
                    'vat_number' => $event->organization->vat_number,
                    'address' => $event->organization->address,
                    'bank_name' => $event->organization->bank_name,
                    'bank_account' => $event->organization->bank_account,
                ],
            ])
            ->log(':causer.name created organization :subject.name');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('organization')
            ->performedOn($event->organization)
            ->withProperties([
                'organization' => [
                    'owner_id' => $event->organization->owner_id,
                    'company_name' => $event->organization->company_name,
                    'tax_number' => $event->organization->tax_number,
                    'vat_number' => $event->organization->vat_number,
                    'address' => $event->organization->address,
                    'bank_name' => $event->organization->bank_name,
                    'bank_account' => $event->organization->bank_account,
                ],
            ])
            ->log(':causer.name updated organization :subject.name');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('organization')
            ->performedOn($event->organization)
            ->log(':causer.name deleted organization :subject.name');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            OrganizationCreated::class,
            'App\Listeners\OrganizationEventListener@onCreated'
        );

        $events->listen(
            OrganizationUpdated::class,
            'App\Listeners\OrganizationEventListener@onUpdated'
        );

        $events->listen(
            OrganizationDeleted::class,
            'App\Listeners\OrganizationEventListener@onDeleted'
        );
    }
}