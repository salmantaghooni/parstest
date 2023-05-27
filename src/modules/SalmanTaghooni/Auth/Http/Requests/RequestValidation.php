<?php

namespace SalmanTaghooni\Auth\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;

trait RequestValidation
{
    public function failed($validator,$status) {
        $message = $validator->errors()->all();
        throw new HttpResponseException(response()->json(['messages' => $message],$status));
    }

    public function convertPersianNumbersToEnglish($input)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '٤', '۵', '٥', '٦', '۶', '۷', '۸', '۹'];
        $english = [ 0 ,  1 ,  2 ,  3 ,  4 ,  4 ,  5 ,  5 ,  6 ,  6 ,  7 ,  8 ,  9 ];
        return str_replace($persian, $english, $input);
    }
}




?>