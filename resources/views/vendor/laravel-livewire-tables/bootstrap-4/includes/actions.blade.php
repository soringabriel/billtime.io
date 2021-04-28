@if (isset($this->bulk) && $this->bulk)
    <input type="hidden" name="times" class="bulk-checkbox-values" value="{{ json_encode($this->preCheckedValues ?? []) }}">
    <div x-show="selected > 0">
        <div class="row" x-show="selected > 0">
            <div class="col text-left text-muted">
                <label>@lang('Selected') (<span x-text="selected"></span>)</label>
            </div>
        </div>
        @if (isset($this->bulkActions) && $this->bulkActions)
            <div class="row">
                <div class="col text-left">
                    <x-utils.form-button
                        :action="route($this->bulkBill['route'])"
                        method="post"
                        button-class="btn btn-primary btn-sm"
                        icon="fas fa-sync-alt"
                        name="confirm-item"
                        data-toggle="tooltip" 
                        data-placement="right"
                        title="{{ __('If a time is billed it will become unbilled. Otherwise it will be marked as billed.') }}"
                        hiddenData="{!! json_encode($this->hiddenDataBulk ?? []) !!}"
                        :permission="$this->bulkBill['permission']"
                    >
                        @lang('Toggle billed')
                    </x-utils.form-button>
                    <x-utils.delete-button href="{{ route($this->bulkDelete['route']) }}" hiddenData="{!! json_encode($this->hiddenDataBulk ?? []) !!}" :permission="$this->bulkDelete['permission']" />
                </div>
            </div>
        @endif
    </div>
@endif