<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class TimesInvoiceJson.
 */
class TimesInvoiceJson implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function passes($attribute, $value)
    {
        $times = json_decode($value);

        foreach ($times as $time) {
            if (is_null(auth()->user()->times()->find($time))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('Some of the :attribute are not belonging to you.');
    }
}
