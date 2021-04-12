<?php

namespace App\Models\Traits\Relationship;

use App\Domains\Auth\Models\User;
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * @return mixed
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }
}