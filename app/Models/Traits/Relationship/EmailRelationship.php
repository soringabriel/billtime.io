<?php

namespace App\Models\Traits\Relationship;

use App\Models\Invoice;

/**
 * Class EmailRelationship.
 */
trait EmailRelationship
{
    /**
     * @return mixed
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}