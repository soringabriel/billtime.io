@if (count($exports))
    <div class="table-export">
        @if (in_array('csv', $exports, true))
            <a class="btn btn-outline-success p-0 m-1" href="#" title="CSV" wire:click.prevent="export('csv')"><i class="fas fa-file-csv m-2"></i></a>
        @endif

        @if (in_array('xls', $exports, true))
            <a class="btn btn-outline-success p-0 m-1" href="#" title="XLS" wire:click.prevent="export('xls')"><i class="fas fa-file-excel m-2"></i></a>
        @endif

        @if (in_array('xlsx', $exports, true))
            <a class="btn btn-outline-success p-0 m-1" href="#" title="XLSX" wire:click.prevent="export('xlsx')"><i class="far fa-file-excel m-2"></i></a>
        @endif

        @if (in_array('pdf', $exports, true))
            <a class="btn btn-outline-danger p-0 m-1" href="#" title="PDF" wire:click.prevent="export('pdf')"><i class="fas fa-file-pdf m-2"></i></a>
        @endif
    </div>
@endif
