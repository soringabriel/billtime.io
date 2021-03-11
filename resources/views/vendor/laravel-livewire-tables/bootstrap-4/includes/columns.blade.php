<tr>
    @if (isset($this->bulkActions) && $this->bulkActions)
        <th>
            @lang('Select')
            <div class="bulk-select-rows">
                <input type="checkbox" id="checkRowsPage" x-ref="checkRowsPage" x-on:change="$refs.checkRowsPage.checked ? selected = {{ count($models) }} : selected = 0">
                <label for="checkRowsPage">@lang('Page')</label>
            </div>
            <div class="bulk-select-rows">
                <input type="checkbox" id="checkAllRows" x-ref="checkAllRows" x-on:change="$refs.checkAllRows.checked ? selected = {{ count($this->query()->pluck('id')->toArray()) }} : selected = 0">
                <label for="checkAllRows">@lang('All')</label>
                <input type="hidden" id="allRows" value="{{ json_encode($this->query()->pluck('id')->toArray()) }}">
            </div>
        </th>
    @endif
    @foreach($columns as $column)
        @if ($column->isVisible())
            @if($column->isSortable())
                <th
                    class="{{ $this->setTableHeadClass($column->getAttribute()) }}"
                    id="{{ $this->setTableHeadId($column->getAttribute()) }}"
                    @foreach ($this->setTableHeadAttributes($column->getAttribute()) as $key => $value)
                    {{ $key }}="{{ $value }}"
                    @endforeach
                >
                    <span
                        wire:click="sort('{{ $column->getAttribute() }}')"
                        style="cursor:pointer;"
                    >
                        {{ $column->getText() }}

                        @if ($sortField !== $column->getAttribute())
                            {{ new \Illuminate\Support\HtmlString($sortDefaultIcon) }}
                        @elseif ($sortDirection === 'asc')
                            {{ new \Illuminate\Support\HtmlString($ascSortIcon) }}
                        @else
                            {{ new \Illuminate\Support\HtmlString($descSortIcon) }}
                        @endif
                    </span>

                    @if ($column->hasFilter())
                        <input class="form-control" type="text" 
                            wire:model.debounce.{{ $filtersDebounce }}ms="filters.{{ $column->getText() }}"
                            wire:model.lazy="filters.{{ $column->getText() }}"
                            wire:loading.attr="disabled"
                        >
                    @endif
                </th>
            @else
                <th
                    class="{{ $this->setTableHeadClass($column->getAttribute()) }}"
                    id="{{ $this->setTableHeadId($column->getAttribute()) }}"
                    @foreach ($this->setTableHeadAttributes($column->getAttribute()) as $key => $value)
                        {{ $key }}="{{ $value }}"
                    @endforeach
                >
                    {{ $column->getText() }}

                    @if ($column->hasFilter())
                        <input class="form-control" type="text" 
                            wire:model.debounce.{{ $filtersDebounce }}ms="filters.{{ $column->getText() }}"
                            wire:model.lazy="filters.{{ $column->getText() }}"
                            wire:loading.attr="disabled"
                        >
                    @endif
                </th>
            @endif
        @endif
    @endforeach
</tr>
