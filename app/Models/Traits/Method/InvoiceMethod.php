<?php

namespace App\Models\Traits\Method;

/**
 * Trait InvoiceMethod.
 */
trait InvoiceMethod
{
    /**
     * @return bool
     */
    public function isPastDue(): bool
    {
        return $this->status == self::STATUS_PAST_DUE;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->status == self::STATUS_PAID;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status == self::STATUS_PENDING;
    }
}
