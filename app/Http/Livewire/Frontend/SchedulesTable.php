<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class SchedulesTable.
 */
class SchedulesTable extends TableComponentExtended
{
    use HtmlComponents;

    /**
     * @var string
     */
    public $sortField = 'created_at';

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
        'route' => 'frontend.schedules.create',
        'text' => 'Add Your First Schedule',
    ];

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Schedule::query()->whereIn('id', auth()->user()->organization()->first()->schedules()->pluck('id')->toArray());
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ColumnExtended::make(__('Project'))
                ->withFilter(function ($builder, $term) {
                    if (strlen($term)) {
                        $projects = Project::where('name', 'like', '%' . $term . '%')->pluck('id')->toArray();
                        return $builder->whereIn('project_id', $projects);
                    }
                    return $builder;
                })
                ->filterHtml(function ($column) {
                    $html = '<select class="form-control"
                        wire:model.lazy="filters.' . $column->getText() . '"
                        wire:loading.attr="disabled"
                    ><option value="">' . __('All') . '</option>';

                    $projects = auth()->user()->projects()->get();

                    foreach ($projects as $project) {
                        $html .= '<option value="' . $project->name . '">' . $project->name . '</option>';
                    }

                    $html .= '</select>';

                    return $this->html($html);
                })
                ->format(function (Schedule $model) {
                    return $model->project->name;
                }),
            ColumnExtended::make(__('Date Of Month'), 'schedule_trigger')
                ->searchable()
                ->sortable()
                ->withFilter(),
            ColumnExtended::make(__('Price Per Hour'), 'price_per_hour')
                ->searchable()
                ->sortable()
                ->withFilter(),
            ColumnExtended::make(__('Tax'), 'tax')
                ->searchable()
                ->sortable()
                ->withFilter(),
            ColumnExtended::make(__('Actions'))
                ->format(function (Schedule $model) {
                    return view('frontend.schedules.includes.actions', ['model' => $model]);
                }),
        ];
    }
}