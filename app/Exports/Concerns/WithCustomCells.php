<?php

namespace App\Exports\Concerns;

interface WithCustomCells
{
    /**
     *
     * @return array
     */
    public function customCells(): array;
}