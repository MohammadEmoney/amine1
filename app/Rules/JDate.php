<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Morilog\Jalali\Jalalian;

class JDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $dateString = \Morilog\Jalali\CalendarUtils::convertNumbers($value, true);
        $date = explode('-', $dateString);
        if(!isset($date[0]) || !isset($date[1]) || !isset($date[2]))
            $fail(trans('validation.jdate'));
        elseif(!\Morilog\Jalali\CalendarUtils::checkDate($date[0], $date[1], $date[2]))
            $fail(trans('validation.jdate'));
        // elseif (!Jalalian::fromFormat('Y-m-d', $dateString))
        //     $fail(trans('validation.jdate_equal'));
    }
}
