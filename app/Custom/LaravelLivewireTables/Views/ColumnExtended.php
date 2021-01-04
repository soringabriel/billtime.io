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
     * @var
     */
    protected $totalableCallback;

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
}
