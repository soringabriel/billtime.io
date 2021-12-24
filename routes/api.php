<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\TimeController;

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
        'permission:user.access.times.automatic-time', 
        'auth:api', 
        'password.expires', 
        config('boilerplate.access.middleware.verified')
    ]
], function () {
    Route::get('/get-times', [TimeController::class, 'getTimes'])->name('getTimes');
    Route::post('/store-time', [TimeController::class, 'store'])->name('store');

    Route::group(['prefix' => '{time}', 'middleware' => 'model_belongs_to_user_organization:time'], function () {
        Route::get('/get-time', [TimeController::class, 'get'])->middleware('model_belongs_to_user:time,user.access.times.edit-all')->name('get');
        Route::patch('/update-time', [TimeController::class, 'update'])->middleware('model_belongs_to_user:time,user.access.times.edit-all')->name('update');
        Route::patch('/toggleBilled-time', [TimeController::class, 'toggleBilled'])->middleware('permission:user.access.times.mark-billed')->name('toggleBilled');
        Route::delete('/delete-time', [TimeController::class, 'destroy'])->middleware('model_belongs_to_user:time,user.access.times.delete-all')->name('destroy');
    });
}); 