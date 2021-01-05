<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class RolesTable.
 */
class RolesTable extends TableComponentExtended
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
        return Role::with('permissions:id,name,description')
            ->withCount('users');
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ColumnExtended::make(__('Type'), 'type')
                ->sortable()
                ->format(function (Role $model) {
                    if ($model->type === User::TYPE_ADMIN) {
                        return __('Administrator');
                    }

                    if ($model->type === User::TYPE_USER) {
                        return __('User');
                    }

                    return 'N/A';
                }),
            ColumnExtended::make(__('Name'), 'name')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Permissions'), 'permissions_label')
                ->searchable(function ($builder, $term) {
                    return $builder->orWhereHas('permissions', function ($query) use ($term) {
                        return $query->where('name', 'like', '%'.$term.'%');
                    });
                })
                ->format(function (Role $model) {
                    return $this->html($model->permissions_label);
                }),
            ColumnExtended::make(__('Number of Users'), 'users_count')
                ->sortable(),
            ColumnExtended::make(__('Actions'))
                ->format(function (Role $model) {
                    return view('backend.auth.role.includes.actions', ['model' => $model]);
                }),
        ];
    }
}
