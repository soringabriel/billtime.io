@if (isset($this->bulk) && $this->bulk)
    <input type="hidden" name="times" wire:change="setCheckedValuesTime($event.target.value)" class="bulk-checkbox-values" value="{{ json_encode($this->preCheckedValues ?? []) }}">
    <input type="hidden" id="checkedTimesValues" value="{{ isset($this->checkedValuesTime) ? $this->checkedValuesTime : 0 }}">
    <div x-show="selected > 0">
        <div class="row" x-show="selected > 0">
            <div class="col text-left text-muted mb-3">
                <label>@lang('Selected') (<span x-text="selected"></span>)</label>
                <button id="uncheckAllRows" class="btn btn-primary" type="button" x-show="selected > 0" x-on:click="selected = 0">Unselect all</button>
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