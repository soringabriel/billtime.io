<?php

namespace App\Http\Requests\Frontend\Project;

use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateProjectRequest.
 */
class UpdateProjectRequest extends FormRequest
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
            'client_id' => ['required_if:new_client,0', Rule::exists('clients', 'id')->where(function ($query) {
                return $query->where('organization_id', auth()->user()->organization()->first()->id);
            })],
            'new_client' => ['sometimes', 'boolean'],
            'client_name' => ['required_if:new_client,1', 'max:255'],
            'client_company_name' => ['max:255'],
            'client_tax_number' => ['max:255'],
            'client_vat_number' => ['max:255'],
            'client_address' => ['max:255'],
            'client_bank_account' => ['max:255'],
        ];
    }
}
