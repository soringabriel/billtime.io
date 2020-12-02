<?php

namespace App\Models\Traits\Relationship;

use App\Domains\Auth\Models\User;

/**
 * Class ProjectRelationship.
 */
trait ProjectRelationship
{
    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}