<?php

namespace App\Http\Requests\Frontend\Time;

use App\Models\Time;
use App\Models\TimeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreTimeRequest.
 */
class StoreTimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start' => ['required', 'date_format:Y-m-d h:i:s'],
            'end' => ['required', 'date_format:Y-m-d h:i:s'],
            'task' => ['max:255'],
            'details' => ['required', 'max:255'],
        ];
    }
}
