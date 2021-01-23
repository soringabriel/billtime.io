<?php

namespace App\Http\Requests\Frontend\Invoice;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreInvoiceRequest.
 */
class StoreInvoiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number' => ['required', 'max:6'],
            'buyer_company_name' => ['required', 'max:255'],
            'buyer_tax_number' => ['max:255'],
            'buyer_vat_number' => ['max:255'],
            'buyer_address' => [],
            'seller_company_name' => ['required', 'max:255'],
            'seller_tax_number' => ['max:255'],
            'seller_vat_number' => ['max:255'],
            'seller_address' => [],
            'services' => ['required', 'json'],
            'tax' => ['required', 'integer', 'between:0,100'],
            'currency' => ['required', 'max:3'],
            'date' => ['required', 'date_format:Y-m-d'],
            'due_date' => ['required', 'date_format:Y-m-d'],
            'notes' => ['max:255'],
        ];
    }
}
