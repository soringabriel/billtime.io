<?php

use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DeactivatedSubuserController;
use App\Http\Controllers\Frontend\User\DeletedSubuserController;
use App\Http\Controllers\Frontend\User\SubuserController;
use App\Domains\Auth\Models\User;
use Tabuna\Breadcrumbs\Trail;

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the user has not confirmed their email
 */
Route::group(['as' => 'user.', 'middleware' => ['auth', 'password.expires', config('boilerplate.access.middleware.verified')]], function () {
    Route::get('account', [AccountController::class, 'index'])
        ->name('account')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.dashboard')
                ->push(__('My Account'), route('frontend.user.account'));
        });

    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/updateOrganizationDetails', [ProfileController::class, 'updateOrganizationDetails'])->middleware('organization_owner')->name('profile.updateOrganizationDetails');
    
    Route::group([
        'prefix' => 'subuser',
        'as' => 'subuser.',
        'middleware' => 'permission:user.access.users.access',
    ], function () {
        Route::get('/', [SubuserController::class, 'index'])
            ->name('index')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('frontend.dashboard')
                    ->push(__('User Management'), route('frontend.user.subuser.index'));
            });

        Route::get('deleted', [DeletedSubuserController::class, 'index'])
            ->name('deleted')
            ->middleware('permission:user.access.users.delete')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('frontend.user.subuser.index')
                    ->push(__('Deleted Users'), route('frontend.user.subuser.deleted'));
            });

        Route::get('create', [SubuserController::class, 'create'])
            ->name('create')
            ->middleware('permission:user.access.users.create', 'subusers_quota')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('frontend.user.subuser.index')
                    ->push(__('Create User'), route('frontend.user.subuser.create'));
            });

        Route::post('/', [SubuserController::class, 'store'])->middleware('permission:user.access.users.create', 'subusers_quota')->name('store');

        Route::group(['prefix' => '{user}', 'middleware' => 'model_belongs_to_user_organization:user'], function () {
            Route::get('/', [SubuserController::class, 'show'])
                ->name('show')
                ->middleware('not_organization_owner')
                ->breadcrumbs(function (Trail $trail, User $user) {
                    $trail->parent('frontend.user.subuser.index')
                        ->push($user->name, route('frontend.user.subuser.show', $user));
                });

            Route::get('edit', [SubuserController::class, 'edit'])
                ->name('edit')
                ->middleware(['not_organization_owner', 'permission:user.access.users.edit'])
                ->breadcrumbs(function (Trail $trail, User $user) {
                    $trail->parent('frontend.user.subuser.show', $user)
                        ->push(__('Edit'), route('frontend.user.subuser.edit', $user));
                });

            Route::patch('/', [SubuserController::class, 'update'])->middleware(['not_organization_owner', 'permission:user.access.users.edit'])->name('update');
            Route::delete('/', [SubuserController::class, 'destroy'])->middleware(['not_organization_owner', 'permission:user.access.users.delete'])->name('destroy');
        });

        Route::group(['prefix' => '{deletedUser}', 'middleware' => ['permission:user.access.users.delete', 'model_belongs_to_user_organization:deletedUser']], function () {
            Route::patch('restore', [DeletedSubuserController::class, 'update'])->middleware('subusers_quota')->name('restore');
            Route::delete('permanently-delete', [DeletedSubuserController::class, 'destroy'])->name('permanently-delete');
        });
    });
});
