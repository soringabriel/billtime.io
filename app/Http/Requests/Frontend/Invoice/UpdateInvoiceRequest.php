<?php

namespace App\Http\Requests\Frontend\Invoice;

use App\Models\Invoice;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateInvoiceRequest.
 */
class UpdateInvoiceRequest extends FormRequest
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
            'seller_bank_name' => ['max:255'],
            'seller_bank_account' => ['required'],
            'services' => ['required', 'json'],
            'tax' => ['required', 'integer', 'between:0,100'],
            'shipping' => ['required', 'min:0'],
            'currency' => ['required', 'max:3'],
            'date' => ['required', 'date_format:Y-m-d'],
            'due_date' => ['required', 'date_format:Y-m-d'],
            'notes' => ['max:255'],
            'price' => ['numeric'],
            'times' => ['required', 'array'],
        ];
    }
}
