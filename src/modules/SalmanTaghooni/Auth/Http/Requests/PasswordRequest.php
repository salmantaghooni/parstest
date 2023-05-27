<?php

namespace SalmanTaghooni\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SalmanTaghooni\Auth\Rules\ValidMobile;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use SalmanTaghooni\Auth\Http\Requests\RequestValidation;
use SalmanTaghooni\Auth\Rules\ValidPassword;


class PasswordRequest extends FormRequest

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
        return [
//            "phoneNumber" => ['required', new ValidMobile()],
//            "password" => ['required', new ValidPassword()]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->failed($validator,Response::HTTP_UNPROCESSABLE_ENTITY);
    }


}
