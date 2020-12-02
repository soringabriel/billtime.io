<?php

namespace App\Listeners;

use App\Events\Project\ProjectCreated;
use App\Events\Project\ProjectDeleted;
use App\Events\Project\ProjectUpdated;

/**
 * Class ProjectEventListener.
 */
class ProjectEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        activity('project')
            ->performedOn($event->project)
            ->withProperties([
                'project' => [
                    'name' => $event->project->name,
                    'company_name' => $event->project->company_name,
                    'tax_number' => $event->project->tax_number,
                    'vat_number' => $event->project->vat_number,
                    'address' => $event->project->address,
                ],
            ])
            ->log(':causer.name created project :subject.name');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('project')
            ->performedOn($event->project)
            ->withProperties([
                'project' => [
                    'name' => $event->project->name,
                    'company_name' => $event->project->company_name,
                    'tax_number' => $event->project->tax_number,
                    'vat_number' => $event->project->vat_number,
                    'address' => $event->project->address,
                ],
            ])
            ->log(':causer.name updated project :subject.name');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('project')
            ->performedOn($event->project)
            ->log(':causer.name deleted project');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            ProjectCreated::class,
            'App\Listeners\ProjectEventListener@onCreated'
        );

        $events->listen(
            ProjectUpdated::class,
            'App\Listeners\ProjectEventListener@onUpdated'
        );

        $events->listen(
            ProjectDeleted::class,
            'App\Listeners\ProjectEventListener@onDeleted'
        );
    }
}