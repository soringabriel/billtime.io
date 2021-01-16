<?php

namespace App\Http\Livewire\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\Time;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Class TimeTable.
 */
class TimeTable extends TableComponentExtended
{
    use HtmlComponents;

    /**
     * @var bool
     */
    public $total = true;

    /**
     * @var string
     */
    public $sortField = 'end_time';

    /**
     * @var string
     */
    public $sortDirection = 'desc';

    /**
     * @var array
     */
    public $exportFileName = "time_records";

    /**
     * @var array
     */
    public $exports = ['csv', 'xls', 'xlsx'];

    /**
     * @var bool
     */
    public $bulkActions = true;

    /**
     * @var bool
     */
    public $searchEnabled = false;

    /**
     * @var bool
     */
    public $filtersEnabled = true;

    /**
     * @var string
     */
    public $bulkDelete = 'frontend.time.bulkDestroy';

    /**
     * @var bool
     */
    public $hiddenDataDelete = [
        [
            'name' => 'times',
            'class' => 'bulk-checkbox-values',
        ]
    ];

    /**
     * @var array
     */
    public $exportCustomCells = [
        'I3' => 'Total time',
        'J3' => '=sum(F2:F1000)',
    ];

    /**
     * @var array
     */
    public $exportColumnFormats = [
        'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'F' => "[h]:mm",
        'J' => "[h]:mm",
    ];

    /**
     * @var array
     */
    public $exportStyles = [
        1 => [
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'ffffff',
                ],
            ], 
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [
                    'rgb' => '538dd5',
                ],
            ],
        ],
        'I3' => ['font' => ['bold' => true]],
    ];

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
        $timeTable = $this;
        return [
            ColumnExtended::make(__('User'))
                ->withFilter(function ($builder, $term) {
                    $users = User::where('name', 'like', '%' . $term . '%')->pluck('id')->toArray();
                    return $builder->whereIn('user_id', $users);
                })
                ->format(function (Time $model) {
                    return $model->user->name;
                })
                ->excludeFromExport(),
            ColumnExtended::make(__('Start Time'))
                ->sortable()
                ->withFilter()
                ->format(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->start_time)->format('jS F Y H:i');
                })
                ->exportFormat(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->start_time)->format('m-d-Y H:i');
                }),
            ColumnExtended::make(__('End Time'))
                ->sortable()
                ->withFilter()
                ->format(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->end_time)->format('jS F Y H:i');
                })
                ->exportFormat(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->end_time)->format('m-d-Y H:i');
                }),
            ColumnExtended::make(__('Project'))
                ->withFilter(function ($builder, $term) {
                    $projects = Project::where('name', 'like', '%' . $term . '%')->pluck('id')->toArray();
                    return $builder->whereIn('project_id', $projects);
                })
                ->format(function (Time $model) {
                    return $model->project->name;
                }),
            ColumnExtended::make(__('Task'))
                ->sortable()
                ->withFilter()
                ->format(function (Time $model) {
                    $task_array = explode("/", $model->task);
                    $task_title = end($task_array);
                    return $this->html('<a href="' . $model->task . '" target="_blank">' . $task_title . '</a>');
                })
                ->exportFormat(function (Time $model) {
                    return $model->task;
                }),
            ColumnExtended::make(__('Details'))
                ->exportOnly(),
            ColumnExtended::make(__('Time'))
                ->totalable(function() use ($timeTable) {
                    $models = $timeTable->models()->get();
                    $total = CarbonInterval::create(0, 0, 0, 0, 0, 0, 0, 0);
                    foreach ($models as $model) {
                        $total->add(Carbon::createFromFormat('Y-m-d H:i:s', $model->end_time)->diffAsCarbonInterval(Carbon::createFromFormat('Y-m-d H:i:s', $model->start_time)));
                    }
                    return $total->cascade()->forHumans();
                })
                ->format(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->end_time)->diffAsCarbonInterval(Carbon::createFromFormat('Y-m-d H:i:s', $model->start_time));
                })
                ->exportFormat(function (Time $model) {
                    return '=INDIRECT("B" & ROW()) - INDIRECT("A" & ROW())';
                }),
            ColumnExtended::make(__('Actions'))
                ->format(function (Time $model) {
                    return view('frontend.time.includes.actions', ['model' => $model]);
                })
                ->excludeFromExport(),
        ];
    }
}