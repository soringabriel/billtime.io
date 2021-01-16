@foreach($columns as $column)
    @if ($column->isTotalable())
        <div class="row">
            <div class="col text-right text-muted total-time">
                @lang('Total') {{ $column->getText() }} {{ $column->totalFormatted($column) }}
            </div>
        </div>
    @endif
@endforeach