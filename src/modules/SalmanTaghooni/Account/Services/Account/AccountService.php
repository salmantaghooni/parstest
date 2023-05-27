<?php

namespace SalmanTaghooni\Account\Services\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PDO;
use SalmanTaghooni\Account\Services\Account\Interfaces\AccountServiceInterface;
use SalmanTaghooni\Account\Traits\HttpRequest;

class AccountService implements AccountServiceInterface
{
    use HttpRequest;
    protected $chechkSumWithRequest;
    protected $time;

    public function __construct(Request $request)
    {
        $this->time = time();
        $this->setConfig(Config::get('metabank.URL'), $request->headers->all(),$this->time);
        $this->chechkSumWithRequest = $this->checkSum($request,$this->time);
        $this->chechkSumWithRequest = $this->addTokenData($this->chechkSumWithRequest, $request->headers->all());
    }

	    public function setHeader(Request $request)
    {
        $this->setConfig(Config::get('metabank.URL'), $request->headers->all(),$this->time);
        $this->chechkSumWithRequest = $this->checkSum($request,$this->time);
        $this->chechkSumWithRequest = $this->addTokenData($this->chechkSumWithRequest, $request->headers->all());
    }

    public function addTokenData($request, $header)
    {
        if (!array_key_exists("phoneNumber", $request)) {
            if (array_key_exists("authorization", $header)) {
                if(isset($header['authorization'][0])){
                    $token = str_replace("Bearer ", "", $header['authorization'][0]);
                    $tokenParts = explode(".", $token);
                    $tokenPayload = base64_decode($tokenParts[1]);
                    $jwtPayload = json_decode($tokenPayload, true);
                    return (array_merge($jwtPayload, $request));
                }
            }
        }
        return $request;
    }
    public function userBasicInformation($request)
    {
        return  $this->httpPost(Config::get('metabank.BasicInformation'), $this->chechkSumWithRequest);
    }
    public function baseAccountLongTerm($request)
    {
        return  $this->httpPost(Config::get('metabank.BaseAccountLongTerm'), $this->chechkSumWithRequest);
    }
    public function checkInformationPerson($request)
    {
        return  $this->httpPost(Config::get('metabank.CheckInformationPerson'), $this->chechkSumWithRequest);
    }
    public function uploadNationalCard($request)
    {
        return  $this->httpOneUpload(Config::get('metabank.Upload'), $this->chechkSumWithRequest);
    }
    public function birthCertificate($request)
    {
        return  $this->httpOneUpload(Config::get('metabank.Upload'), $this->chechkSumWithRequest);
    }
    public function uploadSelfie($request)
    {
        return  $this->httpOneUpload(Config::get('metabank.Upload'), $this->chechkSumWithRequest);
    }
    public function video($request)
    {
        return  $this->httpUploadVideo(Config::get('metabank.Upload'), $this->chechkSumWithRequest);
    }
     public function userVideo($request)
    {
        return  $this->httpUploadVideo(Config::get('metabank.UserUpload'), $this->chechkSumWithRequest);
    }
    public function userGetVideoText($request)
    {
        return  $this->httpPost(Config::get('metabank.UserGetVideoText'), $this->chechkSumWithRequest);
    }

    public function showVideo($request)
    {
        return  $this->httpPost(Config::get('metabank.showVideo'), $this->chechkSumWithRequest);
    }
    public function createNewOpenAccount($request)
    {
        return  $this->httpPost(Config::get('metabank.CreateNewAccount'), $this->chechkSumWithRequest);
    }
    public function openAccountList($request)
    {
        return $this->httpPost(Config::get('metabank.MetaValidation'), $this->chechkSumWithRequest);
    }
    public function activateCard($request)
    {
        return $this->httpPost(Config::get('metabank.activateCard'), $this->chechkSumWithRequest);
    }
    public function nationalCardSerial($request)
    {
        return $this->httpPost(Config::get('metabank.NationalCardSerial'), $this->chechkSumWithRequest);
    }
    public function showImage($request)
    {
        return $this->httpPost(Config::get('metabank.ShowImage'), $this->chechkSumWithRequest);
    }
    public function getVideoText($request)
    {
        return $this->httpPost(Config::get('metabank.GetVideoText'), $this->chechkSumWithRequest);
    }
    public function getIssueProvinceList($request)
    {
        return $this->httpPost(Config::get('metabank.GetIssueProvinceList'), $this->chechkSumWithRequest);
    }
    public function getBirthProvinceList($request)
    {
        return $this->httpPost(Config::get('metabank.getBirthProvinceList'), $this->chechkSumWithRequest);
    }
    public function getBirthCityList($request)
    {
        return $this->httpPost(Config::get('metabank.getBirthCityList'), $this->chechkSumWithRequest);
    }
    public function getIssueCityList($request)
    {
        return $this->httpPost(Config::get('metabank.GetIssueCityList'), $this->chechkSumWithRequest);
    }
    public function getJobList($request)
    {
        return $this->httpPost(Config::get('metabank.GetJobList'), $this->chechkSumWithRequest);
    }
    public function getEducationList($request)
    {
        return $this->httpPost(Config::get('metabank.GetEducationList'), $this->chechkSumWithRequest);
    }
    public function inquiryPostCode($request)
    {
        return $this->httpPost(Config::get('metabank.InquiryPostCode'), $this->chechkSumWithRequest);
    }
    public function FinalizeOpenAccount($request)
    {
        return $this->httpPost(Config::get('metabank.FinalizeOpenAccount'), $this->chechkSumWithRequest);
    }
    public function branchStateList($request)
    {
        return $this->httpPost(Config::get('metabank.BranchStateList'), $this->chechkSumWithRequest);
    }
    public function branchByState($request)
    {
        return $this->httpPost(Config::get('metabank.BranchByState'), $this->chechkSumWithRequest);
    }
    public function chooseBranch($request)
    {
        return $this->httpPost(Config::get('metabank.ChooseBranch'), $this->chechkSumWithRequest);
    }
    public function sendaccounttypelist($request)
    {
        return $this->httpPost(Config::get('metabank.SendAccountTypeList'), $this->chechkSumWithRequest);
    }
    public function chooseAccountType($request)
    {
        return $this->httpPost(Config::get('metabank.ChooseAccountType'), $this->chechkSumWithRequest);
    }
    public function inquiryOpenAccountVerifyCode($request)
    {
        return $this->httpPost(Config::get('metabank.InquiryOpenAccountVerifyCode'), $this->chechkSumWithRequest);
    }
    public function inquiryOpenAccount($request)
    {
        return $this->httpPost(Config::get('metabank.InquiryOpenAccount'), $this->chechkSumWithRequest);
    }
    public function uploadSignature($request)
    {
        return $this->httpOneUpload(Config::get('metabank.Upload'), $this->chechkSumWithRequest);
    }
    public function finish($request)
    {
        return $this->httpPost(Config::get('metabank.Finish'), $this->chechkSumWithRequest);
    }
    public function score($request)
    {
        return $this->httpPost(Config::get('metabank.Score'), $this->chechkSumWithRequest);
    }
    public function userShowImage($request)
    {
        return $this->httpPost(Config::get('metabank.UserShowImage'), $this->chechkSumWithRequest);
    }
    public function userGetImageName($request)
    {
        return $this->httpPost(Config::get('metabank.UserGetImageName'), $this->chechkSumWithRequest);
    }
    public function userShowVideo($request)
    {
        return $this->httpPost(Config::get('metabank.UserShowVideo'), $this->chechkSumWithRequest);
    }
    public function getUsernameInfo($request)
    {
        return $this->httpPost(Config::get('metabank.GetUsernameInfo'), $this->chechkSumWithRequest);
    }

    public function getLongTerms($request)
    {
        return $this->httpPost(Config::get('metabank.getLongTerms'), $this->chechkSumWithRequest);
    }

    protected function checkSum($request,$time)
    {
        if (isset($request->phone_number) && isset($request->national_code)) {
            $request = array_merge(['phone_number' => $request->phone_number, 'national_code' => $request->national_code], $request->all());
            $createChecksum = hash('sha256', $request['phone_number'] . '!' . $request['national_code'] . '!' . $time);
            return  array_merge(['checksum' => $createChecksum], $request);
        } else {
            $request = $this->addTokenData($request->all(), $request->headers->all());
            if (array_key_exists("phone_number", $request)) {
                $createChecksum = hash('sha256', $request['phone_number'] . '!' . $request['national_code'] . '!' . $time);
                return  array_merge(['checksum' => $createChecksum], $request);
            }
            return $request;
        }
    }
}
