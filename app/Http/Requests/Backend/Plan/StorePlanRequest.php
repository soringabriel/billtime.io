<?php

namespace App\Http\Requests\Backend\Plan;

use App\Models\Plan;
use App\Models\PlanService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StorePlanRequest.
 */
class StorePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:100', Rule::unique('plans')],
            'price' => ['required', 'max:100', 'min:0'],
            'currency' => ['required', 'max:3'],
            'billing_type' => ['required', Rule::in(Plan::BILLING_TYPES)],
            'subusers_quota' => ['required', 'integer'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => [Rule::exists('permissions', 'id')->where('type', $this->type)],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'permissions.*.exists' => __('One or more permissions were not found or are not allowed to be associated with this user type.'),
        ];
    }
}
