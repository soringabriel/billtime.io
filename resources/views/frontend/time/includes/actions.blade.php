@if ($model->user()->first()->id == $logged_in_user->id)
    <div class="action-buttons">
        @if ($model->billed)
            <x-utils.form-button
                :action="route('frontend.time.toggleBilled', $model)"
                method="patch"
                button-class="btn btn-warning btn-sm"
                icon="fas fa-sync-alt"
                name="confirm-item"
            >
                @lang('Mark as not billed')
            </x-utils.form-button>
        @else 
            <x-utils.form-button
                :action="route('frontend.time.toggleBilled', $model)"
                method="patch"
                button-class="btn btn-success btn-sm"
                icon="fas fa-sync-alt"
                name="confirm-item"
            >
                @lang('Mark as billed')
            </x-utils.form-button>
        @endif
        <x-utils.edit-button :href="route('frontend.time.edit', $model)" />
        <x-utils.delete-button :href="route('frontend.time.destroy', $model)" />
    </div>
@endif