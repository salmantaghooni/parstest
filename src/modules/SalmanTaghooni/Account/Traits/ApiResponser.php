<?php

namespace SalmanTaghooni\Account\Traits;


trait ApiResponser
{
    public function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    public function errorResponse($message,$code)
    {
        return response()->json([
            "messages" => $message,
        ], $code);
    }
}