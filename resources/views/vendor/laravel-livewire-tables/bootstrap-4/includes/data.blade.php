@foreach($models as $model)
    <tr
        class="{{ $this->setTableRowClass($model) }}"
        id="{{ $this->setTableRowId($model) }}"
        @foreach ($this->setTableRowAttributes($model) as $key => $value)
        {{ $key }}="{{ $value }}"
        @endforeach
        @if ($this->getTableRowUrl($model))
            onclick="window.location='{{ $this->getTableRowUrl($model) }}';"
            style="cursor:pointer"
        @endif
    >
        @if (isset($this->bulk) && $this->bulk)
            <td>
                <input 
                    type="checkbox" 
                    id="checkRow{{ $model->id }}" 
                    x-ref="checkRow{{ $model->id }}" 
                    class="bulk-checkbox" 
                    value="{{ $model->id }}" 
                    x-on:change="$refs.checkRow{{ $model->id }}.checked ? selected++ : selected--"
                    {{ in_array($model->id, $this->preCheckedValues) ? 'checked' : '' }}
                    />
            </td>
        @endif

        @foreach($columns as $column)
            @if ($column->isVisible())
                <td
                    class="{{ $this->setTableDataClass($column->getAttribute(), data_get($model, $column->getAttribute())) }}"
                    id="{{ $this->setTableDataId($column->getAttribute(), data_get($model, $column->getAttribute())) }}"
                    @foreach ($this->setTableDataAttributes($column->getAttribute(), data_get($model, $column->getAttribute())) as $key => $value)
                    {{ $key }}="{{ $value }}"
                    @endforeach
                >
                    @if ($column->isFormatted())
                        @if ($column->isRaw())
                            {!! $column->formatted($model, $column) !!}
                        @else
                            {{ $column->formatted($model, $column) }}
                        @endif
                    @else
                        @if ($column->isRaw())
                            <label for="checkRow{{ $model->id }}">{!! data_get($model, $column->getAttribute()) !!}</label>
                        @else
                        <label for="checkRow{{ $model->id }}">{{ data_get($model, $column->getAttribute()) }}</label>
                        @endif
                    @endif
                </td>
            @endif
        @endforeach
    </tr>
@endforeach
