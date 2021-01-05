@if (isset($this->bulkActions) && $this->bulkActions)
    @if (isset($this->bulkDelete))
        <div class="row">
            <div class="col text-left">
                <label>@lang('Delete Selected')</label>
                <x-utils.delete-button :href="#" :hiddenData="{{ $this->hiddenDataDelete ?? '[]' }}" />
            </div>
        </div>
    @endif
@endif