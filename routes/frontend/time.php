<?php

use App\Http\Controllers\Frontend\TimeController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Time;

Route::group([
    'prefix' => 'time',
    'as' => 'time.',
], function () {
    Route::get('/', [TimeController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Time Managment'), route('time.index'));
    });

    Route::get('create', [TimeController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('time.index')
                ->push(__('Add Time'), route('time.create'));
    });

    Route::post('/', [TimeController::class, 'store'])->name('store');

    Route::group(['prefix' => '{time}'], function () {
        Route::get('edit', [TimeController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Time $time) {
                $trail->parent('time.index')
                    ->push(__('Editing :time', ['time' => $time->name]), route('time.edit', $time));
        });
        Route::patch('/', [TimeController::class, 'update'])->name('update');
        Route::delete('/', [TimeController::class, 'destroy'])->name('destroy');
    });
});