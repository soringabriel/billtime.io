<?php

use App\Http\Controllers\Frontend\TimeController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Time;

Route::group([
    'prefix' => 'time',
    'as' => 'time.',
    'middleware' => ['auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::get('/', [TimeController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.index')
                ->push(__('Time Managment'), route('frontend.time.index'));
    });

    Route::get('create', [TimeController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.time.index')
                ->push(__('Add Time'), route('frontend.time.create'));
    });

    Route::post('/', [TimeController::class, 'store'])->name('store');

    Route::group(['prefix' => '{time}', 'middleware' => 'time'], function () {
        Route::get('edit', [TimeController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Time $time) {
                $trail->parent('frontend.time.index')
                    ->push(__('Editing :time', ['time' => $time->name]), route('frontend.time.edit', $time));
        });
        Route::patch('/', [TimeController::class, 'update'])->name('update');
        Route::delete('/', [TimeController::class, 'destroy'])->name('destroy');
    });
});