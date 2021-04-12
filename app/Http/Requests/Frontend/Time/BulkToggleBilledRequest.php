<?php

namespace App\Http\Requests\Frontend\Time;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BulkToggleBilledRequest.
 */
class BulkToggleBilledRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'times' => ['required', 'json'],
        ];
    }
}
