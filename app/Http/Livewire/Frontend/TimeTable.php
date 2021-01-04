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
    public $exportCustomCells = [
        'I3' => 'Total time',
        'J3' => '=sum(G2:G100)',
    ];

    /**
     * @var array
     */
    public $exportColumnFormats = [
        'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'G' => NumberFormat::FORMAT_DATE_TIME3,
        'J' => NumberFormat::FORMAT_DATE_TIME3,
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
                ->searchable(function ($builder, $term) {
                    $users = User::where('name', 'like', '%' . $term . '%')->pluck('id')->toArray();
                    return $builder->orWhereIn('user_id', $users);
                })
                ->format(function (Time $model) {
                    return $model->user->name;
                }),
            ColumnExtended::make(__('Start Time'))
                ->searchable()
                ->sortable()
                ->format(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->start_time)->format('jS F Y H:i');
                })
                ->exportFormat(function (Time $model) {
                    return $model->start_time;
                }),
            ColumnExtended::make(__('End Time'))
                ->searchable()
                ->sortable()
                ->format(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->end_time)->format('jS F Y H:i');
                })
                ->exportFormat(function (Time $model) {
                    return $model->end_time;
                }),
            ColumnExtended::make(__('Project'))
                ->searchable(function ($builder, $term) {
                    $projects = Project::where('name', 'like', '%' . $term . '%')->pluck('id')->toArray();
                    return $builder->orWhereIn('project_id', $projects);
                })
                ->format(function (Time $model) {
                    return $model->project->name;
                }),
            ColumnExtended::make(__('Task'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Details'))
                ->sortable()
                ->exportOnly(),
            ColumnExtended::make(__('Time'))
                ->totalable(function() use ($timeTable) {
                    CarbonInterval::setCascadeFactors([
                        'minute' => [60, 'seconds'],
                        'hour' => [60, 'minutes'],
                    ]);        
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
                    CarbonInterval::setCascadeFactors([
                        'minute' => [60, 'seconds'],
                        'hour' => [60, 'minutes'],
                    ]);        
                    $interval = Carbon::createFromFormat('Y-m-d H:i:s', $model->end_time)->diffAsCarbonInterval(Carbon::createFromFormat('Y-m-d H:i:s', $model->start_time))->cascade();
                    return $interval->hours . ':' . $interval->minutes;
                }),
            ColumnExtended::make(__('Actions'))
                ->format(function (Time $model) {
                    return view('frontend.time.includes.actions', ['model' => $model]);
                })
                ->excludeFromExport(),
        ];
    }
}