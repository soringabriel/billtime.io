<?php

use App\Http\Controllers\Frontend\ScheduleController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Schedule;

Route::group([
    'prefix' => 'schedules',
    'as' => 'schedules.',
    'middleware' => ['permission:user.access.users.schedule', 'auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::get('/', [ScheduleController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.dashboard')
                ->push(__('Schedule Managment'), route('frontend.schedules.index'));
    });

    Route::get('create', [ScheduleController::class, 'create'])
        ->name('create')
        ->middleware('permission:user.access.schedules.create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.schedules.index')
                ->push(__('Add Schedule'), route('frontend.schedules.create'));
    });

    Route::post('/', [ScheduleController::class, 'store'])->middleware('permission:user.access.schedules.create')->name('store');

    Route::group(['prefix' => '{schedule}', 'middleware' => 'model_belongs_to_user_organization:schedule'], function () {
        Route::get('edit', [ScheduleController::class, 'edit'])
            ->name('edit')
            ->middleware('permission:user.access.schedules.edit')
            ->breadcrumbs(function (Trail $trail, Schedule $schedule) {
                $trail->parent('frontend.schedules.index')
                    ->push(__('Editing :schedule', ['schedule' => $schedule->name]), route('frontend.schedules.edit', $schedule));
        });
        Route::patch('/', [ScheduleController::class, 'update'])->middleware('permission:user.access.schedules.edit')->name('update');
        Route::delete('/', [ScheduleController::class, 'destroy'])->middleware('permission:user.access.schedules.delete')->name('destroy');
    });
});