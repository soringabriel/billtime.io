<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\TableComponent;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class PlansTable.
 */
class PlansTable extends TableComponent
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
            Column::make(__('Name'))
                ->searchable()
                ->sortable(),
            Column::make(__('Price'))
                ->searchable()
                ->sortable(),
            Column::make(__('Currency'))
                ->searchable()
                ->sortable(),
            Column::make(__('Paddle Id'))
                ->searchable()
                ->sortable(),
            Column::make(__('Actions'))
                ->format(function (Plan $model) {
                    return view('backend.plan.includes.actions', ['model' => $model]);
                }),
        ];
    }
}
