<?php

namespace App\Models\Traits\Relationship;

use App\Models\Time;

/**
 * Class PlanRelationship.
 */
trait TagRelationship
{
    /**
     * @return mixed
     */
    public function times()
    {
        return $this->belongsToMany(Time::class, 'time_has_tags');
    }
}