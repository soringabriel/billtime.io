<?php

namespace App\Models\Traits\Scope;

use App\Models\Plan;

/**
 * Class PlanScope.
 */
trait PlanScope
{
    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeDefault($query)
    {
        return $query->where('id', env('DEFAULT_PLAN'));
    }
}