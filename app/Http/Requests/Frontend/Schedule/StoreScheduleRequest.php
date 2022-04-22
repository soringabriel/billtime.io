<?php

namespace App\Http\Requests\Frontend\Schedule;

use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreScheduleRequest.
 */
class StoreScheduleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => ['required', Rule::exists('projects', 'id')->where('organization_id', auth()->user()->organization()->first()->id)],
            'schedule_trigger' => ['required', 'max:31', 'min:1'],
            'price_per_hour' => ['required', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['required', 'numeric', 'between:0,100'],
            'shipping' => ['nullable', 'numeric', 'min:0'],
            'service_fee' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'notes' => ['max:255'],
        ];
    }
}
