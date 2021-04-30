<?php

use Carbon\Carbon;

if (! function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'Laravel Boilerplate');
    }
}

if (! function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     *
     * @return Carbon
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return 'admin.dashboard';
            }

            if (auth()->user()->isUser()) {
                return 'frontend.dashboard';
            }
        }

        return 'frontend.index';
    }
}

if (! function_exists('stringDateFormat')) {
    /**
     * Returns a string with a new format for a given string that it's a date
     *
     * @param $time
     * @param $format
     *
     * @return string
     * @throws Exception
     */
    function stringDateFormat($time, $format)
    {
        return carbon($time)->format($format);
    }
}

if (! function_exists('currencyToSymbol')) {
    /**
     * Converts currency code to currency symbol
     *
     * @param $currency_code
     *
     * @return mixed
     * @throws Exception
     */
    function currencyToSymbol($currency_code = false) 
    {
		$currencies = array(
            'USD'=>'$', // US Dollar
            'EUR'=> '€', // Euro
            'CRC'=> '₡', // Costa Rican Colón
            'GBP'=> '£', // British Pound Sterling
            'ILS'=> '₪', // Israeli New Sheqel
            'INR'=> '₹', // Indian Rupee
            'JPY'=> '¥', // Japanese Yen
            'KRW'=> '₩', // South Korean Won
            'NGN'=> '₦', // Nigerian Naira
            'PHP'=> '₱', // Philippine Peso
            'PLN'=> 'zł', // Polish Zloty
            'PYG'=> '₲', // Paraguayan Guarani
            'RON' => 'RON', // Romanian Leu
            'THB'=> '฿', // Thai Baht
            'UAH'=> '₴', // Ukrainian Hryvnia
            'VND'=> '₫', // Vietnamese Dong)
        );
        
        if (!$currency_code) {
            return $currencies;
        }

        if (array_key_exists($currency_code, $currencies)) {
            return $currencies[$currency_code];
        } else {
            return $currency_code;
        }
    }
}

if (! function_exists('billingTypeToPaddleId')) {
    /**
     * Returns a the paddle id of the plan based on the billing type
     *
     * @param $billing_type
     *
     * @return string
     * @throws Exception
     */
    function billingTypeToPaddleId($billing_type)
    {
        $map = [
            Plan::BILLING_TYPE_NONE => null,
            Plan::BILLING_TYPE_MONTHLY => env('MONTHLY_PADDLE_ID'),
            Plan::BILLING_TYPE_YEARLY => env('YEARLY_PADDLE_ID'),
        ];
        return $map[$billing_type];
    }
}