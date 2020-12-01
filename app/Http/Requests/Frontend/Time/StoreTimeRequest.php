<?php

namespace App\Http\Requests\Frontend\Time;

use App\Models\Time;
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
            'start_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'task' => ['max:255', 'url'],
            'details' => ['required', 'max:255'],
        ];
    }
}
