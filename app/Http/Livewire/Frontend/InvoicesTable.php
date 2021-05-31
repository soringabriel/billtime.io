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
    public $sortField = 'created_at';

    /**
     * @var string
     */
    public $sortDirection = 'desc';

    /**
     * @var bool
     */
    public $filtersEnabled = true;

    /**
     * @var array
     */
    protected $options = [
        'bootstrap.container' => false,
        'bootstrap.classes.table' => 'table table-striped',
    ];

    /**
     * @var array
     */
    public $emptyTableAction = [
        'route' => 'frontend.invoices.create',
        'text' => 'Add Your First Invoice',
    ];

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        if (auth()->user()->can('user.access.invoices.show-all')) {
            return Invoice::query()->whereIn('user_id', auth()->user()->organization()->first()->users()->pluck('id'));
        }
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
                ->sortable()
                ->withFilter(),
            ColumnExtended::make(__('Buyer'), 'buyer_company_name')
                ->searchable()
                ->sortable()
                ->withFilter(),
            ColumnExtended::make(__('Seller'), 'seller_company_name')
                ->searchable()
                ->sortable()
                ->withFilter(),
            ColumnExtended::make(__('Status'))
                ->searchable()
                ->sortable()
                ->withFilter()
                ->format(function (Invoice $model) {
                    if ($model->isPending()) {
                        return $this->html('<span class="bg-dark text-white text-nowrap rounded p-1">' . __('Pending') . '</span>');
                    }
                    if ($model->isPastDue()) {
                        return $this->html('<span class="bg-danger text-white text-nowrap rounded p-1">' . __('Past Due') . '</span>');
                    }
                    if ($model->isPaid()) {
                        return $this->html('<span class="bg-success text-white text-nowrap rounded p-1">' . __('Paid') . '</span>');
                    }
                    return $this->html('<span class="bg-default text-dark text-nowrap rounded p-1">' . $model->status . '</span>');
                }),
            ColumnExtended::make(__('Price'))
                ->searchable()
                ->sortable()
                ->withFilter(),
            ColumnExtended::make(__('Currency'))
                ->searchable()
                ->sortable()
                ->withFilter(),
            ColumnExtended::make(__('Due Date'))
                ->searchable()
                ->sortable()
                ->withFilter()
                ->format(function (Invoice $model) {
                    return $model->due_date ?? __('N/A');
                }),
            ColumnExtended::make(__('Date'))
                ->searchable()
                ->sortable()
                ->withFilter(),
            ColumnExtended::make(__('Actions'))
                ->format(function (Invoice $model) {
                    return view('frontend.invoices.includes.actions', ['model' => $model]);
                }),
        ];
    }
}