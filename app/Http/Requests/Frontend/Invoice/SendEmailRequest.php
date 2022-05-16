<?php

namespace App\Http\Requests\Frontend\Invoice;

use App\Models\Invoice;
use App\Rules\TimesInvoiceJson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class SendEmailRequest.
 */
class SendEmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from' => ['required', 'string', 'email', 'max:255'],
            'to' => ['required', 'string', 'email', 'max:255'],
            'locale' => ['sometimes', 'nullable', Rule::in(array_keys(config('boilerplate.locale.invoices_languages')))],
            'attach_xls' => ['sometimes'],
        ];
    }
}
