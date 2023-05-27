<?php

namespace SalmanTaghooni\Account\Providers;

use Illuminate\Support\ServiceProvider;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\AccountController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\CheckInformationPersonController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\NationalCardSerialController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\UploadController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\UserBasicInformationController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\UploadVideoController;
use SalmanTaghooni\Account\Services\Account\AccountService;
use SalmanTaghooni\Account\Services\Account\CheckInformationPersonService;
use SalmanTaghooni\Account\Services\Account\Interfaces\AccountServiceInterface;
use SalmanTaghooni\Account\Services\Account\Interfaces\CheckInformationPersonServiceInterface;
use SalmanTaghooni\Account\Services\Account\Interfaces\NationalCardSerialInterface;
use SalmanTaghooni\Account\Services\Account\Interfaces\UploadServiceInterface;
use SalmanTaghooni\Account\Services\Account\Interfaces\UserBasicInformationServiceInterface;
use SalmanTaghooni\Account\Services\Account\NationalCardSerialService;
use SalmanTaghooni\Account\Services\Account\UploadService;
use SalmanTaghooni\Account\Services\Account\UserBasicInformationService;

class AccountServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when(AccountController::class)->needs(AccountServiceInterface::class)->give(AccountService::class);
        $this->app->when(UserBasicInformationController::class)->needs(UserBasicInformationServiceInterface::class)->give(UserBasicInformationService::class);
        $this->app->when(CheckInformationPersonController::class)->needs(CheckInformationPersonServiceInterface::class)->give(CheckInformationPersonService::class);
        $this->app->when(UploadController::class)->needs(UploadServiceInterface::class)->give(UploadService::class);
        $this->app->when(NationalCardSerialController::class)->needs(NationalCardSerialInterface::class)->give(NationalCardSerialService::class);
        $this->app->when(UploadVideoController::class)->needs(UploadServiceInterface::class)->give(UploadService::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . "/../Routes/account_route.php");
    }
}
