<?php

namespace App\Http\Requests\Frontend\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreProjectRequest.
 */
class StoreProjectRequest extends FormRequest
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
            'address' => [],
        ];
    }
}
