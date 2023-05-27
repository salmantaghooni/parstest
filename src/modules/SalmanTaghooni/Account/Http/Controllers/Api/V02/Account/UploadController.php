<?php

namespace SalmanTaghooni\Account\Http\Controllers\Api\V02\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use SalmanTaghooni\Account\Http\Controllers\ApiController;
use SalmanTaghooni\Account\Services\Account\Interfaces\UploadServiceInterface;
use Intervention\Image\Facades\Image;

class UploadController extends ApiController
{
    protected UploadServiceInterface $uploadServiceInterface;

    public function __construct(UploadServiceInterface $uploadServiceInterface)
    {
        $this->uploadServiceInterface = $uploadServiceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $basicInfo = $this->uploadServiceInterface->index();
        return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->hasFile('front_image')) {

            $pic =$request->file('front_image');
            $request->front_image = file_get_contents($request->file('front_image'));
            if ($request->file('back_image'))
                $request->back_image = file_get_contents($request->file('back_image'));


            $request->front_image = base64_decode(str_replace(' ', '+', str_replace('data:image/'.$pic->getClientOriginalExtension().';base64,', '', $request->front_image)));
            if ($request->file('back_image'))
                $request->back_image = base64_decode(str_replace(' ', '+', str_replace('data:image/'.$pic->getClientOriginalExtension().';base64,', '', $request->back_image)));

            $f= uniqid('', false);
            if ($request->file('back_image'))
                $b= uniqid('', false);
            else
                $b=false;

            //$request->query->add($f,$f);
            //$request->query->add($b,$b);

            $myRequest = new \Illuminate\Http\Request($request->all());
            $myRequest = $myRequest->merge(['f'=>$f,"b"=>$b,"type_file"=>"jpg"]);


            foreach($request->headers->all() as $key=>$value){
                $myRequest->headers->set($key, $value);
            }


            Image::make($request->front_image)->encode('jpg', 40)->resize(700,800)

                ->save(storage_path('app/').$f. "." ."jpg");


            if ($request->hasFile('back_image'))
                Image::make($request->back_image)->encode('jpg', 40)->resize(700,800)

                    ->save(storage_path('app/').$b. "."."jpg");

//            Storage::put($f.'.'.$pic->getClientOriginalExtension(),$request->frontImage);
//            if ($request->hasFile('backImage'))
//                Storage::put($b.'.'.$pic->getClientOriginalExtension(),$request->backImage);

            $this->uploadServiceInterface->setHeader($myRequest);
            $basicInfo = $this->uploadServiceInterface->store($myRequest);
            return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
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

                $f = uniqid('', false);
                $b = uniqid('', false);

                //$request->query->add($f,$f);
                //$request->query->add($b,$b);

                $myRequest = new \Illuminate\Http\Request($request->all());
                $myRequest = $myRequest->merge(['f' => $f, "b" => $b, "type_file" => $pic->getClientOriginalExtension()]);


                foreach ($request->headers->all() as $key => $value) {
                    $myRequest->headers->set($key, $value);
                }

                Image::make($request->frontImage)->encode('jpg', 40)->resize(700,800)

                    ->save(storage_path('app').$f. "."."jpg");
                Image::make($request->backImage)->encode('jpg', 40)->resize(700,800)

                    ->save(storage_path('app').$b. "."."jpg");

                $this->uploadServiceInterface->setHeader($myRequest);
                $basicInfo = $this->uploadServiceInterface->update($myRequest);
                return $this->responseErrorData($basicInfo) ?? $this->responseSuccessData(json_decode($basicInfo->getBody()->getContents()));
            }
        }
    }

//    public function responseSuccessData($res): \Illuminate\Http\JsonResponse
//    {
//        return $this->successResponse($res, Response::HTTP_OK);
//    }
//    public function responseErrorData($response): ?\Illuminate\Http\JsonResponse
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
