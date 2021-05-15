<?php

use App\Http\Controllers\Frontend\PagesController;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'middleware' => ['auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::get('/dashboard', [PagesController::class, 'dashboard'])
        ->name('dashboard')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Dashboard'), route('frontend.dashboard'));
        });

    Route::get('/plan', [PagesController::class, 'plan'])
        ->name('plan')
        ->middleware('organization_owner')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.dashboard')
                ->push(__('Plan'), route('frontend.plan'));
        });

    Route::get('/receipts', [PagesController::class, 'receipts'])
        ->name('receipts')
        ->middleware('organization_owner')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Dashboard'), route('frontend.dashboard'));
        });
});