<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Time;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\TableComponent;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class TimeTable.
 */
class TimeTable extends TableComponent
{
    use HtmlComponents;

    /**
     * @var string
     */
    public $sortField = 'start_time';

    /**
     * @var array
     */
    public $exportFileName = "time_records";

    /**
     * @var array
     */
    public $exports = ['csv', 'xls', 'xlsx'];

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
        return Time::query()->whereIn('user_id', array_merge([auth()->user()->id], auth()->user()->subUsers()->pluck('id')->toArray()));
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            Column::make(__('User'))
                ->searchable()
                ->sortable()
                ->format(function (Time $model) {
                    return $model->user->name;
                }),
            Column::make(__('Start Time'))
                ->searchable()
                ->sortable(),
            Column::make(__('End Time'))
                ->searchable()
                ->sortable(),
            Column::make(__('Project'))
                ->searchable()
                ->sortable()
                ->format(function (Time $model) {
                    return $model->project->name;
                }),
            Column::make(__('Task'))
                ->searchable()
                ->sortable(),
            Column::make(__('Details'))
                ->searchable()
                ->sortable()
                ->exportOnly(),
            Column::make(__('Actions'))
                ->format(function (Time $model) {
                    return view('frontend.time.includes.actions', ['model' => $model]);
                })
                ->excludeFromExport(),
        ];
    }
}