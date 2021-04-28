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
use Illuminate\Support\HtmlString;

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
    public $bulk = true;

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
     * @var bool
     */
    public $isInvoice = false;

    /**
     * @var array
     */
    public $bulkDelete = [
        'route' => 'frontend.time.bulkDestroy',
        'permission' => 'user.access.times.delete-all',
    ];

    /**
     * @var array
     */
    public $bulkBill = [
        'route' => 'frontend.time.bulkToggleBilled',
        'permission' => 'user.access.times.mark-billed',
    ];

    /**
     * @var bool
     */
    public $customFiltersEnabled = true;

    /**
     * @var array
     */
    public $preCheckedValues = [];

    /**
     * @var bool
     */
    public $hiddenDataBulk = [
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
        'J3' => '=sum(G2:G1000)',
    ];

    /**
     * @var array
     */
    public $exportColumnFormats = [
        'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'G' => "[h]:mm",
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
     * @return void
     */
    public function mount(
        $filtersEnabled = true, 
        $customFiltersEnabled = true, 
        $isInvoice = false, 
        $bulkActions = true,
        $bulk = true,
        $exports = true,
        $preCheckedValues = "[]"
    ) {
        $this->filtersEnabled = $filtersEnabled;
        $this->customFiltersEnabled = $customFiltersEnabled;
        $this->isInvoice = $isInvoice;
        $this->bulkActions = $bulkActions;
        $this->bulk = $bulk;
        $this->preCheckedValues = json_decode($preCheckedValues);
        if (!$exports || !auth()->user()->can('user.access.times.export')) {
            $this->exports = [];
        }
    }

    /**
     * @return string
     */
    public function customFilters()
    {
        return $this->html('
        <div class="col">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text">' . __('Billed') . '</label>
                </div>
                <select class="form-control"
                    wire:model.debounce.' . $this->customFiltersDebounce . 'ms="customFilters.billed"
                    wire:model.lazy="customFilters.billed"
                    wire:loading.attr="disabled"
                    placeholder="' . __("Billed") . '"
                >
                    <option value="">' . __("Any") . '</option>
                    <option value="1">' . __("Billed") . '</option>
                    <option value="0">' . __("Non Billed") . '</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="input-group">
                <input class="form-control" type="date"
                    wire:model.debounce.' . $this->customFiltersDebounce . 'ms="customFilters.start"
                    wire:model.lazy="customFilters.start"
                    wire:loading.attr="disabled"
                    placeholder="Start Time"
                />
                <input class="form-control" type="date" 
                    wire:model.debounce.' . $this->customFiltersDebounce . 'ms="customFilters.end"
                    wire:model.lazy="customFilters.end"
                    wire:loading.attr="disabled"
                    placeholder="End Time"
                />
            </div>
        </div>
        ');
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $organization_users = is_null(auth()->user()->organization()->first()) ? [] : auth()->user()->organization()->first()->users()->pluck('id')->toArray();
        $users = auth()->user()->can('user.access.times.show-all') ? $organization_users : [auth()->user()->id];
        return Time::query()->whereIn('user_id', $users);
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        $timeTable = $this;
        $columns = [
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
            ColumnExtended::make(__('User'))
                ->withFilter(function ($builder, $term) {
                    $users = User::where('name', 'like', '%' . $term . '%')->pluck('id')->toArray();
                    return $builder->whereIn('user_id', $users);
                })
                ->format(function (Time $model) {
                    return $model->user->name;
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
            ColumnExtended::make(__('Billed'))
                ->sortable()
                ->format(function (Time $model) {
                    if ($model->billed) {
                        return $this->html('<span class="bg-success text-white text-nowrap rounded p-1">' . __('Billed') . '</span>');
                    }
                    return $this->html('<span class="bg-dark text-white text-nowrap rounded p-1">' . __('Not Billed') . '</span>');
                })
                ->excludeFromExport(),
            ColumnExtended::make(__('Details'))
                ->exportOnly(),
            ColumnExtended::make(__('Time'))
                ->totalable(function() use ($timeTable) {
                    $models = $timeTable->models()->get();
                    CarbonInterval::setCascadeFactors([
                        'minute' => [60, 'seconds'],
                        'hour' => [60, 'minutes'],
                    ]);
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
        ];
        if (!$this->isInvoice) {
            $columns[] = ColumnExtended::make(__('Actions'))
                            ->format(function (Time $model) {
                                return view('frontend.time.includes.actions', ['model' => $model]);
                            })
                            ->excludeFromExport();
        }
        return $columns;
    }

        
    /**
     * @return Builder
     */
    public function models(): Builder
    {
        $builder = parent::models();

        if (isset($this->customFilters['start']) && $this->customFilters['start'] != "") {
            $builder->where('end_time', '>=', Carbon::parse($this->customFilters['start'])->format('Y-m-d'));
        }

        if (isset($this->customFilters['end']) && $this->customFilters['end'] != "") {
            $builder->where('end_time', '<=', Carbon::parse($this->customFilters['end'])->format('Y-m-d'));
        }

        if (isset($this->customFilters['billed']) && $this->customFilters['billed'] != "") {
            $builder->where('billed', $this->customFilters['billed']);
        }

        return $builder;
    }
}