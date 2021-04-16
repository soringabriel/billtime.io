<?php

use App\Http\Controllers\Frontend\InvoiceController;
use Tabuna\Breadcrumbs\Trail;
use App\Models\Invoice;

Route::group([
    'prefix' => 'invoices',
    'as' => 'invoices.',
    'middleware' => ['organization_owner', 'auth', 'password.expires', config('boilerplate.access.middleware.verified')],
], function () {
    Route::get('/', [InvoiceController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.index')
                ->push(__('Invoice Managment'), route('frontend.invoices.index'));
    });

    Route::get('create', [InvoiceController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.invoices.index')
                ->push(__('Add Invoice'), route('frontend.invoices.create'));
    });

    Route::post('/', [InvoiceController::class, 'store'])->name('store');

    Route::group(['prefix' => '{invoice}', 'middleware' => 'model_belongs_to_user:invoice'], function () {
        Route::get('edit', [InvoiceController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Invoice $invoice) {
                $trail->parent('frontend.invoices.index')
                    ->push(__('Editing :invoice', ['invoice' => $invoice->name]), route('frontend.invoices.edit', $invoice));
        });
        Route::get('download', [InvoiceController::class, 'download'])->name('download');
        Route::patch('/', [InvoiceController::class, 'update'])->name('update');
        Route::patch('/updateStatus', [InvoiceController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/', [InvoiceController::class, 'destroy'])->name('destroy');
    });
});