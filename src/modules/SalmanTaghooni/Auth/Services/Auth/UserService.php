<?php

namespace SalmanTaghooni\Auth\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use SalmanTaghooni\Auth\Services\Auth\Interfaces\UserServiceInterface;
use SalmanTaghooni\Auth\Traits\HttpRequest;
use Illuminate\Support\Facades\Redis;
use SalmanTaghooni\Auth\Repository\UserRepository;
use Illuminate\Support\Facades\Route;

class UserService implements UserServiceInterface
{
    public function login($request)
    {
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => '',
            'username' => $request['phone_number'],
            'password' => '',
            'scope' => '*',
        ]);
        $tokenRequest = $request->create('/oauth/token', 'post');
        return Route::dispatch($tokenRequest);
    }
}
