<?php

namespace App\Http\Requests\Frontend\Time;

use App\Models\Time;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
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
                'before_or_equal:' . Carbon::now()->timezone(auth()->user()->timezone), 
                'before_or_equal:' . FormRequest::input('end_time'), 
                (!empty(FormRequest::input('end_time')) ? 'after:' . Carbon::createFromFormat('Y-m-d H:i', FormRequest::input('end_time'))->subDay() : '')
            ],
            'end_time' => ['required', 'date_format:Y-m-d H:i', 'before_or_equal:' . Carbon::now()->timezone(auth()->user()->timezone)],
            'project_id' => ['required', Rule::exists('projects', 'id')->where('organization_id', auth()->user()->organization()->first()->id)],
            'task' => ['max:255'],
            'details' => ['max:255'],
        ];
    }
    
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if (Auth::guard('api')->check()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422));
        }
    }
}
