<?php

namespace App\Models\Traits\Method;

use App\Models\Client;
use Illuminate\Support\HtmlString;

/**
 * Trait ClientMethod.
 */
trait ClientMethod
{
    /**
     * @return array
     */
    public function apiProperties(): array
    {
        return [
            "id" => $this->id,
            "organization_id" => $this->organization_id,
            "name" => $this->name,
            "company_name"=> $this->company_name,
            "tax_number"=> $this->tax_number,
            "vat_number"=> $this->vat_number,
            "address"=> $this->address,
            "bank_account"=> $this->bank_account,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
        ];
    }
}
