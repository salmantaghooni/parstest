<?php
namespace SalmanTaghooni\Account\Http\Controllers\Api\V02\Account;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use SalmanTaghooni\Account\Http\Controllers\ApiController;
use SalmanTaghooni\Account\Services\Account\Interfaces\UploadServiceInterface;

class UploadVideoController extends ApiController
{
    protected UploadServiceInterface $uploadServiceInterface;
    public function __construct(UploadServiceInterface $uploadServiceInterface)
    {
        $this->uploadServiceInterface = $uploadServiceInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $basicInfo = $this->uploadServiceInterface->index();
        return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->file('front_image')) {

            $pic = $request->file('front_image');
//
//
//            if ($request->hasFile('frontImage')) {
//                $request->frontImage = file_get_contents($request->file('frontImage'));
//                if ($request->hasFile('backImage'))
//                    $request->backImage = file_get_contents($request->file('backImage'));
//
//

            $f = uniqid('', false);
            $b = false;




            $myRequest = new \Illuminate\Http\Request($request->all());


            foreach ($request->headers->all() as $key => $value) {
                $myRequest->headers->set($key, $value);
            }


            // $data = Storage::put($f . '.' . $pic->getClientOriginalExtension(), $request->frontImage);

            $file = $request->file('front_image');

            $path = storage_path('');
            $file->move($path, $f .'.mp4');

            $myRequest = $myRequest->merge(['f' => $f, "b" => $b, "type_file" => 'mp4']);

//                $compressedVideo = cloudinary()->upload($data2->getRealPath(), [
//                    'folder' => public_path(''),
//                    'transformation' => [
//                        'quality' => 60,
//                        'width' => 800,
//                        'height' => 700
//                    ]
//                ])->getSecurePath(public_path().$b . '.' . $pic->getClientOriginalExtension());
//
//                Storage::put($f . '.' . $pic->getClientOriginalExtension(), $request->frontImage);
//                if ($request->hasFile('backImage'))
//                    Storage::put($b . '.' . $pic->getClientOriginalExtension(), $request->backImage);


            $this->uploadServiceInterface->setHeader($myRequest);
            $basicInfo = $this->uploadServiceInterface->store($myRequest);
            return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id,Request $request)
    {
        $pic = $request->frontImage;
        if ($request->frontImage) {




            if ($request->frontImage) {
                $request->frontImage = file_get_contents($request->frontImage);
                if ($request->backImage)
                    $request->backImage = file_get_contents($request->backImage);


                $request->frontImage = base64_decode(str_replace(' ', '+', str_replace('data:image/' . $pic->getClientOriginalExtension() . ';base64,', '', $request->frontImage)));
                if ($request->backImage)
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
                if ($request->backImage)
                    Storage::put($b . '.' . $pic->getClientOriginalExtension(), $request->backImage);

                $this->uploadServiceInterface->setHeader($myRequest);
                $basicInfo = $this->uploadServiceInterface->update($myRequest);
                return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
            }
        }
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
