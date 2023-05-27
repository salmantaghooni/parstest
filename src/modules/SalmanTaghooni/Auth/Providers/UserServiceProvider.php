<?php

namespace SalmanTaghooni\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use SalmanTaghooni\Auth\Http\Controllers\Api\V02\Auth\AuthController;
use SalmanTaghooni\Auth\Services\Auth\AuthService;
use SalmanTaghooni\Auth\Services\Auth\Interfaces\AuthServiceInterface;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when(AuthController::class)->needs(AuthServiceInterface::class)->give(AuthService::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . "/../Routes/user_route.php");
    }
}
