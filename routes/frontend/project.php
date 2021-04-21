<?php

use App\Http\Controllers\Frontend\ProjectController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Project;

Route::group([
    'prefix' => 'projects',
    'as' => 'projects.',
    'middleware' => ['organization_owner', 'auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::get('/', [ProjectController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.index')
                ->push(__('Project Managment'), route('frontend.projects.index'));
    });

    Route::get('create', [ProjectController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.projects.index')
                ->push(__('Add Project'), route('frontend.projects.create'));
    });

    Route::post('/', [ProjectController::class, 'store'])->name('store');

    Route::group(['prefix' => '{project}', 'middleware' => 'model_belongs_to_user_organization:project'], function () {
        Route::get('edit', [ProjectController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Project $project) {
                $trail->parent('frontend.projects.index')
                    ->push(__('Editing :project', ['project' => $project->name]), route('frontend.projects.edit', $project));
        });
        Route::patch('/', [ProjectController::class, 'update'])->name('update');
        Route::delete('/', [ProjectController::class, 'destroy'])->name('destroy');
    });
});