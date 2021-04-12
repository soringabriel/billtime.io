<?php

namespace App\Models\Traits\Relationship;

use App\Domains\Auth\Models\User;
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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