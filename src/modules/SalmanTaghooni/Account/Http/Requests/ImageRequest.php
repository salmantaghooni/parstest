<?php

namespace SalmanTaghooni\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use SalmanTaghooni\Account\Http\Requests\RequestValidation;

class ImageRequest extends FormRequest

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
            "openAccountId" => ['required'],
            'frontImage' => 'image|mimes:jpeg,jpg,png',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->failed($validator, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
