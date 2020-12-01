<?php

namespace App\Models\Traits\Relationship;

use App\Models\Tag;
use App\Domains\Auth\Models\User;

/**
 * Class PlanRelationship.
 */
trait TimeRelationship
{
    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'time_has_tags');
    }
}