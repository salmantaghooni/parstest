<?php

use Illuminate\Support\Facades\Route;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\AccountController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\CheckInformationPersonController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\NationalCardSerialController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\UploadController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\UploadVideoController;
use SalmanTaghooni\Account\Http\Controllers\Api\V02\Account\UserBasicInformationController;


Route::prefix('api/v2/')->middleware('lang')->group(function ($router)
 {

    Route::prefix('account/')->namespace('SalmanTaghooni\Http\Controllers\Api\V02\Account')->group(function () {
        Route::post('openaccountlist', [AccountController::class, 'openAccountList']);
        Route::post('createnewopenaccount', [AccountController::class, 'createNewOpenAccount']);
        Route::post('activatecard', [AccountController::class, 'activateCard']);

        Route::post('userbasicinformation',  [UserBasicInformationController::class, 'store']);
        Route::get('userbasicinformation',  [UserBasicInformationController::class, 'index']);
        Route::put('userbasicinformation',  [UserBasicInformationController::class, 'update']);


        Route::post('checkinformationperson',  [CheckInformationPersonController::class, 'store']);
        Route::get('checkinformationperson',  [CheckInformationPersonController::class, 'index']);
        Route::put('checkinformationperson',  [CheckInformationPersonController::class, 'update']);


        Route::post('uploadnationalcard',  [UploadController::class, 'store']);
        Route::get('uploadnationalcard',  [UploadController::class, 'index']);
        Route::put('uploadnationalcard/{id}',  [UploadController::class, 'update']);


        Route::post('birthcertificate', [UploadController::class, 'store']);
        Route::get('birthcertificate', [UploadController::class, 'index']);
        Route::put('birthcertificate/{id}', [UploadController::class, 'update']);


        Route::get('nationalcardserial', [NationalCardSerialController::class, 'index']);
        Route::put('nationalcardserial', [NationalCardSerialController::class, 'update']);
        Route::post('nationalcardserial', [NationalCardSerialController::class, 'store']);


        Route::post('showimage', [AccountController::class, 'showImage']);

        Route::get('uploadselfie', [UploadController::class, 'index']);
        Route::post('uploadselfie', [UploadController::class, 'store']);
        Route::put('uploadselfie/{id}', [UploadController::class, 'update']);



        Route::post('getvideotext', [AccountController::class, 'getVideoText']);

        Route::get('video', [UploadVideoController::class, 'index']);
        Route::post('video', [UploadVideoController::class, 'store']);
        Route::put('video', [UploadVideoController::class, 'update']);


        Route::post('showvideo', [AccountController::class, 'showVideo']);
        Route::post('getbirthprovincelist', [AccountController::class, 'getBirthProvinceList']);
        Route::post('getissueprovincelist', [AccountController::class, 'getIssueProvinceList']);
        Route::post('getbirthcitylist', [AccountController::class, 'getBirthCityList']);
        Route::post('getissuecitylist', [AccountController::class, 'getIssueCityList']);
        Route::post('getjoblist', [AccountController::class, 'getJobList']);
        Route::post('geteducationlist', [AccountController::class, 'getEducationList']);
        Route::post('inquirypostalcode', [AccountController::class, 'inquiryPostCode']);
        Route::post('finalizeopenaccount', [AccountController::class, 'finalizeOpenAccount']);
        Route::post('branchstatelist', [AccountController::class, 'branchStateList']);
        Route::post('branchbystate', [AccountController::class, 'branchByState']);
        Route::post('choosebranch', [AccountController::class, 'chooseBranch']);
        Route::post('sendaccounttypelist', [AccountController::class, 'sendAccountTypeList']);
        Route::post('uploadsignature', [UploadController::class, 'store']);
        Route::post('chooseaccounttype', [AccountController::class, 'chooseAccountType']);
        Route::post('finish', [AccountController::class, 'finish']);
        Route::post('inquiryopenaccountverifycode', [AccountController::class, 'inquiryOpenAccountVerifyCode']);
        Route::post('inquiryopenaccount', [AccountController::class, 'inquiryOpenAccount']);
        Route::post('score', [AccountController::class, 'score']);
        Route::post('usershowimage', [AccountController::class, 'userShowImage']);
        Route::post('usergetimagename', [AccountController::class, 'userGetImageName']);
        Route::post('usershowvideo', [AccountController::class, 'userShowVideo']);
        Route::post('baseaccountlongterm', [AccountController::class, 'baseAccountLongTerm']);
        Route::post('getusernameinfo', [AccountController::class, 'getUsernameInfo']);



        Route::post('getLongTerms', [AccountController::class, 'getLongTerms']);
    });
});
