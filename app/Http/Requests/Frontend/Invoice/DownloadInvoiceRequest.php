<?php

namespace App\Http\Requests\Frontend\Invoice;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class DownloadInvoiceRequest.
 */
class DownloadInvoiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'locale' => ['sometimes', 'nullable', Rule::in(array_keys(config('boilerplate.locale.invoices_languages')))],
        ];
    }
}
