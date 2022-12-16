<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\TimeController;
use App\Http\Controllers\Frontend\ClientController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\InvoiceController;
use App\Http\Controllers\Frontend\User\SubuserController;
use App\Domains\Auth\Http\Controllers\Frontend\Auth\LoginController;

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

Route::group(['as' => 'invoice.api.'], function () {
    Route::get('/generate-invoice', [InvoiceController::class, 'generateInvoice'])->name('generate-invoice');
}); 

Route::group(['as' => 'user.api.', 'middleware' => ['cors']], function () {
    Route::post('/login', [LoginController::class, 'apiLogin'])->name('login');
}); 

Route::group(['as' => 'user.api.time.', 'middleware' => [
        'cors',
        'permission:user.access.times.access', 
        'permission:user.access.users.api', 
        'auth:api', 
        'password.expires', 
        config('boilerplate.access.middleware.verified')
    ]
], function () {
    Route::get('/get-times', [TimeController::class, 'getTimes'])->name('getTimes');
    Route::post('/store-time', [TimeController::class, 'store'])->withoutMiddleware('permission:user.access.users.api')->name('store');

    Route::group(['prefix' => '{time}', 'middleware' => 'model_belongs_to_user_organization:time'], function () {
        Route::get('/get-time', [TimeController::class, 'get'])->name('get');
        Route::patch('/update-time', [TimeController::class, 'update'])->middleware('model_belongs_to_user:time,user.access.times.edit-all')->name('update');
        Route::patch('/toggleBilled-time', [TimeController::class, 'toggleBilled'])->middleware('permission:user.access.times.mark-billed')->name('toggleBilled');
        Route::delete('/delete-time', [TimeController::class, 'destroy'])->middleware('model_belongs_to_user:time,user.access.times.delete-all')->name('destroy');
    });
}); 

Route::group(['as' => 'user.api.clients.', 'middleware' => [
    'cors',
    'permission:user.access.clients.access', 
    'permission:user.access.users.api', 
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
    'cors',
    'permission:user.access.projects.access', 
    'permission:user.access.users.api', 
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

Route::group(['as' => 'user.api.invoices.', 'middleware' => [
    'cors',
    'permission:user.access.invoices.access', 
    'permission:user.access.users.api', 
    'auth:api', 
    'password.expires', 
    config('boilerplate.access.middleware.verified')
]
], function () {
    Route::get('/get-invoices', [InvoiceController::class, 'getInvoices'])->name('getInvoices');
    Route::post('/store-invoice', [InvoiceController::class, 'store'])->middleware('permission:user.access.invoices.create')->name('store');

    Route::group(['prefix' => '{invoice}', 'middleware' => 'model_belongs_to_user_organization:invoice'], function () {
        Route::get('/get-invoice', [InvoiceController::class, 'get'])->name('get');
        Route::get('/download', [InvoiceController::class, 'download'])->middleware('model_belongs_to_user:invoice,user.access.invoices.show-all')->name('download');
        Route::patch('/update-invoice', [InvoiceController::class, 'update'])->middleware('model_belongs_to_user:invoice,user.access.invoices.edit-all')->name('update');
        Route::patch('/updateStatus', [InvoiceController::class, 'updateStatus'])->middleware('model_belongs_to_user:invoice,user.access.invoices.update-status-all')->name('updateStatus');
        Route::delete('/delete-invoice', [InvoiceController::class, 'destroy'])->middleware('model_belongs_to_user:invoice,user.access.invoices.delete-all')->name('destroy');
    });
}); 