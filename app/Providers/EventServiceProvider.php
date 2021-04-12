<?php

namespace App\Providers;

use App\Domains\Auth\Listeners\RoleEventListener;
use App\Domains\Auth\Listeners\UserEventListener;
use App\Listeners\ProjectEventListener;
use App\Listeners\TagEventListener;
use App\Listeners\TimeEventListener;
use App\Listeners\InvoiceEventListener;
use App\Listeners\ClientEventListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        RoleEventListener::class,
        UserEventListener::class,
        ProjectEventListener::class,
        TagEventListener::class,
        TimeEventListener::class,
        InvoiceEventListener::class,
        ClientEventListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
