<?php

use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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
            "Albania Lek (ALL)" => "L",
            "Afghanistan Afghani (AFN)" => "؋",
            "Argentina Peso (ARS)" => "$",
            "Aruba Guilder (AWG)" => "ƒ",
            "Australia Dollar (AUD)" => "$",
            "Azerbaijan New Manat (AZN)" => "₼",
            "Bahamas Dollar (BSD)" => "$",
            "Barbados Dollar (BBD)" => "$",
            "Bangladeshi taka (BDT)" => "৳",
            "Belarus Ruble (BYR)" => "Br",
            "Belize Dollar (BZD)" => "BZ$",
            "Bermuda Dollar (BMD)" => "$",
            "Bolivia Boliviano (BOB)" => '$b',
            "Bosnia and Herzegovina Convertible Marka (BAM)" => "KM",
            "Botswana Pula (BWP)" => "P",
            "Bulgaria Lev (BGN)" => "лв",
            "Brazil Real (BRL)" => "R$",
            "Brunei Darussalam Dollar (BND)" => "$",
            "Cambodia Riel (KHR)" => "៛",
            "Canada Dollar (CAD)" => "$",
            "Cayman Islands Dollar (KYD)" => "$",
            "Chile Peso (CLP)" => "$",
            "China Yuan Renminbi (CNY)" => "¥",
            "Colombia Peso (COP)" => "$",
            "Costa Rica Colon (CRC)" => "₡",
            "Croatia Kuna (HRK)" => "kn",
            "Cuba Peso (CUP)" => "₱",
            "Czech Republic Koruna (CZK)" => "Kč",
            "Denmark Krone (DKK)" => "kr",
            "Dominican Republic Peso (DOP)" => "RD$",
            "East Caribbean Dollar (XCD)" => "$",
            "Egypt Pound (EGP)" => "£",
            "El Salvador Colon (SVC)" => "$",
            "Estonia Kroon (EEK)" => "kr",
            "Euro Member Countries (EUR)" => "€",
            "Falkland Islands (Malvinas) Pound (FKP)" => "£",
            "Fiji Dollar (FJD)" => "$",
            "Ghana Cedis (GHC)" => "₵",
            "Gibraltar Pound (GIP)" => "£",
            "Guatemala Quetzal (GTQ)" => "Q",
            "Guernsey Pound (GGP)" => "£",
            "Guyana Dollar (GYD)" => "$",
            "Honduras Lempira (HNL)" => "L",
            "Hong Kong Dollar (HKD)" => "$",
            "Hungary Forint (HUF)" => "Ft",
            "Iceland Krona (ISK)" => "kr",
            "India Rupee (INR)" => "₹",
            "Indonesia Rupiah (IDR)" => "Rp",
            "Iran Rial (IRR)" => "﷼",
            "Isle of Man Pound (IMP)" => "£",
            "Israel Shekel (ILS)" => "₪",
            "Jamaica Dollar (JMD)" => "J$",
            "Japan Yen (JPY)" => "¥",
            "Jersey Pound (JEP)" => "£",
            "Kazakhstan Tenge (KZT)" => "лв",
            "Korea (North) Won (KPW)" => "₩",
            "Korea (South) Won (KRW)" => "₩",
            "Kyrgyzstan Som (KGS)" => "лв",
            "Laos Kip (LAK)" => "₭",
            "Latvia Lat (LVL)" => "Ls",
            "Lebanon Pound (LBP)" => "£",
            "Liberia Dollar (LRD)" => "$",
            "Lithuania Litas (LTL)" => "Lt",
            "Macedonia Denar (MKD)" => "ден",
            "Malaysia Ringgit (MYR)" => "RM",
            "Mauritius Rupee (MUR)" => "₨",
            "Mexico Peso (MXN)" => "$",
            "Mongolia Tughrik (MNT)" => "₮",
            "Mozambique Metical (MZN)" => "MT",
            "Namibia Dollar (NAD)" => "$",
            "Nepal Rupee (NPR)" => "₨",
            "Netherlands Antilles Guilder (ANG)" => "ƒ",
            "New Zealand Dollar (NZD)" => "$",
            "Nicaragua Cordoba (NIO)" => "C$",
            "Nigeria Naira (NGN)" => "₦",
            "Norway Krone (NOK)" => "kr",
            "Oman Rial (OMR)" => "﷼",
            "Pakistan Rupee (PKR)" => "₨",
            "Panama Balboa (PAB)" => "B/.",
            "Paraguay Guarani (PYG)" => "Gs",
            "Peru Nuevo Sol (PEN)" => "S/.",
            "Philippines Peso (PHP)" => "₱",
            "Poland Zloty (PLN)" => "zł",
            "Qatar Riyal (QAR)" => "﷼",
            "Romania New Leu (RON)" => "lei",
            "Russia Ruble (RUB)" => "₽",
            "Saint Helena Pound (SHP)" => "£",
            "Saudi Arabia Riyal (SAR)" => "﷼",
            "Serbia Dinar (RSD)" => "Дин.",
            "Seychelles Rupee (SCR)" => "₨",
            "Singapore Dollar (SGD)" => "$",
            "Solomon Islands Dollar (SBD)" => "$",
            "Somalia Shilling (SOS)" => "S",
            "South Africa Rand (ZAR)" => "R",
            "Sri Lanka Rupee (LKR)" => "₨",
            "Sweden Krona (SEK)" => "kr",
            "Switzerland Franc (CHF)" => "CHF",
            "Suriname Dollar (SRD)" => "$",
            "Syria Pound (SYP)" => "£",
            "Taiwan New Dollar (TWD)" => "NT$",
            "Thailand Baht (THB)" => "฿",
            "Trinidad and Tobago Dollar (TTD)" => "TT$",
            "Turkey Lira (TRY)" => "₺",
            "Turkey Lira (TRL)" => "₤",
            "Tuvalu Dollar (TVD)" => "$",
            "Ukraine Hryvna (UAH)" => "₴",
            "United Kingdom Pound (GBP)" => "£",
            "Uganda Shilling (UGX)" => "USh",
            "United States Dollar (USD)" => "$",
            "Uruguay Peso (UYU)" => '$U',
            "Uzbekistan Som (UZS)" => "лв",
            "Venezuela Bolivar (VEF)" => "Bs",
            "Viet Nam Dong (VND)" => "₫",
            "Yemen Rial (YER)" => "﷼",
            "Zimbabwe Dollar (ZWD)" => "Z$"
        );
        
        if (!$currency_code) {
            return $currencies;
        }

        if (array_key_exists($currency_code, $currencies)) {
            return $currencies[$currency_code];
        } else {
            foreach ($currencies as $currency => $symbol) {
                if (strpos($currency, '(' . $currency_code . ')') !== false) {
                    return $symbol;
                }
            }
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

if (! function_exists('hashRequestPasswords')) {
    /**
     * Transforms a request by hashing the password properties from it
     *
     * @param $request
     *
     * @return \Illuminate\Http\Request
     */
    function hashRequestPasswords($request)
    {
        $request = $request->all();
        foreach ($request as $key => $value) {
            if (strpos($key, "password") !== false) {
                $request[$key] = "******";
            }
        }
        return $request;
    }
}

if (! function_exists('currencyCode')) {
    /**
     * Transforms a currency key into a 3 letters code by extrating it from paranthesis
     *
     * @param $currency
     *
     * @return string
     */
    function currencyCode($currency)
    {
        return explode(')', explode('(', $currency)[1])[0];
    }
}

if (! function_exists('generateInvoiceNumber')) {
    /**
     * Generates a new invoice number based on the last invoice number
     *
     * @param $previous_invoice_number
     *
     * @return string
     */
    function generateInvoiceNumber($previous_invoice_number = "1")
    {
        $original_number = preg_replace('/[^0-9]/', '', $previous_invoice_number);
        $number = $original_number;
        $intnumber = intval($number);
        $newintnumber = $intnumber + 1;

        if (strlen($number) > strlen($intnumber) && strlen($newintnumber) > strlen($intnumber)) {
            $pos = strpos($number, "0");
            if ($pos !== false) {
                $number = substr_replace($number, "", $pos, 1);
            }
        }

        $newnumber = str_replace($intnumber, $newintnumber, $number);
        $invoice_number = str_replace($original_number, $newnumber, $previous_invoice_number);
        return $invoice_number;
    }
}