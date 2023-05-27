<?php

namespace SalmanTaghooni\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SalmanTaghooni\Account\Rules\ValidMobile;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use SalmanTaghooni\Account\Http\Requests\RequestValidation;


class LoginRequest extends FormRequest

{
    use RequestValidation;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $customAttributes ;
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
            "phoneNumber" => ['required', new ValidMobile()],
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $this->failed($validator, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
