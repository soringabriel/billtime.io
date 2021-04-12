<?php

namespace App\Models\Traits\Relationship;

use App\Models\Tag;
use App\Models\Project;
use App\Models\Invoice;
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
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * @return mixed
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'time_has_tags');
    }
    
    /**
     * @return mixed
     */
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_has_times');
    }
}