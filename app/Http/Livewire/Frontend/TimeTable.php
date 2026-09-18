<?php

namespace App\Http\Livewire\Frontend;

use App\Domains\Auth\Models\User;
use App\Models\Time;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Client;
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

    // /**
    //  * @var bool
    //  */
    // public $total = true;

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
     * @var integer
     */
    public $checkedValuesTime = 0;

    /**
     * @var bool
     */
    public $hiddenDataBulk = [
        [
            'name' => 'times',
            'class' => 'bulk-checkbox-values',
            'value' => "[]",
        ]
    ];

    /**
     * @var array
     */
    public $exportCustomCells = [
        'J3' => 'Total time',
        'K3' => '=sum(H2:H1000)',
    ];

    /**
     * @var array
     */
    public $exportColumnFormats = [
        'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'H' => "[h]:mm",
        'K' => "[h]:mm",
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
        'J3' => ['font' => ['bold' => true]],
    ];

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
        'route' => 'frontend.time.create',
        'text' => 'Add Your First Time',
    ];

    /**
     * @return void
     */
    public function mount(
        $filtersEnabled = true, 
        $customFiltersEnabled = true,
        $customFilters = "[]",
        $filters = "[]",
        $isInvoice = false, 
        $bulkActions = true,
        $bulk = true,
        $exports = true,
        $preCheckedValues = "[]",
        $user = null
    ) {
        $this->user = $user ?? auth()->user();
        $this->filtersEnabled = $filtersEnabled;
        $this->customFiltersEnabled = $customFiltersEnabled;
        $this->customFilters = json_decode($customFilters, true);
        $this->filters = json_decode($filters, true);
        $this->isInvoice = $isInvoice;
        $this->bulkActions = $bulkActions;
        $this->bulk = $bulk;
        $this->preCheckedValues = json_decode($preCheckedValues) ?? [];
        $this->hiddenDataBulk[0]['value'] = json_encode($this->preCheckedValues ?? []);
        $this->setCheckedValuesTime($this->preCheckedValues);
        if (!$exports || !$this->user->can('user.access.times.export')) {
            $this->exports = [];
        }
    }

    /**
     * @return string
     */
    public function customFilters()
    {
        $invoices_html = "";
        if ($this->invoices) {
            $invoices_html = '
            <div class="col col-md-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text">' . __('Invoice') . '</label>
                    </div>
                    <select class="form-control"
                        wire:model.debounce.' . $this->customFiltersDebounce . 'ms="customFilters.invoice"
                        wire:model.lazy="customFilters.invoice"
                        wire:loading.attr="disabled"
                        placeholder="' . __("Invoice") . '"
                    >
                        <option value="">' . __("Any") . '</option>';
            foreach ($this->invoices as $invoice) {
                $invoices_html .= "<option value=" . $invoice->id . ">" . $invoice->number . "</option>";
            }
            $invoices_html .= "</select></div></div>";
        }
        return $this->html($invoices_html . '
        
        <div class="col col-md-2">
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
        <div class="col col-md-5">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text">' . __('Range') . '</label>
                </div>
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
        $this->user = isset($this->user) ? $this->user : auth()->user();
        $organization_users = is_null($this->user->organization()->first()) ? [] : $this->user->organization()->first()->users()->pluck('id')->toArray();
        $users = $this->user->can('user.access.times.show-all') ? $organization_users : [$this->user->id];
        $this->invoices = null;
        if ($this->user->can('user.access.invoices.access')) {
            $this->invoices = Invoice::without(['user', 'times'])->where('user_id', $this->user->id)->get(['id', 'number']);
        }
        if (count($users) == 1) {
            return Time::query()->where('user_id', $users[0]);
        }
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
                ->filterHtml(function ($column) {
                    return $this->html('
                        <input class="form-control" type="date" 
                            wire:model.lazy="filters.' . $column->getText() . '"
                            wire:loading.attr="disabled"
                        >
                    ');
                })
                ->format(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->start_time)->format('jS M Y H:i');
                })
                ->exportFormat(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->start_time)->format('m-d-Y H:i');
                }),
            ColumnExtended::make(__('End Time'))
                ->sortable()
                ->withFilter()
                ->filterHtml(function ($column) {
                    return $this->html('
                        <input class="form-control" type="date" 
                            wire:model.lazy="filters.' . $column->getText() . '"
                            wire:loading.attr="disabled"
                        >
                    ');
                })
                ->format(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->end_time)->format('jS M Y H:i');
                })
                ->exportFormat(function (Time $model) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $model->end_time)->format('m-d-Y H:i');
                }),
            ColumnExtended::make(__('User'))
                ->withFilter(function ($builder, $term) {
                    $users = User::where('name', 'like', '%' . $term . '%')->pluck('id')->toArray();
                    return $builder->whereIn('user_id', $users);
                })
                ->filterHtml(function ($column) use ($timeTable) {
                    $html = '<select class="form-control"
                        wire:model.lazy="filters.' . $column->getText() . '"
                        wire:loading.attr="disabled"
                    ><option value="">' . __('All') . '</option>';

                    $organization_users = is_null($this->user->organization()->first()) ? [] : $this->user->organization()->first()->users()->pluck('id')->toArray();
                    $user_ids = $this->user->can('user.access.times.show-all') ? $organization_users : [$this->user->id];
                    $users = User::whereIn('id', $user_ids)->get();

                    foreach ($users as $user) {
                        $html .= '<option value="' . $user->name . '">' . $user->name . '</option>';
                    }

                    $html .= '</select>';

                    return $this->html($html);
                })
                ->format(function (Time $model) {
                    return $model->user->name;
                }),
            ColumnExtended::make(__('Project'))
                ->withFilter(function ($builder, $term) {
                    if (strlen($term)) {
                        $projects = Project::where('name', 'like', '%' . $term . '%')->pluck('id')->toArray();
                        return $builder->whereIn('project_id', $projects);
                    }
                    return $builder;
                })
                ->filterHtml(function ($column) use ($timeTable) {
                    $html = '<select class="form-control"
                        wire:model.lazy="filters.' . $column->getText() . '"
                        wire:loading.attr="disabled"
                    ><option value="">' . __('All') . '</option>';

                    $projects = $this->user->projects()->get();

                    foreach ($projects as $project) {
                        $html .= '<option value="' . $project->name . '">' . $project->name . '</option>';
                    }

                    $html .= '</select>';

                    return $this->html($html);
                })
                ->format(function (Time $model) {
                    return $model->project->name;
                }),
            ColumnExtended::make(__('Client'))
                ->withFilter(function ($builder, $term) use ($timeTable) {
                    if (strlen($term) > 0) {
                        $projects = $this->user->clients()->where('name', 'like', '%' . $term . '%')->first()->projects()->pluck('id')->toArray();
                        return $builder->whereIn('project_id', $projects);
                    }
                    return $builder;
                })
                ->filterHtml(function ($column) use ($timeTable) {
                    $html = '<select class="form-control"
                        wire:model.lazy="filters.' . $column->getText() . '"
                        wire:loading.attr="disabled"
                    ><option value="">' . __('All') . '</option>';

                    $clients = $this->user->clients()->get();

                    foreach ($clients as $client) {
                        $html .= '<option value="' . $client->name . '">' . $client->name . '</option>';
                    }

                    $html .= '</select>';

                    return $this->html($html);
                })
                ->format(function (Time $model) {
                    return $model->project->client()->first()->name;
                }),
            ColumnExtended::make(__('Task'))
                ->exportOnly(),
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

        if (isset($this->customFilters['invoice']) && $this->customFilters['invoice'] != "") {
            $invoice = Invoice::find($this->customFilters['invoice']);
            $builder->whereIn('id', $invoice->times()->pluck('id')->toArray());
        }

        if (isset($this->customFilters['start']) && $this->customFilters['start'] != "") {
            $builder->where('end_time', '>=', Carbon::parse($this->customFilters['start'])->format('Y-m-d'));
        }

        if (isset($this->customFilters['end']) && $this->customFilters['end'] != "") {
            $builder->where('end_time', '<=', Carbon::parse($this->customFilters['end'])->format('Y-m-d'));
        }

        if (isset($this->customFilters['billed']) && $this->customFilters['billed'] != "") {
            $builder->where('billed', $this->customFilters['billed']);
        }

        $builder->orderBy('start_time', 'desc');

        return $builder;
    }

    /**
     * @return void
     */
    public function setCheckedValuesTime($checkedTimes)
    {
        if (!is_array($checkedTimes)) {
            $checkedTimes = json_decode($checkedTimes);
        }
        $this->preCheckedValues = $checkedTimes;
        $this->hiddenDataBulk[0]['value'] = json_encode($this->preCheckedValues ?? []);
        $models = Time::whereIn('id', $checkedTimes)->get();
        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
        ]);
        $total = CarbonInterval::create(0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($models as $model) {
            $total->add(Carbon::createFromFormat('Y-m-d H:i:s', $model->end_time)->diffAsCarbonInterval(Carbon::createFromFormat('Y-m-d H:i:s', $model->start_time)));
        }
        $this->checkedValuesTime = $total->cascade()->forHumans();
    }
}
