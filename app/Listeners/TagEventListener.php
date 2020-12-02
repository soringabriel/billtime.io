<?php

namespace App\Listeners;

use App\Events\Tag\TagCreated;
use App\Events\Tag\TagDeleted;
use App\Events\Tag\TagUpdated;

/**
 * Class TagEventListener.
 */
class TagEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        activity('tag')
            ->performedOn($event->tag)
            ->withProperties([
                'tag' => [
                    'name' => $event->tag->name
                ],
            ])
            ->log(':causer.name created tag :subject.name');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('tag')
            ->performedOn($event->tag)
            ->withProperties([
                'tag' => [
                    'name' => $event->tag->name
                ],
            ])
            ->log(':causer.name updated tag :subject.name');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('tag')
            ->performedOn($event->tag)
            ->log(':causer.name deleted tag');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            TagCreated::class,
            'App\Listeners\TagEventListener@onCreated'
        );

        $events->listen(
            TagUpdated::class,
            'App\Listeners\TagEventListener@onUpdated'
        );

        $events->listen(
            TagDeleted::class,
            'App\Listeners\TagEventListener@onDeleted'
        );
    }
}