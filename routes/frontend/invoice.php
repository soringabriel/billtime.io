<?php

use App\Http\Controllers\Frontend\InvoiceController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Invoice;

Route::group([
    'prefix' => 'invoices',
    'as' => 'invoices.',
    'middleware' => ['permission:user.access.invoices.access', 'auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::get('/', [InvoiceController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.dashboard')
                ->push(__('Invoice Managment'), route('frontend.invoices.index'));
    });

    Route::get('create', [InvoiceController::class, 'create'])
        ->name('create')
        ->middleware('permission:user.access.invoices.create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.invoices.index')
                ->push(__('Add Invoice'), route('frontend.invoices.create'));
    });

    Route::post('/', [InvoiceController::class, 'store'])->middleware('permission:user.access.invoices.create')->name('store');

    Route::group(['prefix' => '{invoice}', 'middleware' => ['model_belongs_to_user_organization:invoice']], function () {
        Route::get('edit', [InvoiceController::class, 'edit'])
            ->name('edit')
            ->middleware('model_belongs_to_user:invoice,user.access.invoices.edit-all')
            ->breadcrumbs(function (Trail $trail, Invoice $invoice) {
                $trail->parent('frontend.invoices.index')
                    ->push(__('Editing :invoice', ['invoice' => $invoice->name]), route('frontend.invoices.edit', $invoice));
        });
        Route::get('download', [InvoiceController::class, 'download'])->middleware('model_belongs_to_user:invoice,user.access.invoices.show-all')->name('download');
        Route::patch('/', [InvoiceController::class, 'update'])->middleware('model_belongs_to_user:invoice,user.access.invoices.edit-all')->name('update');
        Route::patch('/updateStatus', [InvoiceController::class, 'updateStatus'])->middleware('model_belongs_to_user:invoice,user.access.invoices.update-status-all')->name('updateStatus');
        Route::delete('/', [InvoiceController::class, 'destroy'])->middleware('model_belongs_to_user:invoice,user.access.invoices.delete-all')->name('destroy');
    });
});