<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateOrganizationDetailsRequest.
 */
class UpdateOrganizationDetailsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => ['nullable', 'max:255'],
            'tax_number' => ['nullable', 'max:255'],
            'vat_number' => ['nullable', 'max:255'],
            'address' => ['nullable', 'max:255'],
            'bank_name' => ['nullable', 'max:255'],
            'bank_account' => ['nullable', 'max:255'],
        ];
    }
}
