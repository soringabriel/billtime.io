<div class="action-buttons">
    @if ($model->user()->first()->id == $logged_in_user->id)
        @if (!$model->isPastDue())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-past-due"
                button-class="btn btn-danger btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PAST_DUE]]) !!}"
            >
                @lang('Mark as Past Due')
            </x-utils.form-button>
        @endif
        @if (!$model->isPaid())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-paid"
                button-class="btn btn-success btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PAID]]) !!}"
            >
                @lang('Mark as Paid')
            </x-utils.form-button>
        @endif
        @if (!$model->isPending())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-pending"
                button-class="btn btn-dark btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PENDING]]) !!}"
            >
                @lang('Mark as Pending')
            </x-utils.form-button>
        @endif
        <x-utils.link :href="route('frontend.invoices.download', $model)" class="btn btn-info btn-sm" icon="fas fa-download" :text="__('Download')" />
        <x-utils.edit-button :href="route('frontend.invoices.edit', $model)" />
        <x-utils.delete-button :href="route('frontend.invoices.destroy', $model)" />
    @else
        @if (!$model->isPastDue())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-past-due"
                button-class="btn btn-danger btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PAST_DUE]]) !!}"
                permission="user.access.invoices.update-status-all"
            >
                @lang('Mark as Past Due')
            </x-utils.form-button>
        @endif
        @if (!$model->isPaid())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-paid"
                button-class="btn btn-success btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PAID]]) !!}"
                permission="user.access.invoices.update-status-all"
            >
                @lang('Mark as Paid')
            </x-utils.form-button>
        @endif
        @if (!$model->isPending())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-pending"
                button-class="btn btn-dark btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PENDING]]) !!}"
                permission="user.access.invoices.update-status-all"
            >
                @lang('Mark as Pending')
            </x-utils.form-button>
        @endif
        <x-utils.link :href="route('frontend.invoices.download', $model)" class="btn btn-info btn-sm" icon="fas fa-download" :text="__('Download')" permission="user.access.invoices.show-all" />
        <x-utils.edit-button :href="route('frontend.invoices.edit', $model)" permission="user.access.invoices.edit-all" />
        <x-utils.delete-button :href="route('frontend.invoices.destroy', $model)" permission="user.access.invoices.delete-all" />
    @endif
</div>