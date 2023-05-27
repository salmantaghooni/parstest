<?php

namespace SalmanTaghooni\Auth\Rules;

use Illuminate\Contracts\Validation\Rule;
use SalmanTaghooni\Auth\Http\Requests\RequestValidation;
class ValidMobile implements Rule
{
    use RequestValidation;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($message = null)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/[0]{1}[0-9]{10}/', $this->convertPersianNumbersToEnglish($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (app()->getLocale() == "fa")
            return 'فرمت موبایل نامعتبر است.';
        return "Mobile Number Is Invalid";
    }


}
