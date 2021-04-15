<?php

namespace App\Models\Traits\Relationship;

use App\Models\Organization;
use App\Models\Time;
use App\Models\Client;

/**
 * Class ProjectRelationship.
 */
trait ProjectRelationship
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
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * @return mixed
     */
    public function times()
    {
        return $this->hasMany(Time::class, 'project_id');
    }
}