<?php

namespace App\Custom\LaravelLivewireTables\Views;

use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class ColumnExtended.
 */
class ColumnExtended extends Column
{
    /**
     * @var bool
     */
    protected $totalable = false;

    /**
     * @var bool
     */
    protected $hasFilter = false;

    /**
     * @var bool
     */
    protected $hasFilterHTML = false;

    /**
     * @var
     */
    protected $totalableCallback;

    /**
     * @var null
     */
    protected $filterCallback;

    /**
     * @var
     */
    protected $filterHTMLCallback;

    /**
     * @return bool
     */
    public function hasFilter(): bool
    {
        return $this->hasFilter === true;
    }

    /**
     * @return bool
     */
    public function hasFilterHTML(): bool
    {
        return $this->hasFilterHTML === true;
    }

    /**
     * @param  callable|null  $callable
     *
     * @return $this
     */
    public function withFilter(callable $callable = null): self
    {
        $this->filterCallback = $callable;
        $this->hasFilter = true;

        return $this;
    }

    /**
     * @param  callable|null  $callable
     *
     * @return $this
     */
    public function filterHTML(callable $callable = null): self
    {
        $this->filterHTMLCallback = $callable;
        $this->hasFilterHTML = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTotalable(): bool
    {
        return $this->totalable === true;
    }

    /**
     * @param $model
     * @param $column
     *
     * @return mixed
     */
    public function totalFormatted($column)
    {
        return app()->call($this->totalableCallback, ['column' => $column]);
    }

    /**
     * @param  callable|null  $callable
     *
     * @return $this
     */
    public function totalable(callable $callable = null): self
    {
        $this->totalableCallback = $callable;
        $this->totalable = true;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getFilterCallback()
    {
        return $this->filterCallback;
    }

    /**
     * @return mixed
     */
    public function filterHTMLCallback()
    {
        return app()->call($this->filterHTMLCallback, ['column' => $this]);
    }
}
