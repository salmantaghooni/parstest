<?php

use Illuminate\Support\Facades\Route;
use SalmanTaghooni\Auth\Http\Controllers\Api\V02\Auth\AuthController;


Route::prefix('api/v2/')->middleware(['lang','requestValidation'])->group(function ($router)
 {
    Route::prefix('auth/')->namespace('SalmanTaghooni\Auth\Http\Controllers\Api\V02\Auth')->group(function () {
        Route::post('dashboardinfo', [AuthController::class, 'dashboardInfo']);
        Route::post('login', [AuthController::class, 'doLogin']);
        Route::post('password', [AuthController::class, 'password']);
        Route::post('resendcode', [AuthController::class, 'resendCode']);
        Route::post('checkaccount', [AuthController::class, 'checkAccount']);
        Route::post('metaregister', [AuthController::class, 'metaRegister']);
        Route::post('metaverifycode', [AuthController::class, 'metaVerifyCode']);
        Route::post('metaRules', [AuthController::class, 'metarules']);
        Route::post('check', [AuthController::class, 'check']);
    });

     Route::prefix('forgetpassword/')->namespace('SalmanTaghooni\Auth\Http\Controllers\Api\V02\Auth')->group(function () {
         Route::post('information', [AuthController::class, 'forgetPasswordInformation']);
         Route::post('otp', [AuthController::class, 'forgetPasswordOtp']);
     });
});
