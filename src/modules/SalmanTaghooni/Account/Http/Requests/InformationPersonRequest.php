<?php

namespace SalmanTaghooni\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use SalmanTaghooni\Account\Http\Requests\RequestValidation;

class InformationPersonRequest extends FormRequest

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
            "firstName" => ['required'],
            "lastName" => ['required'],
            "fatherName" => ['required'],
            "gender" => ['required'],
            "birthdate" => ['required'],
            "birthCertificateNumber" => ['required'],
            "birthCertificateSeri" => ['required'],
            "birthCertificateSerial" => ['required'],
            "officeCode" => ['required'],
            "officeName" => ['required'],
            "deathStatus" => ['required'],
            "deathDate" => ['required'],
            "firstName_en" => ['required'],
            "lastName_en" => ['required'],
            "openAccountId" => ['required', 'numeric'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->failed($validator, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
