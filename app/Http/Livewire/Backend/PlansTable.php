<?php

namespace App\Http\Livewire\Backend;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class PlansTable.
 */
class PlansTable extends TableComponentExtended
{
    use HtmlComponents;

    /**
     * @var string
     */
    public $sortField = 'name';

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
        return Plan::query();
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ColumnExtended::make(__('Name'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Price'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Currency'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Paddle Id'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Actions'))
                ->format(function (Plan $model) {
                    return view('backend.plan.includes.actions', ['model' => $model]);
                }),
        ];
    }
}
