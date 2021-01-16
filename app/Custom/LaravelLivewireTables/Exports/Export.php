<?php

namespace App\Custom\LaravelLivewireTables\Exports;

use Illuminate\Database\Eloquent\Builder;
use App\Exports\Concerns\WithCustomCells;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Rappasoft\LaravelLivewireTables\Traits\ExportHelper;

/**
 * Class CSVExport.
 */
class Export implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting, WithStyles, WithCustomCells
{
    use Exportable, ExportHelper;

    /**
     * @var array
     */
    public $builder;

    /**
     * @var array
     */
    public $columns;

    /**
     * @var array
     */
    public $customCells;

    /**
     * @var array
     */
    public $columnFormats;

    /**
     * @var array
     */
    public $styles;

    /**
     * CSVExport constructor.
     *
     * @param  Builder  $builder
     * @param  array  $columns
     * @param  array  $customCells
     * @param  array  $columnFormats
     * @param  array  $styles
     */
    public function __construct(Builder $builder, array $columns = [], array $customCells = [], array $columnFormats = [], array $styles = [])
    {
        $this->builder = $builder;
        $this->columns = $columns;
        $this->customCells = $customCells;
        $this->columnFormats = $columnFormats;
        $this->styles = $styles;
    }

    /**
     * @return array|\Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return $this->builder;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->getHeadingRow();
    }

    /**
     * @param  mixed  $row
     *
     * @return array
     */
    public function map($row): array
    {
        $map = [];

        foreach ($this->columns as $column) {
            if ($column->isExportOnly() || ($column->isVisible() && $column->includedInExport())) {
                if ($column->isFormatted()) {
                    if ($column->hasExportFormat()) {
                        $map[] = $column->formattedForExport($row, $column);
                    } else {
                        $map[] = strip_tags($column->formatted($row, $column));
                    }
                } else {
                    $map[] = data_get($row, $column->getAttribute());
                }
            }
        }

        return $map;
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return $this->columnFormats;
    }

    /**
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        return $this->styles;
    }

    /**
     * @return array
     */
    public function customCells(): array
    {
        return $this->customCells;
    }
}
