<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;
use App\Http\Controllers\Backend\PlansController;
use App\Http\Controllers\Backend\FeedbacksController;
use App\Models\Plan;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });

Route::group([
    'prefix' => 'plan',
    'as' => 'plan.',
], function () {
    Route::get('/', [PlansController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Plan Managment'), route('admin.plan.index'));
    });

    Route::get('create', [PlansController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('admin.plan.index')
                ->push(__('Create Plan'), route('admin.plan.create'));
    });

    Route::post('/', [PlansController::class, 'store'])->name('store');

    Route::group(['prefix' => '{plan}'], function () {
        Route::get('edit', [PlansController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Plan $plan) {
                $trail->parent('admin.plan.index')
                    ->push(__('Editing :plan', ['plan' => $plan->name]), route('admin.plan.edit', $plan));
        });
        Route::patch('/', [PlansController::class, 'update'])->name('update');
        Route::delete('/', [PlansController::class, 'destroy'])->name('destroy');
    });
});

Route::group([
    'prefix' => 'feedback',
    'as' => 'feedback.',
], function () {
    Route::get('/', [FeedbacksController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Feedbacks'), route('admin.feedback.index'));
    });
});