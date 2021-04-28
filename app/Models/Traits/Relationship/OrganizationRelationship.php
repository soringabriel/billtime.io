<?php

namespace App\Models\Traits\Relationship;

use App\Domains\Auth\Models\User;
use App\Models\Project;
use App\Models\Client;
use App\Models\Time;

/**
 * Class OrganizationRelationship.
 */
trait OrganizationRelationship
{
    /**
     * @return mixed
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany(User::class, 'organization_id');
    }

    /**
     * @return mixed
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'organization_id');
    }

    /**
     * @return mixed
     */
    public function clients()
    {
        return $this->hasMany(Client::class, 'organization_id');
    }

    /**
     * @return mixed
     */
    public function times()
    {
        return $this->hasManyThrough(Time::class, User::class, 'organization_id', 'user_id', 'id', 'id');
    }
}