<?php

namespace App\Custom\LaravelLivewireTables\Traits;

/**
 * Trait Filter.
 */
trait Filter
{
    /**
     * The initial filter string.
     *
     * @var string
     */
    public $filters = [];

    /**
     * Method to filter by: debounce or lazy.
     * @var string
     */
    public $filtersUpdateMethod = 'debounce';

    /**
     * Whether or not filtering is enabled.
     *
     * @var bool
     */
    public $filtersEnabled = false;

    /**
     * false = disabled
     * int = Amount of time in ms to wait to send the filter query and refresh the table.
     *
     * @var int
     */
    public $filtersDebounce = 1000;
}
