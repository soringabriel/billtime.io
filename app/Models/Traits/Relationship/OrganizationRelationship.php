<?php

namespace App\Models\Traits\Relationship;

use App\Domains\Auth\Models\User;
use App\Models\Project;
use App\Models\Client;
use App\Models\Time;
use App\Models\Plan;
use App\Models\Invoice;
use App\Models\Schedule;

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
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * @return mixed
     */
    public function nextPlan()
    {
        return $this->belongsTo(Plan::class, 'next_plan_id');
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

    /**
     * @return mixed
     */
    public function invoices()
    {
        return Invoice::whereIn('user_id', $this->users()->pluck('id')->toArray());
    }

    /**
     * @return mixed
     */
    public function schedules()
    {
        return Schedule::whereIn('user_id', $this->users()->pluck('id')->toArray());
    }
}