<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\TableComponent;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class ProjectsTable.
 */
class ProjectsTable extends TableComponent
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
        return Project::query()->where('user_id', auth()->user()->id);
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
            Column::make(__('Company Name'))
                ->searchable()
                ->sortable(),
            Column::make(__('Tax Number'))
                ->searchable()
                ->sortable(),
            Column::make(__('Vat Number'))
                ->searchable()
                ->sortable(),
            Column::make(__('Address'))
                ->searchable()
                ->sortable(),
            Column::make(__('Actions'))
                ->format(function (Project $model) {
                    return view('frontend.projects.includes.actions', ['model' => $model]);
                }),
        ];
    }
}