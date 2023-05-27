<?php

namespace SalmanTaghooni\Account\Services\Account\Interfaces;


interface AccountServiceInterface
{

    public function userBasicInformation($request);
    public function checkInformationPerson($request);
    public function baseAccountLongTerm($request);
    public function uploadNationalCard($request);
    public function birthCertificate($request);
    public function createNewOpenAccount($request);
    public function openAccountList($request);
    public function activateCard($request);
    public function nationalCardSerial($request);
    public function uploadSelfie($request);
    public function video($request);
    public function showVideo($request);
    public function showImage($request);
    public function GetVideoText($request);
    public function getBirthProvinceList($request);
    public function getIssueProvinceList($request);
    public function getBirthCityList($request);
    public function getIssueCityList($request);
    public function getJobList($request);
    public function getEducationList($request);
    public function inquiryPostCode($request);
    public function FinalizeOpenAccount($request);
    public function branchStateList($request);
    public function branchByState($request);
    public function chooseBranch($request);
    public function chooseAccountType($request);
    public function sendaccounttypelist($request);
    public function uploadSignature($request);
    public function finish($request);
    public function inquiryOpenAccountVerifyCode($request);
    public function inquiryOpenAccount($request);
    public function score($request);
    public function userShowImage($request);
    public function userGetImageName($request);
    public function userShowVideo($request);
    public function getLongTerms($request);
}
