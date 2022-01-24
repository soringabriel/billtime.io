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

    /**
     * @return array
     */
    public function apiProperties(): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "number" => $this->number,
            "buyer_company_name"=> $this->buyer_company_name,
            "buyer_tax_number" => $this->buyer_tax_number,
            "buyer_vat_number" => $this->buyer_vat_number,
            "buyer_address" => $this->buyer_address,
            "seller_company_name"=> $this->seller_company_name,
            "seller_tax_number" => $this->seller_tax_number,
            "seller_vat_number" => $this->seller_vat_number,
            "seller_address" => $this->seller_address,
            "seller_bank_name" => $this->seller_bank_name,
            "seller_bank_account" => $this->seller_bank_account,
            "services" => $this->services,
            "tax" => $this->tax,
            "shipping" => $this->shipping,
            "currency" => $this->currency,
            "price" => $this->price,
            "date" => $this->date,
            "due_date" => $this->due_date,
            "notes" => $this->notes,
            "status" => $this->status,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
