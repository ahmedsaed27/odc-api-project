<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class permation
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
        $token  = JWTAuth::parseToken()->authenticate();
        if($token){
            if(auth()->user()->role == 0){
                return \response()->json(['stutes' => 'false' , 'msg' => 'you cant reach this page']);
            }
            return $next($request);
        }
    }
}
