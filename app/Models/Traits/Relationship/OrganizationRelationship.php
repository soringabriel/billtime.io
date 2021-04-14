<?php

namespace App\Models\Traits\Relationship;

use App\Domains\Auth\Models\User;

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
}