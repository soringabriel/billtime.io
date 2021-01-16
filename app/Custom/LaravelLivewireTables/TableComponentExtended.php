<?php

namespace App\Custom\LaravelLivewireTables;

use Rappasoft\LaravelLivewireTables\TableComponent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;
use App\Custom\LaravelLivewireTables\Traits\Filter;

/**
 * Class TableComponentExtended.
 */
abstract class TableComponentExtended extends TableComponent
{
    use Filter;

    /**
     * @var array
     */
    public $exportCustomCells = [];

    /**
     * @var array
     */
    public $exportColumnFormats = [];

    /**
     * @var array
     */
    public $exportStyles = [];

    /**
     * @return array
     */
    public function exportCustomCells()
    {
        return $this->exportCustomCells;
    }

    /**
     * @return array
     */
    public function exportColumnFormats()
    {
        return $this->exportColumnFormats;
    }

    /**
     * @return array
     */
    public function exportStyles()
    {
        return $this->exportStyles;
    }

    /**
     * @param $type
     *
     * @return mixed
     * @throws Exception
     */
    public function export($type)
    {
        $type = strtolower($type);

        if (! in_array($type, ['csv', 'xls', 'xlsx', 'pdf'], true)) {
            throw new UnsupportedExportFormatException(__('This export type is not supported.'));
        }

        if (! in_array($type, array_map('strtolower', $this->exports), true)) {
            throw new UnsupportedExportFormatException(__('This export type is not set on this table component.'));
        }

        switch ($type) {
            case 'csv':default:
                $writer = Excel::CSV;
            break;

            case 'xls':
                $writer = Excel::XLS;
            break;

            case 'xlsx':
                $writer = Excel::XLSX;
            break;

            case 'pdf':
                $writer = Excel::DOMPDF;
                $library = strtolower(config('laravel-livewire-tables.pdf_library'));

                if (! in_array($library, ['dompdf', 'mpdf'], true)) {
                    throw new UnsupportedExportFormatException(__('This PDF export library is not supported.'));
                }

                if ($library === 'mpdf') {
                    $writer = Excel::MPDF;
                }
            break;
        }

        $class = config('laravel-livewire-tables.exports');

        return (new $class(
            $this->models(),
            $this->columns(),
            $this->exportCustomCells(),
            $this->exportColumnFormats(),
            $this->exportStyles(),
        ))->download($this->exportFileName.'.'.$type, $writer);
    }
    
    /**
     * @return Builder
     */
    public function models(): Builder
    {
        $builder = $this->query();

        if ($this->searchEnabled && trim($this->search) !== '') {
            $builder->where(function (Builder $builder) {
                foreach ($this->columns() as $column) {
                    if ($column->isSearchable()) {
                        if (is_callable($column->getSearchCallback())) {
                            $builder = app()->call($column->getSearchCallback(), ['builder' => $builder, 'term' => trim($this->search)]);
                        } elseif (Str::contains($column->getAttribute(), '.')) {
                            $relationship = $this->relationship($column->getAttribute());

                            $builder->orWhereHas($relationship->name, function (Builder $builder) use ($relationship) {
                                $builder->where($relationship->attribute, 'like', '%'.trim($this->search).'%');
                            });
                        } else {
                            $builder->orWhere($builder->getModel()->getTable().'.'.$column->getAttribute(), 'like', '%'.trim($this->search).'%');
                        }
                    }
                }
            });
        }

        if ($this->filtersEnabled && !empty($this->filters)) {
            $builder->where(function (Builder $builder) {
                $filters_keys = array_keys($this->filters);
                foreach ($this->columns() as $column) {
                    if (in_array($column->getText(), $filters_keys)) {
                        if (is_callable($column->getFilterCallback())) {
                            $builder = app()->call($column->getFilterCallback(), ['builder' => $builder, 'term' => trim($this->filters[$column->getText()])]);
                        } elseif (Str::contains($column->getAttribute(), '.')) {
                            $relationship = $this->relationship($column->getAttribute());

                            $builder->whereHas($relationship->name, function (Builder $builder) use ($relationship) {
                                $builder->where($relationship->attribute, 'like', '%'.trim($this->filters[$column->getText()]).'%');
                            });
                        } else {
                            $builder->where($builder->getModel()->getTable().'.'.$column->getAttribute(), 'like', '%'.trim($this->filters[$column->getText()]).'%');
                        }
                    }
                }
            });
        }

        if (($column = $this->getColumnByAttribute($this->sortField)) !== false && is_callable($column->getSortCallback())) {
            return app()->call($column->getSortCallback(), ['builder' => $builder, 'direction' => $this->sortDirection]);
        }

        return $builder->orderBy($this->getSortField($builder), $this->sortDirection);
    }
}