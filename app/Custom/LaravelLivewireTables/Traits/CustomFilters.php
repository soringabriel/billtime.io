<?php

namespace App\Custom\LaravelLivewireTables\Traits;

/**
 * Trait CustomFilters.
 */
trait CustomFilters
{
    /**
     * The initial CustomFilters string.
     *
     * @var string
     */
    public $customFilters = [];

    /**
     * Method to CustomFilters by: debounce or lazy.
     * @var string
     */
    public $customFiltersUpdateMethod = 'debounce';

    /**
     * Whether or not CustomFiltersing is enabled.
     *
     * @var bool
     */
    public $customFiltersEnabled = false;

    /**
     * false = disabled
     * int = Amount of time in ms to wait to send the CustomFilters query and refresh the table.
     *
     * @var int
     */
    public $customFiltersDebounce = 500;
}
