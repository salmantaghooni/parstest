<?php

use Illuminate\Support\Facades\Cache;

if(! function_exists('cacheRequestId')){
    function cacheRequestId($tk,$result){
        $result=json_decode($result->getBody()->getContents());
        if(Cache::has($tk['phoneNumber'])){
            Cache::forget($tk['phoneNumber']);
            Cache::put($tk['phoneNumber'],$result->response->requestId,now()->addMinutes(20));
            return true;
        }
        Cache::put($tk['phoneNumber'],$result->response->requestId,now()->addMinutes(20));
        return true;
    }
}


?>