<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Http\Requests\loginRequest;
use Illuminate\Http\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(loginRequest $request) :JsonResponse{

        $validation = $request->validated();

        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);

        if (!$token) {
            return $this->returnError(errorNumber:'' , msg:'this email or password is failed');
        }

        $user = Auth::guard('api')->user();

        return $this->loginRespones(user: $user , token: $token);
    }

    public function register(loginRequest $request) :JsonResponse{

        $validation = $request->validated();

        $user = User::createUser($request);

        $token = Auth::guard('api')->login($user);

        if($token){
            return $this->regsterResponse(user: $user , token: $token);
        }

        return  $this->returnError(errorNumber:'' , msg:'data dose not seved');
    }


    public function logout() :JsonResponse
    {
        auth()->logout(true);
        return $this->returnSuccessMessage(erorrNumber:'' , msg: 'Successfully logged out');
    }


    public function refresh(){
        try{
            $token = JWTAuth::getToken();
            $newToken = JWTAuth::refresh($token);
            return  $this->refreshTheToken(token: $newToken);
        }catch(Exception $e){
            return $this->returnError(erorrNumber:'' , msg: $e->getMessage());
        }

    }





}
