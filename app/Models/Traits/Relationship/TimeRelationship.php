<?php

namespace App\Models\Traits\Relationship;

use App\Models\Tag;

/**
 * Class PlanRelationship.
 */
trait TimeRelationship
{
    /**
     * @return mixed
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'time_has_tags');
    }
}