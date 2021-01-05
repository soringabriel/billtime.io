<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class UsersTable.
 */
class UsersTable extends TableComponentExtended
{
    use HtmlComponents;

    /**
     * @var string
     */
    public $sortField = 'name';

    /**
     * @var string
     */
    public $status;

    /**
     * @var array
     */
    protected $options = [
        'bootstrap.container' => false,
        'bootstrap.classes.table' => 'table table-striped',
    ];

    /**
     * @param  string  $status
     */
    public function mount($status = 'active'): void
    {
        $this->status = $status;
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $query = User::with('roles', 'twoFactorAuth')
            ->withCount('twoFactorAuth');

        if ($this->status === 'deleted') {
            return $query->onlyTrashed();
        }

        if ($this->status === 'deactivated') {
            return $query->onlyDeactivated();
        }

        return $query->onlyActive();
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ColumnExtended::make(__('Type'), 'type')
                ->sortable()
                ->format(function (User $model) {
                    return view('backend.auth.user.includes.type', ['user' => $model]);
                }),
            ColumnExtended::make(__('Name'), 'name')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('E-mail'), 'email')
                ->searchable()
                ->sortable()
                ->format(function (User $model) {
                    return $this->mailto($model->email);
                }),
            ColumnExtended::make(__('Verified'), 'email_verified_at')
                ->sortable()
                ->format(function (User $model) {
                    return view('backend.auth.user.includes.verified', ['user' => $model]);
                }),
            ColumnExtended::make(__('2FA'))
                ->sortable(function ($builder, $direction) {
                    return $builder->orderBy('two_factor_auth_count', $direction);
                })
                ->format(function (User $model) {
                    return view('backend.auth.user.includes.2fa', ['user' => $model]);
                }),
            ColumnExtended::make(__('Roles'), 'roles_label')
                ->searchable(function ($builder, $term) {
                    return $builder->orWhereHas('roles', function ($query) use ($term) {
                        return $query->where('name', 'like', '%'.$term.'%');
                    });
                })
                ->format(function (User $model) {
                    return $this->html($model->roles_label);
                }),
            ColumnExtended::make(__('Additional Permissions'), 'permissions_label')
                ->searchable(function ($builder, $term) {
                    return $builder->orWhereHas('permissions', function ($query) use ($term) {
                        return $query->where('name', 'like', '%'.$term.'%');
                    });
                })
                ->format(function (User $model) {
                    return $this->html($model->permissions_label);
                }),
            ColumnExtended::make(__('Actions'))
                ->format(function (User $model) {
                    return view('backend.auth.user.includes.actions', ['user' => $model]);
                }),
        ];
    }
}
