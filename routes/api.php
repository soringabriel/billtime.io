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
    Route::post('/store-time', [TimeController::class, 'store'])->name('store');
}); 