<div class="action-buttons">
    @if (!$model->isPastDue())
        <x-utils.form-button
            :action="route('frontend.invoices.updateStatus', $model)"
            method="patch"
            name="set-status-past-due"
            button-class="btn btn-warning btn-sm"
            hiddenData="{!! ['name' => 'status', 'value' => $model::STATUS_PAST_DUE] !!}"
        >
            @lang('Mark as Past Due')
        </x-utils.form-button>
    @endif
    @if (!$model->isPaid())
        <x-utils.form-button
            :action="route('frontend.invoices.updateStatus', $model)"
            method="patch"
            name="set-status-paid"
            button-class="btn btn-warning btn-sm"
            hiddenData="{!! ['name' => 'status', 'value' => $model::STATUS_PAID] !!}"
        >
            @lang('Mark as Paid')
        </x-utils.form-button>
    @endif
    @if (!$model->isPending())
        <x-utils.form-button
            :action="route('frontend.invoices.updateStatus', $model)"
            method="patch"
            name="set-status-pending"
            button-class="btn btn-warning btn-sm"
            hiddenData="{!! ['name' => 'status', 'value' => $model::STATUS_PENDING] !!}"
        >
            @lang('Mark as Pending')
        </x-utils.form-button>
    @endif
    <x-utils.view-button :href="route('frontend.invoices.download', $model)" />
    <x-utils.edit-button :href="route('frontend.invoices.edit', $model)" />
    <x-utils.delete-button :href="route('frontend.invoices.destroy', $model)" />
</div>