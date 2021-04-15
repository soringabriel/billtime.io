<?php

namespace App\Domains\Auth\Models\Traits\Relationship;

use App\Domains\Auth\Models\PasswordHistory;
use App\Domains\Auth\Models\User;
use App\Models\Time;
use App\Models\Organization;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * @return mixed
     */
    public function passwordHistories()
    {
        return $this->morphMany(PasswordHistory::class, 'model');
    }

    /**
     * @return mixed
     */
    public function times()
    {
        return $this->hasMany(Time::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
