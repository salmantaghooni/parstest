<?php

namespace SalmanTaghooni\Auth\Rules;

use Illuminate\Contracts\Validation\Rule;
use SalmanTaghooni\Auth\Http\Requests\RequestValidation;
class ValidPassword implements Rule
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
        return preg_match('/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/', $this->convertPersianNumbersToEnglish($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (app()->getLocale() == "fa")
            return 'فرمت رمز عبور نامعتبر است. رمز عبور باید شامل حداقل 8 و حداکثر 20 کاراکتر باشد.';
        return "Password Is Invalid";
    }


}
