<?php

use App\Http\Controllers\Frontend\ProjectController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Project;

Route::group([
    'prefix' => 'project',
    'as' => 'project.',
    'middleware' => ['parent_user', 'auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::get('/', [ProjectController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Project Managment'), route('frontend.project.index'));
    });

    Route::get('create', [ProjectController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.project.index')
                ->push(__('Add Project'), route('frontend.project.create'));
    });

    Route::post('/', [ProjectController::class, 'store'])->name('store');

    Route::group(['prefix' => '{project}', 'middleware' => 'project'], function () {
        Route::get('edit', [ProjectController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Project $project) {
                $trail->parent('frontend.project.index')
                    ->push(__('Editing :project', ['project' => $project->name]), route('frontend.project.edit', $project));
        });
        Route::patch('/', [ProjectController::class, 'update'])->name('update');
        Route::delete('/', [ProjectController::class, 'destroy'])->name('destroy');
    });
});