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
}