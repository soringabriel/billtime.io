<?php

namespace App\Http\Requests\Frontend\Invoice;

use App\Models\Invoice;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateInvoiceStatusRequest.
 */
class UpdateInvoiceStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', Rule::in(Invoice::STATUSES)],
        ];
    }
}
