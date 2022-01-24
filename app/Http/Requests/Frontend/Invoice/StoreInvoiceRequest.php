<?php

namespace App\Http\Requests\Frontend\Invoice;

use App\Models\Invoice;
use App\Rules\TimesInvoiceJson;
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
            'number' => ['required', 'max:50'],
            'buyer_company_name' => ['required', 'max:255'],
            'buyer_tax_number' => ['max:255'],
            'buyer_vat_number' => ['max:255'],
            'buyer_address' => [],
            'seller_company_name' => ['required', 'max:255'],
            'seller_tax_number' => ['max:255'],
            'seller_vat_number' => ['max:255'],
            'seller_address' => [],
            'seller_bank_name' => ['max:255'],
            'seller_bank_account' => ['max:255'],
            'services' => ['required', 'json'],
            'tax' => ['required', 'numeric', 'between:0,100'],
            'shipping' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'max:3'],
            'date' => ['required', 'date_format:Y-m-d'],
            'due_date' => ['nullable', 'date_format:Y-m-d'],
            'notes' => ['max:255'],
            'price' => ['required', 'numeric'],
            'times' => ['sometimes', 'nullable', 'json', new TimesInvoiceJson],
            'service_fee' => ['sometimes', 'nullable', 'numeric', 'min:0'],
        ];
    }
}
