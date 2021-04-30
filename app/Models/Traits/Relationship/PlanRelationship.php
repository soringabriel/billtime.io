<?php

namespace App\Models\Traits\Relationship;

use App\Models\Organization;

/**
 * Class PlanRelationship.
 */
trait PlanRelationship
{
    /**
     * @return mixed
     */
    public function organizations()
    {
        return $this->hasMany(Organization::class, 'plan_id');
    }

    /**
     * @return mixed
     */
    public function organizationsNextPlan()
    {
        return $this->hasMany(Organization::class, 'next_plan_id');
    }
}