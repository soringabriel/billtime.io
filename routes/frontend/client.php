<?php

use App\Http\Controllers\Frontend\ClientController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Client;

Route::group([
    'prefix' => 'clients',
    'as' => 'clients.',
    'middleware' => ['permission:user.access.clients.access', 'auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::get('/', [ClientController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.index')
                ->push(__('Client Managment'), route('frontend.clients.index'));
    });

    Route::get('create', [ClientController::class, 'create'])
        ->name('create')
        ->middleware('permission:user.access.clients.create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.clients.index')
                ->push(__('Add Client'), route('frontend.clients.create'));
    });

    Route::post('/', [ClientController::class, 'store'])->middleware('permission:user.access.clients.create')->name('store');

    Route::group(['prefix' => '{client}', 'middleware' => 'model_belongs_to_user_organization:client'], function () {
        Route::get('edit', [ClientController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:user.access.clients.edit')
            ->breadcrumbs(function (Trail $trail, Client $client) {
                $trail->parent('frontend.clients.index')
                    ->push(__('Editing :client', ['client' => $client->name]), route('frontend.clients.edit', $client));
        });
        Route::patch('/', [ClientController::class, 'update'])->middleware('permission:user.access.clients.edit')->name('update');
        Route::delete('/', [ClientController::class, 'destroy'])->middleware('permission:user.access.clients.delete')->name('destroy');
    });
});