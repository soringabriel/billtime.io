<?php

use App\Http\Controllers\Frontend\SubscriptionsController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Plan;

Route::group([
    'prefix' => 'subscription',
    'as' => 'subscription.',
    'middleware' => ['organization_owner', 'auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::group(['prefix' => '{plan}'], function () {
        Route::get('/confirmation', [SubscriptionsController::class, 'confirmation'])
            ->name('confirmation')
            ->breadcrumbs(function (Trail $trail, Plan $plan) {
                $trail->parent('frontend.dashboard')
                    ->push(__('Confirmation'), route('frontend.subscription.confirmation', $plan));
        });

        Route::get('/update', [SubscriptionsController::class, 'updateSubscription'])->name('update');
    });

    Route::get('/cancel-subscription', [SubscriptionsController::class, 'cancelSubscription'])->name('cancel-subscription');
});