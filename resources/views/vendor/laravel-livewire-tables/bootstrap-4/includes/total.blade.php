@if ($total)
    <div class="row">
        <div class="col">
            {{ $models->links() }}
        </div>

        <div class="col text-right text-muted total-time">
            @lang('Total Time') {{ $this->totalTime() }}
        </div>
    </div>
@endif