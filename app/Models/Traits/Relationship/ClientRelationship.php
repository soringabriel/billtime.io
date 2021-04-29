<?php

namespace App\Models\Traits\Relationship;

use App\Models\Organization;
use App\Models\Time;
use App\Models\Project;

/**
 * Class ClientRelationship.
 */
trait ClientRelationship
{
    /**
     * @return mixed
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
    
    /**
     * @return mixed
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }
}