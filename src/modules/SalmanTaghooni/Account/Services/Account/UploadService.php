<?php

namespace SalmanTaghooni\Account\Services\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PDO;
use SalmanTaghooni\Account\Services\Account\Interfaces\AccountServiceInterface;
use SalmanTaghooni\Account\Services\Account\Interfaces\UploadServiceInterface;
use SalmanTaghooni\Account\Services\Account\Interfaces\UserBasicInformationServiceInterface;
use SalmanTaghooni\Account\Traits\HttpRequest;

class UploadService implements UploadServiceInterface
{
    use HttpRequest;

    protected array $checkSumWithRequest;
    protected $time;

    public function __construct(Request $request)
    {
        $this->time = time();
        $this->setConfig(Config::get('metabank.URL'), $request->headers->all(), $this->time);
        $this->checkSumWithRequest = $this->checkSum($request, $this->time);
        $this->checkSumWithRequest = $this->addTokenData($this->checkSumWithRequest, $request->headers->all());
    }

    public function setHeader(Request $request)
    {

        $this->setConfig(Config::get('metabank.URL'), $request->headers->all(), $this->time);

        $this->checkSumWithRequest = $this->checkSum($request, $this->time);
        $this->checkSumWithRequest = $this->addTokenData($this->checkSumWithRequest, $request->headers->all());
    }

    public function addTokenData($request, $header)
    {
        if (!array_key_exists("phoneNumber", $request)) {
            if (array_key_exists("authorization", $header)) {
                $token = str_replace("Bearer ", "", $header['authorization'][0]);
                $tokenParts = explode(".", $token);
                $tokenPayload = base64_decode($tokenParts[1]);
                $jwtPayload = json_decode($tokenPayload, true);
                return (array_merge($jwtPayload, $request));
            }
        }
        return $request;
    }

    public function index()
    {
//        return $this->httpPost(Config::get('metabank.BasicInformation'), $this->checkSumWithRequest);
    }

    public function store($request): ?\Psr\Http\Message\ResponseInterface
    {
        return $this->httpOneUpload(Config::get('metabank.Upload'), $this->checkSumWithRequest);
    }

    public function update($request): ?\Psr\Http\Message\ResponseInterface
    {
        return $this->httpPutUpload(Config::get('metabank.Upload'), $this->checkSumWithRequest);
    }

    protected function checkSum($request, $time): array
    {
        if (isset($request->phone_number) && isset($request->national_code)) {
            $request = array_merge(['phone_number' => $request->phone_number, 'national_code' => $request->national_code], $request->all());
            $createChecksum = hash('sha256', $request['phone_number'] . '!' . $request['national_code'] . '!' . $time);
            return array_merge(['checksum' => $createChecksum], $request);
        } else {
            $request = $this->addTokenData($request->all(), $request->headers->all());
            if (array_key_exists("phone_number", $request)) {
                $createChecksum = hash('sha256', $request['phone_number'] . '!' . $request['national_code'] . '!' . $time);
                return array_merge(['checksum' => $createChecksum], $request);
            }
            return $request;
        }
    }
}
