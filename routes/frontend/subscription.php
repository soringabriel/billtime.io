<?php

use App\Http\Controllers\Frontend\SubscriptionsController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'subscription',
    'as' => 'subscription.',
    'middleware' => ['organization_owner', 'auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::get('/invoices', [SubscriptionsController::class, 'invoices'])
        ->name('invoices')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.dashboard')
                ->push(__('Invoices'), route('frontend.subscription.invoices'));
    });

    Route::get('/confirmation', [SubscriptionsController::class, 'confirmation'])
        ->name('confirmation')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.dashboard')
                ->push(__('Confirmation'), route('frontend.subscription.confirmation'));
    });

    Route::group(['prefix' => '{plan}'], function () {
        Route::get('/update', [SubscriptionsController::class, 'updateSubscription'])->name('update');
    });

    Route::get('/cancel-subscription', [SubscriptionsController::class, 'cancelSubscription'])->name('cancel-subscription');
});