<?php

namespace SalmanTaghooni\Auth\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use SalmanTaghooni\Auth\Services\Auth\Interfaces\AuthServiceInterface;
use SalmanTaghooni\Auth\Traits\HttpRequest;
use Illuminate\Support\Facades\Redis;
use SalmanTaghooni\Auth\Repository\UserRepository;
use Illuminate\Support\Facades\Route;

class AuthService implements AuthServiceInterface
{
    use HttpRequest;

    protected $tokenWithRequest;
    protected $userRepository;
    protected $userService;

    public function __construct(Request $request, UserRepository $userRepository,UserService $userService)
    {
        $time = time();
        $this->setConfig(Config::get('metabank.URL'), $request->headers->all(), $time);
        $this->tokenWithRequest = $this->addTokenData($request, $request->headers->all());
        $this->userRepository = $userRepository;
        $this->userService = $userService;

    }

    public function doLogin($request)
    {

        $login =  $this->httpPost(Config::get('metabank.MetaLogin'), $this->tokenWithRequest);

        return $login;
    }

    public function password($request)
    {
        $login  = $this->httpPost(Config::get('metabank.MetaPassword'), $this->tokenWithRequest);
        if ($login->getStatusCode() == 200) {
            $this->userRepository->firstOrCreate($request->input());
            return $this->userService->login($request);
        }
        return $login;
    }

    public function dashboardInfo($request)
    {
        return $this->httpGet(Config::get('metabank.DashboardInfo'), $this->tokenWithRequest);
    }

    public function checkAccount($request)
    {
        return $this->httpPost(Config::get('metabank.CheckAccount'), $this->tokenWithRequest);
    }

    public function resendCode($request)
    {
        return $this->httpPost(Config::get('metabank.MetaResendCode'), $this->tokenWithRequest);
    }

    public function metaRegister($request)
    {
        //        $data = [
        //            'nationalCode' => $this->tokenWithRequest['nationalCode'],
        //            'password' => bcrypt($this->tokenWithRequest['password'])
        //        ];
        return $this->httpPost(Config::get('metabank.MetaRegister'), $this->tokenWithRequest);
    }

    public function metaVerifyCode($request)
    {
        $result =  $this->httpPost(Config::get('metabank.metaVerifyCode'), $this->tokenWithRequest);

        if ($result->getStatusCode() == 200) {
            $result = json_decode($result->getBody()->getContents(),true);
            User::where('phone_number', $request['phone_number'])->update(["token"=>$result['response']['token']]);
            // return $this->userService->login($request);
            return $result;
        }
        return $result;
    }

    public function forgetPasswordInformation($request)
    {
        return $this->httpPost(Config::get('metabank.forgetPasswordInformation'), $this->tokenWithRequest);
    }

    public function forgetPasswordOtp($request)
    {
        return $this->httpPost(Config::get('metabank.forgetPasswordOtp'), $this->tokenWithRequest);
    }

    public function metaRules($request)
    {
        return $this->httpPost(Config::get('metabank.metaVerifyCode'), $this->tokenWithRequest);
    }

    public function addTokenData($request, $header)
    {

        if (!isset($request->phoneNumber)) {
            if (empty($header['authorization'][0]) && $request !=null)
                return $request->all();
            if (array_key_exists("authorization", $header)) {
                $token = str_replace("Bearer ", "", $header['authorization'][0]);
                if ($token != "null") {
                    $tokenParts = explode(".", $token);
                    $tokenPayload = base64_decode($tokenParts[1]);
                    $jwtPayload = json_decode($tokenPayload, true);
                    return (array_merge($jwtPayload, $request->all()));
                } else {
                    return ($request->all());
                }
            }
        }
        return $request->all();
    }
}
