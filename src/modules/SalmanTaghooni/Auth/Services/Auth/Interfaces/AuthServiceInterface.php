<?php

namespace SalmanTaghooni\Auth\Services\Auth\Interfaces;

use SalmanTaghooni\Auth\Services\Auth\UserService;

interface AuthServiceInterface
{
    public function doLogin($request);
    public function password($request);
    public function dashboardInfo($request);
    public function metaRegister($request);
    public function metaVerifyCode($request);
    public function metaRules($request);
    public function resendCode($request);
    public function checkAccount($request);
    public function forgetPasswordInformation($request);
    public function forgetPasswordOtp($request);
}
