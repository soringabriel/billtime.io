<?php

namespace App\Domains\Auth\Models\Traits\Relationship;

use App\Domains\Auth\Models\PasswordHistory;
use App\Domains\Auth\Models\User;
use App\Models\Time;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Project;
use App\Models\Schedule;
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
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }

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
    public function clients()
    {
        return $this->hasManyThrough(Client::class, Organization::class, 'owner_id', 'organization_id', 'id', 'id');
    }

    /**
     * @return mixed
     */
    public function projects()
    {
        return $this->hasManyThrough(Project::class, Organization::class, 'owner_id', 'organization_id', 'id', 'id');
    }

    /**
     * @return mixed
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function plan()
    {
        $organization = $this->organization()->first();
        return is_null($organization) ? null : $organization->plan();
    }
    
    /**
     * @return mixed
     */
    public function nextPlan()
    {
        $organization = $this->organization()->first();
        return is_null($organization) ? null : $organization->nextPlan();
    }
}
