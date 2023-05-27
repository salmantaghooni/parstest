<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtTokenMiddleware extends JwtTokenMiddleware
{

   
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function setJwtToken($jwtToken)
    {
        if ($jwtToken !== null)
            JWTAuth::setToken($jwtToken);
    }


    // public function terminate( $request, $res)

    // {
    //     var_dump($this->jwtToken);
    //     if ($this->jwtToken !== null)
    //         JWTAuth::setToken($this->jwtToken); //<-- set token and check

    // }
}
