<?php

namespace App\Http\Requests\Frontend\Time;

use App\Models\Time;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

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
            'start_time' => [
                'required', 
                'date_format:Y-m-d H:i', 
                'before:' . Carbon::now()->timezone(auth()->user()->timezone), 
                'before:' . FormRequest::input('end_time'), 
                (!empty(FormRequest::input('end_time')) ? 'after:' . Carbon::createFromFormat('Y-m-d H:i', FormRequest::input('end_time'))->subDay() : '')
            ],
            'end_time' => ['required', 'date_format:Y-m-d H:i', 'before:' . Carbon::now()->timezone(auth()->user()->timezone)],
            'project_id' => ['required', Rule::exists('projects', 'id')->where('user_id', auth()->user()->getParentId())],
            'task' => ['max:255'],
            'details' => ['required', 'max:255'],
        ];
    }
}
