<?php

namespace SalmanTaghooni\Auth\Traits;


trait ApiResponser
{
    public function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    public function errorResponse($message, $code)
    {
        return response()->json([
            "code" => $code ,
            "messages" => $message,
        ], $code);
    }
}
