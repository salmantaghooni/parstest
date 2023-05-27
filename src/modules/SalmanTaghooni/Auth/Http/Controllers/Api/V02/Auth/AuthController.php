<?php

namespace SalmanTaghooni\Auth\Http\Controllers\Api\V02\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use IvanoMatteo\LaravelDeviceTracking\LaravelDeviceTracking;
use SalmanTaghooni\Auth\Http\Controllers\ApiController;

use SalmanTaghooni\Auth\Http\Requests\LoginRequest;
use SalmanTaghooni\Auth\Http\Requests\MobileOtpRequest;
use SalmanTaghooni\Auth\Http\Requests\PasswordRequest;
use SalmanTaghooni\Auth\Http\Requests\RegisterRequest;
use SalmanTaghooni\Auth\Rules\ValidMobile;
use SalmanTaghooni\Auth\Rules\ValidNationalCode;
use SalmanTaghooni\Auth\Services\Auth\Interfaces\AuthServiceInterface;
use IvanoMatteo\LaravelDeviceTracking\LaravelDeviceTrackingFacade as DeviceTracker;


class AuthController extends ApiController
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function doLogin(Request $request)
    {
        $isLogin = $this->authService->doLogin($request);
        return $this->responseErrorData($isLogin) ??  $this->responseSuccessData(json_decode($isLogin->getBody()->getContents()));
    }

    public function password(Request $request)
    {
        $isCorrectPassword = $this->authService->password($request);
        return $this->responseErrorData($isCorrectPassword) ?? $this->responseSuccessData(json_decode($isCorrectPassword->getContent()));
    }

    public function resendCode(RegisterRequest $request)
    {
        $isLogin = $this->authService->resendCode($request->input());
        return $this->responseErrorData($isLogin) ?? $this->responseSuccessData(json_decode($isLogin->getBody()->getContents()));
    }

    public function checkAccount(Request $request)
    {
        $isLogin = $this->authService->checkAccount($request->input());
        return $this->responseErrorData($isLogin) ?? $this->responseSuccessData(json_decode($isLogin->getBody()->getContents()));
    }

    public function metaRegister(RegisterRequest $request)
    {
        $metaRegister = $this->authService->metaRegister($request->input());
        return $this->responseErrorData($metaRegister) ?? $this->responseSuccessData(json_decode($metaRegister->getBody()->getContents()));
    }

    public function metaVerifyCode(MobileOtpRequest $request)
    {
        $request->verifyCode = $this->convertPersianNumbersToEnglish($request->verifyCode);
        $request->mobile = $this->convertPersianNumbersToEnglish($request->mobile);
        $response = $this->authService->metaVerifyCode($request->input());
        if (is_array($response))
            return $this->responseSuccessData($response);
        else
            return $this->responseErrorData($response);
    }

    public function dashboardInfo(Request $request)
    {
        $response = $this->authService->dashboardInfo($request->input());
        return $this->responseErrorData($response) ?? $this->responseSuccessData(json_decode($response->getBody()->getContents()));
    }

    public function forgetPasswordInformation(Request $request)
    {
        $response = $this->authService->forgetPasswordInformation($request->input());
        return $this->responseErrorData($response) ?? $this->responseSuccessData(json_decode($response->getBody()->getContents()));
    }

    public function forgetPasswordOtp(Request $request)
    {
        $response = $this->authService->forgetPasswordOtp($request->input());
        return $this->responseErrorData($response) ?? $this->responseSuccessData(json_decode($response->getBody()->getContents()));
    }

    private function convertPersianNumbersToEnglish($input)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '٤', '۵', '٥', '٦', '۶', '۷', '۸', '۹'];
        $english = [0, 1, 2, 3, 4, 4, 5, 5, 6, 6, 7, 8, 9];
        return str_replace($persian, $english, $input);
    }

    public function metaRules()
    {
        $request = new Request();
        $request = array_merge($request->all(), ['phoneNumber' => $request->phoneNumber, 'nationalCode' => $request->nationalCode]);
        $validator = Validator::make($request, [
            "phoneNumber" => ['required', new ValidMobile()],
            "nationalCode" => ['required', new ValidNationalCode()],
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->getMessageBag(), Response::HTTP_OK);
        }
        $metaRules = $this->authService->metaRules($request);
        return $this->responseErrorData($metaRules) ?? $this->responseSuccessData(json_decode($metaRules->getBody()->getContents()));
    }

    private function responseSuccessData($res)
    {
        return $this->successResponse($res, Response::HTTP_OK);
    }

    private function responseErrorData($response)
    {
        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $errMessage = json_decode($response->getBody()->getContents(), true);
            return $this->errorResponse($errMessage['messages'] ?? null, $response->getStatusCode());
        }
        return null;
    }
}
