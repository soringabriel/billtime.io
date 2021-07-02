<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Auth\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class ErrorActivitiesTable.
 */
class ErrorActivitiesTable extends TableComponentExtended
{
    use HtmlComponents;

    /**
     * @var string
     */
    public $sortField = 'created_at';

    /**
     * @var string
     */
    public $sortDirection = 'desc';

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
        return Activity::where('log_name', 'exception');
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ColumnExtended::make(__('Causer'), 'causer_id')
                ->format(function (Activity $model) {
                    if (is_null($model->causer_id)) {
                        return __('Unknown');
                    }
                    $user = User::find($model->causer_id);
                    return $this->html('<a href="' . route('admin.auth.user.show', $user) . '" target="_blank">' . $user->name . '</a>');
                }),
            ColumnExtended::make(__('Message'), 'description')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Info'), 'properties')
                ->format(function (Activity $model) {
                    return $this->html('<pre>' . json_encode(json_decode($model->properties), JSON_PRETTY_PRINT) . '</pre>');
                }),
            ColumnExtended::make(__('Created At'), 'created_at')
                ->searchable()
                ->sortable(),
        ];
    }
}
