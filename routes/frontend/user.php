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
            $trail->parent('frontend.index')
                ->push(__('My Account'), route('frontend.user.account'));
        });

    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/updateCompanyDetails', [ProfileController::class, 'updateCompanyDetails'])->name('profile.updateCompanyDetails');
    
    Route::group([
        'prefix' => 'subuser',
        'as' => 'subuser.',
        'middleware' => 'parent_user',
    ], function () {
        Route::get('/', [SubuserController::class, 'index'])
            ->name('index')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('frontend.index')
                    ->push(__('User Management'), route('frontend.user.subuser.index'));
            });

        Route::get('deleted', [DeletedSubuserController::class, 'index'])
            ->name('deleted')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('frontend.user.subuser.index')
                    ->push(__('Deleted Users'), route('frontend.user.subuser.deleted'));
            });

        Route::get('create', [SubuserController::class, 'create'])
            ->name('create')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('frontend.user.subuser.index')
                    ->push(__('Create User'), route('frontend.user.subuser.create'));
            });

        Route::post('/', [SubuserController::class, 'store'])->name('store');

        Route::group([
            'middleware' => 'subuser',
        ], function () {
            Route::group(['prefix' => '{user}'], function () {
                Route::get('/', [SubuserController::class, 'show'])
                    ->name('show')
                    ->breadcrumbs(function (Trail $trail, User $user) {
                        $trail->parent('frontend.user.subuser.index')
                            ->push($user->name, route('frontend.user.subuser.show', $user));
                    });

                Route::get('edit', [SubuserController::class, 'edit'])
                    ->name('edit')
                    ->breadcrumbs(function (Trail $trail, User $user) {
                        $trail->parent('frontend.user.subuser.show', $user)
                            ->push(__('Edit'), route('frontend.user.subuser.edit', $user));
                    });

                Route::patch('/', [SubuserController::class, 'update'])->name('update');
                Route::delete('/', [SubuserController::class, 'destroy'])->name('destroy');
            });

            Route::group(['prefix' => '{deletedUser}'], function () {
                Route::patch('restore', [DeletedSubuserController::class, 'update'])->name('restore');
                Route::delete('permanently-delete', [DeletedSubuserController::class, 'destroy'])->name('permanently-delete');
            });
        });
    });
});
