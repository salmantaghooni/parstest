<?php

namespace SalmanTaghooni\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SalmanTaghooni\Account\Rules\ValidMobile;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use SalmanTaghooni\Account\Http\Requests\RequestValidation;
use SalmanTaghooni\Account\Rules\ValidNationalCode;

class MobileOtpRequest extends FormRequest

{
    use RequestValidation;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->nationalCode = $this->convertPersianNumbersToEnglish($this->nationalCode);
        $this->verifyCode = $this->convertPersianNumbersToEnglish($this->verifyCode);
        $this->mobile = $this->convertPersianNumbersToEnglish($this->mobile);
        return [
            "phoneNumber" => ['required', new ValidMobile],
            "nationalCode" => ['required', 'numeric', 'digits:10', new ValidNationalCode],
            "verifyCode" => ['required', 'numeric'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->failed($validator, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
