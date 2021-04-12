<?php

namespace App\Http\Requests\Frontend\Client;

use App\Models\Client;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateClientRequest.
 */
class UpdateClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'company_name' => ['max:255'],
            'tax_number' => ['max:255'],
            'vat_number' => ['max:255'],
            'address' => ['max:255'],
            'bank_account' => ['max:255'],
        ];
    }
}
