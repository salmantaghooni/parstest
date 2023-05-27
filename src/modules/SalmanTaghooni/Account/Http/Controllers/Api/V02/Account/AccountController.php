<?php

namespace SalmanTaghooni\Account\Http\Controllers\Api\V02\Account;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use SalmanTaghooni\Account\Http\Controllers\ApiController;
use SalmanTaghooni\Account\Http\Requests\BasicInformationRequest;
use Illuminate\Http\Request;
use SalmanTaghooni\Account\Http\Requests\LoginRequest;
use SalmanTaghooni\Account\Services\Account\Interfaces\AccountServiceInterface;
use SalmanTaghooni\Account\Http\Requests\ImageRequest;
use SalmanTaghooni\Account\Http\Requests\InformationPersonRequest;
use stdClass;

class AccountController extends ApiController
{
    protected $accountService;

    public function __construct(AccountServiceInterface $accountService)
    {
        $this->accountService = $accountService;
    }


    public function userGetImageName(Request $request)
    {
        $upload = $this->accountService->userGetImageName($request);
        return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));
    }

    public function baseAccountLongTerm(Request $request)
    {
        $baseAccountLongTerm = $this->accountService->baseAccountLongTerm($request);
        return $this->responseErrorData($baseAccountLongTerm) ??  $this->responseSuccessData(json_decode($baseAccountLongTerm->getBody()->getContents()));
    }

    public function userShowVideo(Request $request)
    {
        $upload = $this->accountService->userShowVideo($request);

        $file_info = new \finfo(FILEINFO_MIME_TYPE);

        return response::stream(function() use($upload) {
            echo base64_encode($upload->getBody());
        }, 200, ['Content-type' => 'application/json']);

//        $this->responseErrorData($upload);
//        $file = stream_get_contents();
//        fclose($file);

//        return response(), 200);
//        $view = view('video', [
//            'a' => $upload
//        ])->render();
//
//        return response()->json(['view'=> $view, 'proc' => 'ddd']);

//        return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));
    }

    public function uploadNationalCard(Request $request)
    {


        $pic = $request->file('frontImage');


        if ($request->hasFile('frontImage')) {
            $request->frontImage = file_get_contents($request->file('frontImage'));
            if ($request->hasFile('backImage'))
                $request->backImage = file_get_contents($request->file('backImage'));


            $request->frontImage = base64_decode(str_replace(' ', '+', str_replace('data:image/' . $pic->getClientOriginalExtension() . ';base64,', '', $request->frontImage)));
            if ($request->hasFile('backImage'))
                $request->backImage = base64_decode(str_replace(' ', '+', str_replace('data:image/' . $pic->getClientOriginalExtension() . ';base64,', '', $request->backImage)));

            $f = uniqid('', true);
            $b = uniqid('', true);

            //$request->query->add($f,$f);
            //$request->query->add($b,$b);

            $myRequest = new \Illuminate\Http\Request($request->all());
            $myRequest = $myRequest->merge(['f' => $f, "b" => $b, "type_file" => $pic->getClientOriginalExtension()]);


            foreach ($request->headers->all() as $key => $value) {
                $myRequest->headers->set($key, $value);
            }

            Storage::put($f . '.' . $pic->getClientOriginalExtension(), $request->frontImage);
            if ($request->hasFile('backImage'))
                Storage::put($b . '.' . $pic->getClientOriginalExtension(), $request->backImage);


            $this->accountService->setHeader($myRequest);

            $upload = $this->accountService->uploadNationalCard($myRequest);
            return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));

        }
    }

    public function userShowImage(Request $request)
    {
        $upload = $this->accountService->userShowImage($request);

        return response::stream(function() use($upload) {
            echo base64_encode($upload->getBody());
        }, 200, ['Content-type' => 'application/json']);
    }

    public function birthCertificate(Request $request)
    {
        $pic = $request->file('frontImage');
        if ($request->hasFile('frontImage')) {
            $request->frontImage = file_get_contents($request->file('frontImage'));
            if ($request->hasFile('backImage'))
                $request->backImage = file_get_contents($request->file('backImage'));


            $request->frontImage = base64_decode(str_replace(' ', '+', str_replace('data:image/' . $pic->getClientOriginalExtension() . ';base64,', '', $request->frontImage)));
            if ($request->hasFile('backImage'))
                $request->backImage = base64_decode(str_replace(' ', '+', str_replace('data:image/' . $pic->getClientOriginalExtension() . ';base64,', '', $request->backImage)));

            $f = uniqid('', true);
            $b = uniqid('', true);

            //$request->query->add($f,$f);
            //$request->query->add($b,$b);

            $myRequest = new \Illuminate\Http\Request($request->all());
            $myRequest = $myRequest->merge(['f' => $f, "b" => $b, "type_file" => $pic->getClientOriginalExtension()]);


            foreach ($request->headers->all() as $key => $value) {
                $myRequest->headers->set($key, $value);
            }

            Storage::put($f . '.' . $pic->getClientOriginalExtension(), $request->frontImage);
            if ($request->hasFile('backImage'))
                Storage::put($b . '.' . $pic->getClientOriginalExtension(), $request->backImage);


            $this->accountService->setHeader($myRequest);

            $upload = $this->accountService->birthCertificate($myRequest);
            return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));

        }
    }

    public function openAccountList(Request $request)
    {
        $openAccountList = $this->accountService->openAccountList($request);
        return $this->responseErrorData($openAccountList) ?? $this->responseSuccessData(json_decode($openAccountList->getBody()->getContents()));

    }

    public function activateCard(Request $request)
    {
        $openAccountList = $this->accountService->activateCard($request);
        return $this->responseErrorData($openAccountList) ?? $this->responseSuccessData(json_decode($openAccountList->getBody()->getContents()));

    }


    public function createNewOpenAccount(Request $request)
    {
        $create = $this->accountService->createNewOpenAccount($request);
        return $this->responseErrorData($create) ?? $this->responseSuccessData(json_decode($create->getBody()->getContents()));

    }

    public function nationalCardSerial(Request $request)
    {
        $nationalCardSerial = $this->accountService->nationalCardSerial($request);
        return $this->responseErrorData($nationalCardSerial) ?? $this->responseSuccessData(json_decode($nationalCardSerial->getBody()->getContents()));

    }

    public function showImage(Request $request)
    {
        $image = $this->accountService->showImage($request);
        return $this->responseErrorData($image) ?? $this->responseSuccessData(json_decode($image->getBody()->getContents()));

    }

    public function getVideoText(Request $request)
    {
        $videoText = $this->accountService->getVideoText($request);
        return $this->responseErrorData($videoText) ?? $this->responseSuccessData(json_decode($videoText->getBody()->getContents()));

    }

    public function getBirthProvinceList(Request $request)
    {
        $province = $this->accountService->getBirthProvinceList($request);
        return $this->responseErrorData($province) ?? $this->responseSuccessData(json_decode($province->getBody()->getContents()));

    }

    public function getIssueProvinceList(Request $request)
    {
        $province = $this->accountService->getIssueProvinceList($request);
        return $this->responseErrorData($province) ?? $this->responseSuccessData(json_decode($province->getBody()->getContents()));

    }

    public function getBirthCityList(Request $request)
    {
        $cities = $this->accountService->getBirthCityList($request);
        return $this->responseErrorData($cities) ?? $this->responseSuccessData(json_decode($cities->getBody()->getContents()));

    }

    public function getIssueCityList(Request $request)
    {
        $cities = $this->accountService->getIssueCityList($request);
        return $this->responseErrorData($cities) ?? $this->responseSuccessData(json_decode($cities->getBody()->getContents()));

    }

    public function getJobList(Request $request)
    {
        $jobs = $this->accountService->getJobList($request);
        return $this->responseErrorData($jobs) ?? $this->responseSuccessData(json_decode($jobs->getBody()->getContents()));

    }

    public function getEducationList(Request $request)
    {
        $educations = $this->accountService->GetEducationList($request);
        return $this->responseErrorData($educations) ?? $this->responseSuccessData(json_decode($educations->getBody()->getContents()));

    }

    public function inquiryPostCode(Request $request)
    {
        $inqueyPostCode = $this->accountService->inquiryPostCode($request);
        return $this->responseErrorData($inqueyPostCode) ?? $this->responseSuccessData(json_decode($inqueyPostCode->getBody()->getContents()));

    }

    public function finalizeOpenAccount(Request $request)
    {

        $finalizeOpenAccount = $this->accountService->finalizeOpenAccount($request);

        return $this->responseErrorData($finalizeOpenAccount) ?? $this->responseSuccessData(json_decode($finalizeOpenAccount->getBody()->getContents()));

    }

    public function s(Request $request)
    {
    }

    public function branchStateList(Request $request)
    {
        $stateList = $this->accountService->branchStateList($request);
        return $this->responseErrorData($stateList) ?? $this->responseSuccessData(json_decode($stateList->getBody()->getContents()));

    }

    public function branchByState(Request $request)
    {
        $listByState = $this->accountService->branchByState($request);
        return $this->responseErrorData($listByState) ?? $this->responseSuccessData(json_decode($listByState->getBody()->getContents()));

    }

    public function chooseBranch(Request $request)
    {
        $branchs = $this->accountService->chooseBranch($request);
        return $this->responseErrorData($branchs) ?? $this->responseSuccessData(json_decode($branchs->getBody()->getContents()));

    }

    public function chooseAccountType(Request $request)
    {
        $branchs = $this->accountService->chooseAccountType($request);
        return $this->responseErrorData($branchs) ?? $this->responseSuccessData(json_decode($branchs->getBody()->getContents()));

    }

    public function sendaccounttypelist(Request $request)
    {
        $typelist = $this->accountService->sendaccounttypelist($request);
        return $this->responseErrorData($typelist) ?? $this->responseSuccessData(json_decode($typelist->getBody()->getContents()));

    }

    public function finish(Request $request)
    {
        $finish = $this->accountService->finish($request);
        return $this->responseErrorData($finish) ?? $this->responseSuccessData(json_decode($finish->getBody()->getContents()));

    }

    public function score(Request $request)
    {
        $score = $this->accountService->score($request);
        return $this->responseErrorData($score) ?? $this->responseSuccessData(json_decode($score->getBody()->getContents()));

    }

    public function uploadSelfie(Request $request)
    {
        if ($request->file('frontImage')) {
            $pic = $request->file('frontImage');


            if ($request->hasFile('frontImage')) {
                $request->frontImage = file_get_contents($request->file('frontImage'));
                if ($request->hasFile('backImage'))
                    $request->backImage = file_get_contents($request->file('backImage'));


                $request->frontImage = base64_decode(str_replace(' ', '+', str_replace('data:image/' . $pic->getClientOriginalExtension() . ';base64,', '', $request->frontImage)));
                if ($request->hasFile('backImage'))
                    $request->backImage = base64_decode(str_replace(' ', '+', str_replace('data:image/' . $pic->getClientOriginalExtension() . ';base64,', '', $request->backImage)));

                $f = uniqid('', true);
                $b = uniqid('', true);

                //$request->query->add($f,$f);
                //$request->query->add($b,$b);

                $myRequest = new \Illuminate\Http\Request($request->all());
                $myRequest = $myRequest->merge(['f' => $f, "b" => $b, "type_file" => $pic->getClientOriginalExtension()]);


                foreach ($request->headers->all() as $key => $value) {
                    $myRequest->headers->set($key, $value);
                }

                Storage::put($f . '.' . $pic->getClientOriginalExtension(), $request->frontImage);
                if ($request->hasFile('backImage'))
                    Storage::put($b . '.' . $pic->getClientOriginalExtension(), $request->backImage);


                $this->accountService->setHeader($myRequest);
                $upload = $this->accountService->uploadSelfie($myRequest);
                return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));

            }
        }
    }

    public function video(Request $request)
    {
        if ($request->file('frontImage')) {
            $upload = $this->accountService->video($request);
            return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));

        }
    }

    public function showVideo(Request $request)
    {
        $upload = $this->accountService->showVideo($request);
        return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));

    }

    public function inquiryOpenAccountVerifyCode(Request $request)
    {
        $upload = $this->accountService->inquiryOpenAccountVerifyCode($request);
        return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));

    }

    public function inquiryOpenAccount(Request $request)
    {
        $upload = $this->accountService->inquiryOpenAccount($request);
        return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));

    }

    public function uploadSignature(Request $request)
    {
        if ($request->hasFile('frontImage')){
            $pic = $request->file('frontImage');

            $request->frontImage = file_get_contents($request->file('frontImage'));

            $f = uniqid('', true);

            //$request->query->add($f,$f);
            //$request->query->add($b,$b);

            $myRequest = new \Illuminate\Http\Request($request->all());
            $myRequest = $myRequest->merge(['f' => $f, "type_file" => $pic->getClientOriginalExtension()]);


            foreach ($request->headers->all() as $key => $value) {
                $myRequest->headers->set($key, $value);
            }

            Storage::put($f . '.' . $pic->getClientOriginalExtension(), $request->frontImage);


            $this->accountService->setHeader($myRequest);
            $upload = $this->accountService->uploadSignature($myRequest);

            return $this->responseErrorData($upload) ?? $this->responseSuccessData(json_decode($upload->getBody()->getContents()));

        }

    }

    public function getUsernameInfo(Request $request)
    {
        $userInfo = $this->accountService->getUsernameInfo($request);
        return $this->responseErrorData($userInfo) ?? $this->responseSuccessData(json_decode($userInfo->getBody()->getContents()));

    }

    public function getLongTerms(Request $request)
    {
        $accounts = $this->accountService->getLongTerms($request);
        return $this->responseErrorData($accounts) ?? $this->responseSuccessData(json_decode($accounts->getBody()->getContents()));

    }

//    public function responseSuccessData($res)
//    {
//        return $this->successResponse($res, Response::HTTP_OK);
//    }
//    public function responseErrorData($response)
//    {
//        if (is_null($response->getStatusCode()) || $response->getStatusCode() != 200)
//            return $this->errorResponse("سرور قادر به پاسخگویی نیست", Response::HTTP_OK);
//        return null;
//    }

    public function responseSuccessData($res)
    {
        return $this->successResponse($res, \Illuminate\Http\Response::HTTP_OK);
    }

//    public function responseErrorData($response)
//    {
//        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
//            $errMessage = json_decode($response->getBody()->getContents(), true);
//            return $this->errorResponse($errMessage['messages'] ?? null, $response->getStatusCode());
//        }
//        return null;
//    }
    public function responseErrorData($response)
    {
        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $errMessage = json_decode($response->getBody()->getContents(),true);

            $err = isset($errMessage) && array_key_exists('messages',$errMessage) ? $errMessage['messages'] : '';
            return response()->json([
                "messages" => $err,
            ], $response->getStatusCode());


        }
        return null;
    }
}
