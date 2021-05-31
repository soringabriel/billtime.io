@if (isset($this->emptyTableAction))
    <tr>
        <td colspan="{{ collect($columns)->count() }}" class="text-center">
            <x-utils.link
                class="m-3 btn btn-lg btn-primary"
                :href="route($this->emptyTableAction['route'])"
                :text="$this->emptyTableAction['text']"
            />
        </td>
    </tr>
@else
    <tr>
        <td colspan="{{ collect($columns)->count() }}">@lang('laravel-livewire-tables::strings.no_results')</td>
    </tr>
@endif