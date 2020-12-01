<?php

namespace App\Domains\Auth\Models\Traits\Relationship;

use App\Domains\Auth\Models\PasswordHistory;
use App\Domains\Auth\Models\User;
use App\Models\Time;

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
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    /**
     * @return mixed
     */
    public function subUsers()
    {
        return $this->hasMany(User::class, 'parent_user_id');
    }

    /**
     * @return mixed
     */
    public function times()
    {
        return $this->hasMany(Time::class, 'user_id');
    }
}
