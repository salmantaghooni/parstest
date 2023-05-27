<?php
namespace SalmanTaghooni\Account\Http\Controllers\Api\V02\Account;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SalmanTaghooni\Account\Http\Controllers\ApiController;
use SalmanTaghooni\Account\Services\Account\Interfaces\CheckInformationPersonServiceInterface;

class CheckInformationPersonController extends ApiController
{
    protected CheckInformationPersonServiceInterface $checkInformationPersonService;
    public function __construct(CheckInformationPersonServiceInterface $checkInformationPersonServiceInterface)
    {
        $this->checkInformationPersonService = $checkInformationPersonServiceInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $basicInfo = $this->checkInformationPersonService->index();
        return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $basicInfo = $this->checkInformationPersonService->store($request);
        return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $basicInfo = $this->checkInformationPersonService->update($request);
        return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
    }
//    public function responseSuccessData($res): JsonResponse
//    {
//        return $this->successResponse($res, Response::HTTP_OK);
//    }
//    public function responseErrorData($response): ?JsonResponse
//    {
//        if (is_null($response->getStatusCode()) || $response->getStatusCode() != 200)
//            return $this->errorResponse("سرور قادر به پاسخگویی نیست", Response::HTTP_OK);
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
