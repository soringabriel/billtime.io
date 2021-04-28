<?php

namespace App\Models\Traits\Relationship;

use App\Models\Time;
use App\Models\Project;
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
}