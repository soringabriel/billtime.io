<?php

namespace App\Models\Traits\Relationship;

use App\Models\Project;
use App\Models\Invoice;
use App\Domains\Auth\Models\User;

/**
 * Class ScheduleRelationship.
 */
trait ScheduleRelationship
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
    public function organization()
    {
        return $this->user()->first()->organization();
    }

    /**
     * @return mixed
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * @return mixed
     */
    public function invoices()
    {
        return Invoice::where('schedule_id', $this->id);
    }
}