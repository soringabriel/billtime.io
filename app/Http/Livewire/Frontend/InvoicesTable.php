<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class InvoicesTable.
 */
class InvoicesTable extends TableComponentExtended
{
    use HtmlComponents;

    /**
     * @var string
     */
    public $sortField = 'number';

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
        return Invoice::query()->where('user_id', auth()->user()->id);
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ColumnExtended::make(__('Number'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Buyer'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Seller'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Status'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Price'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Date'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Actions'))
                ->format(function (Invoice $model) {
                    return view('frontend.invoices.includes.actions', ['model' => $model]);
                }),
        ];
    }
}