<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Email;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class EmailsTable.
 */
class EmailsTable extends TableComponentExtended
{
    use HtmlComponents;

    /**
     * @var string
     */
    public $sortField = 'created_at';

    /**
     * @var string
     */
    public $sortDirection = 'desc';

    /**
     * @var array
     */
    protected $options = [
        'bootstrap.container' => false,
        'bootstrap.classes.table' => 'table table-striped',
    ];

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        if (auth()->user()->can('user.access.invoices.show-all')) {
            $all_invoices = Invoice::whereIn('user_id', auth()->user()->organization()->first()->users()->pluck('id'))->pluck('id')->toArray();
        } else {
            $all_invoices = Invoice::where('user_id', auth()->user()->id)->pluck('id')->toArray();
        }
        return Email::query()->whereIn('invoice_id', $all_invoices);
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ColumnExtended::make(__('From'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('To'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Locale'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Invoice Number'))
                ->format(function (Email $model) {
                    $invoice = $model->invoice()->first();
                    return $invoice->number;
                }),
            ColumnExtended::make(__('Created At'))
                ->searchable()
                ->sortable(),
        ];
    }
}