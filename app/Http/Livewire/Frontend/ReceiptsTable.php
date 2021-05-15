<?php

namespace App\Http\Livewire\Frontend;

use Laravel\Paddle\Receipt;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;
use Illuminate\Support\HtmlString;

/**
 * Class ReceiptsTable.
 */
class ReceiptsTable extends TableComponentExtended
{
    use HtmlComponents;

    /**
     * @var string
     */
    public $sortField = 'paid_at';

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
        return Receipt::query()->where('billable_id', auth()->user()->organization()->first()->id)->where('amount', '>', '0');
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ColumnExtended::make(__('Number'), 'order_id')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Amount'), 'amount')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Tax'), 'tax')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Currency'), 'currency')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Paid At'), 'paid_at')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Receipt'))
                ->format(function (Receipt $model) {
                    return new HtmlString('<a target="_blank" href="' . $model->receipt_url . '">' . __('View') . '</a>');
                }),
        ];
    }
}