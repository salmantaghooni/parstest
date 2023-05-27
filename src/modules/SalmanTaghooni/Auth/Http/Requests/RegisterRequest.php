<?php

namespace SalmanTaghooni\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SalmanTaghooni\Auth\Rules\ValidMobile;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use SalmanTaghooni\Auth\Http\Requests\RequestValidation;
use SalmanTaghooni\Auth\Rules\ValidNationalCode;

class RegisterRequest extends FormRequest

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
        $this->national_code = $this->convertPersianNumbersToEnglish($this->national_code);
        return [
            "phone_number" => ['required', new ValidMobile],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->failed($validator, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
