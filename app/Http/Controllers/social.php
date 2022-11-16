<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use  Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Auth;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;

class social extends Controller
{
    use GeneralTrait;
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback(Request $request) :JsonResponse
    {
        try {
            $validation = $this->validation_google_token($request->all());

            if($validation->fails()){
                return $this->catchTheError(validation: $validation);
            }

            $user = Socialite::driver('google')->userFromToken($request->Token);

            $token = Auth::guard('api')->attempt(['email' => $user->email , 'password' => 'password']);

            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){
                return $this->loginRespones(user: $finduser , token: $token);
            }

            $create_google_user =  User::CreateUser(request: $user);

            return $this->loginRespones(user: $user->user , token: $token);

        } catch (Exception $e) {
            return $this->returnError(errorNumber:'', msg: 'Invalid Credentials');
        }
    }

    private function validation_google_token($request){
        $ruels = ['Token'=>'required|string'];
        return validator::make($request, $ruels);
    }

    public function handlefacebookCallback(Request $request){
        try{
            $validation = validator::make($request->all() , ['token' => 'required|string']);
            if($validation->fails()){
                return $this->catchTheError(validation: $validation);
            }
            $user = Socialite::driver('facebook')->userFromToken($request->token);


            $token = Auth::guard('api')->attempt(['email' => $user->email , 'password' => 'password']);

            $finduser = User::where('facebook_id', $user->id)->first();
            if($finduser){
                return $this->loginRespones(user: $finduser , token: $token);
            }

            $create_google_user =  User::CreateUser(request: $user);

            return $this->loginRespones(user: $user->user , token:$token);
        }catch(Exception $e){
            return $this->returnError(errorNumber:'', msg: 'Invalid Credentials');
        }

    }




}
