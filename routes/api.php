<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\TimeController;
use App\Http\Controllers\Frontend\ClientController;
use App\Http\Controllers\Frontend\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['as' => 'user.api.time.', 'middleware' => [
        'permission:user.access.times.access', 
        'auth:api', 
        'password.expires', 
        config('boilerplate.access.middleware.verified')
    ]
], function () {
    Route::get('/get-times', [TimeController::class, 'getTimes'])->name('getTimes');
    Route::post('/store-time', [TimeController::class, 'store'])->name('store');

    Route::group(['prefix' => '{time}', 'middleware' => 'model_belongs_to_user_organization:time'], function () {
        Route::get('/get-time', [TimeController::class, 'get'])->name('get');
        Route::patch('/update-time', [TimeController::class, 'update'])->middleware('model_belongs_to_user:time,user.access.times.edit-all')->name('update');
        Route::patch('/toggleBilled-time', [TimeController::class, 'toggleBilled'])->middleware('permission:user.access.times.mark-billed')->name('toggleBilled');
        Route::delete('/delete-time', [TimeController::class, 'destroy'])->middleware('model_belongs_to_user:time,user.access.times.delete-all')->name('destroy');
    });
}); 

Route::group(['as' => 'user.api.clients.', 'middleware' => [
    'permission:user.access.clients.access', 
    'auth:api', 
    'password.expires', 
    config('boilerplate.access.middleware.verified')
]
], function () {
    Route::get('/get-clients', [ClientController::class, 'getClients'])->name('getClients');
    Route::post('/store-client', [ClientController::class, 'store'])->middleware('permission:user.access.clients.create')->name('store');

    Route::group(['prefix' => '{client}', 'middleware' => 'model_belongs_to_user_organization:client'], function () {
        Route::get('/get-client', [ClientController::class, 'get'])->name('get');
        Route::patch('/update-client', [ClientController::class, 'update'])->middleware('permission:user.access.clients.edit')->name('update');
        Route::delete('/delete-client', [ClientController::class, 'destroy'])->middleware('permission:user.access.clients.delete')->name('destroy');
    });
}); 

Route::group(['as' => 'user.api.projects.', 'middleware' => [
    'permission:user.access.projects.access', 
    'auth:api', 
    'password.expires', 
    config('boilerplate.access.middleware.verified')
]
], function () {
    Route::get('/get-projects', [ProjectController::class, 'getProjects'])->name('getProjects');
    Route::post('/store-project', [ProjectController::class, 'store'])->middleware('permission:user.access.projects.create')->name('store');

    Route::group(['prefix' => '{project}', 'middleware' => 'model_belongs_to_user_organization:project'], function () {
        Route::get('/get-project', [ProjectController::class, 'get'])->name('get');
        Route::patch('/update-project', [ProjectController::class, 'update'])->middleware('permission:user.access.projects.edit')->name('update');
        Route::delete('/delete-project', [ProjectController::class, 'destroy'])->middleware('permission:user.access.projects.delete')->name('destroy');
    });
}); 