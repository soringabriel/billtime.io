@foreach($columns as $column)
    @if ($column->isTotalable())
        <div class="row">
            <div class="col text-right text-muted total-time">
                @lang('Total') {{ $column->getText() }} {{ $column->totalFormatted($column) }}
            </div>
        </div>
        <div class="row">
            <div class="col text-right text-muted">
                @lang('laravel-livewire-tables::strings.results', [
                    'first' => $models->count() ? $models->firstItem() : 0,
                    'last' => $models->count() ? $models->lastItem() : 0,
                    'total' => $models->total()
                ])
            </div>
        </div>
    @endif
@endforeach