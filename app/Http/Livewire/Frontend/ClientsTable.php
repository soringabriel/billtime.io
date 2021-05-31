<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class ClientsTable.
 */
class ClientsTable extends TableComponentExtended
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
     * @var array
     */
    public $emptyTableAction = [
        'route' => 'frontend.clients.create',
        'text' => 'Add Your First Client',
    ];

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Client::query()->where('organization_id', auth()->user()->organization()->first()->id);
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
            ColumnExtended::make(__('Company Name'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Tax Number'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Vat Number'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Address'))
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Actions'))
                ->format(function (Client $model) {
                    return view('frontend.clients.includes.actions', ['model' => $model]);
                }),
        ];
    }
}