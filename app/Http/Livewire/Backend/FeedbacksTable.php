<?php

namespace App\Http\Livewire\Backend;

use Mydnic\Kustomer\Feedback;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Custom\LaravelLivewireTables\TableComponentExtended;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use App\Custom\LaravelLivewireTables\Views\ColumnExtended;

/**
 * Class FeedbacksTable.
 */
class FeedbacksTable extends TableComponentExtended
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
     * @return Builder
     */
    public function query(): Builder
    {
        return Feedback::query();
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            ColumnExtended::make(__('Type'), 'type')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('Message'), 'message')
                ->searchable()
                ->sortable(),
            ColumnExtended::make(__('User Info'), 'user_info')
                ->format(function (Feedback $model) {
                    $user = User::find($model->user_info['user_id']);
                    $html = '<ul><li>' . __('User') . ' <a href="' . route('admin.auth.user.show', $user) . '">' . $user->email . '</a></li>';
                    $html .= '<li>' . __('URL') . ' <a href="' . $model->user_info['url'] . '">' . $model->user_info['url'] . '</a></li>';
                    $html .= '<li>' . __('Viewport') . ' ' . json_encode($model->user_info['viewport']) . '</li>';
                    $html .= '<li>' . __('Agent') . ' ' . $model->user_info['agent'] . '</li>';
                    $html .= '</ul>';                    
                    return $this->html($html);
                }),
            ColumnExtended::make(__('Created At'), 'created_at')
                ->searchable()
                ->sortable(),
        ];
    }
}
