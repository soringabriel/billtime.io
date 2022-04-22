<?php

namespace App\Models\Traits\Relationship;

use App\Models\Time;
use App\Models\Project;
use App\Models\Email;
use App\Models\Schedule;
use App\Domains\Auth\Models\User;

/**
 * Class PlanRelationship.
 */
trait InvoiceRelationship
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
    public function times()
    {
        return $this->belongsToMany(Time::class, 'invoice_has_times');
    }

    /**
     * @return mixed
     */
    public function organization()
    {
        return $this->user()->first()->organization();
    }

    /**
     * @return mixed
     */
    public function emails()
    {
        return $this->hasMany(Email::class, 'invoice_id');
    }

    /**
     * @return mixed
     */
    public function schedule()
    {
        if ($this->schedule_id) {
            return Schedule::find($this->schedule_id);
        }
        return null;
    }
}