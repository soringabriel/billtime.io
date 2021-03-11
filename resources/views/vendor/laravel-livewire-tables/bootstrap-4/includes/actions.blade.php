@if (isset($this->bulkActions) && $this->bulkActions)
    @if (isset($this->bulkDelete))
        <div x-show="selected > 0">
            <div class="row" x-show="selected > 0">
                <div class="col text-left text-muted">
                    <label>@lang('Delete Selected') (<span x-text="selected"></span>)</label>
                </div>
            </div>
            <div class="row">
                <div class="col text-left">
                    <x-utils.delete-button href="{{ route($this->bulkDelete) }}" hiddenData="{!! json_encode($this->hiddenDataBulk ?? []) !!}" />
                </div>
            </div>
        </div>
    @endif
@endif