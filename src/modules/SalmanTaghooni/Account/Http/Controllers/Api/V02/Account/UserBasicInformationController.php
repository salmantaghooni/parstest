<?php
namespace SalmanTaghooni\Account\Http\Controllers\Api\V02\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SalmanTaghooni\Account\Http\Controllers\ApiController;
use SalmanTaghooni\Account\Services\Account\Interfaces\UserBasicInformationServiceInterface;

class UserBasicInformationController extends ApiController
{
    protected UserBasicInformationServiceInterface $userBasicInformationService;
    public function __construct(UserBasicInformationServiceInterface $userBasicInformationService)
    {
        $this->userBasicInformationService = $userBasicInformationService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $basicInfo = $this->userBasicInformationService->index();
        return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $basicInfo = $this->userBasicInformationService->store($request);
        return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $basicInfo = $this->userBasicInformationService->update($request);
        return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
    }

//    public function responseSuccessData($res): \Illuminate\Http\JsonResponse
//    {
//        return $this->successResponse($res, Response::HTTP_OK);
//    }
//    public function responseErrorData($response): ?\Illuminate\Http\JsonResponse
//    {
//        if (is_null($response->getStatusCode()) || $response->getStatusCode() != 200)
//            return $this->errorResponse("سرور قادر به پاسخگویی نیست", Response::HTTP_INTERNAL_SERVER_ERROR);
//        return null;
//    }

    public function responseSuccessData($res)
    {
        return $this->successResponse($res, Response::HTTP_OK);
    }

    public function responseErrorData($response)
    {
        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 201) {
            $errMessage = json_decode($response->getBody()->getContents(), true);
            return $this->errorResponse($errMessage['messages'] ?? null, $response->getStatusCode());
        }
        return null;
    }

}
