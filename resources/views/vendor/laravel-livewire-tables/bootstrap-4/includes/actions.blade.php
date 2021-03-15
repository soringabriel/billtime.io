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
                    <x-utils.form-button
                        :action="route('frontend.time.bulkToggleBilled', [])"
                        method="patch"
                        button-class="btn btn-primary btn-sm"
                        icon="fas fa-sync-alt"
                        name="confirm-item"
                        data-toggle="tooltip" 
                        data-placement="right" 
                        title="{{ __('If a time is billed it will become unbilled. Otherwise it will be marked as billed.') }}"
                    >
                        @lang('Toggle billed')
                    </x-utils.form-button>
                    <x-utils.delete-button href="{{ route($this->bulkDelete) }}" hiddenData="{!! json_encode($this->hiddenDataBulk ?? []) !!}" />
                </div>
            </div>
        </div>
    @endif
@endif