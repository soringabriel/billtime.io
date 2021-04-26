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

    Route::group(['prefix' => '{time}'], function () {
        Route::get('edit', [TimeController::class, 'edit'])
            ->name('edit')
            ->middleware('model_belongs_to_user:time,user.access.times.edit-all')
            ->breadcrumbs(function (Trail $trail, Time $time) {
                $trail->parent('frontend.time.index')
                    ->push(__('Editing :time', ['time' => $time->name]), route('frontend.time.edit', $time));
        });
        Route::patch('/', [TimeController::class, 'update'])->middleware('model_belongs_to_user:time,user.access.times.edit-all')->name('update');
        Route::patch('/toggleBilled', [TimeController::class, 'toggleBilled'])->middleware('permission:user.access.times.mark-billed')->name('toggleBilled');
        Route::delete('/', [TimeController::class, 'destroy'])->middleware('model_belongs_to_user:time,user.access.times.delete-all')->name('destroy');
    });

    Route::post('/toggleBilled', [TimeController::class, 'bulkToggleBilled'])->middleware('permission:user.access.times.mark-billed')->name('bulkToggleBilled')->middleware(['times']);
    Route::delete('/', [TimeController::class, 'bulkDestroy'])->middleware('model_belongs_to_user:time,user.access.times.delete-all')->name('bulkDestroy')->middleware('times');
});