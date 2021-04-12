<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class ProjectsTable.
 */
class ProjectsTable extends TableComponentExtended
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
            ColumnExtended::make(__('Name'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Client'))
                ->searchable(function ($builder, $term){
                    $clients = Client::where('name', 'like', '%' . $term . '%')->pluck('id')->toArray();
                    return $builder->orWhereIn('client_id', $clients);
                })
                ->sortable()
                ->format(function (Project $model) {
                    return $model->client()->first()->name;
                }),
            ColumnExtended::make(__('Actions'))
                ->format(function (Project $model) {
                    return view('frontend.projects.includes.actions', ['model' => $model]);
                }),
        ];
    }
}