<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateCompanyDetailsRequest.
 */
class UpdateCompanyDetailsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => ['max:255'],
            'tax_number' => ['max:255'],
            'vat_number' => ['max:255'],
            'address' => ['max:255'],
            'bank_account' => ['max:255'],
        ];
    }
}
