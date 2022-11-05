<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;



class adminController extends Controller
{
    use GeneralTrait;
    public function adminRigster(Request $request):JsonResponse{

        $ruels = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ];

        $validation = Validator::make($request->all() , $ruels);

        if($validation->fails()){
            return $this->catchTheError($validation);
        }

        $user = User::CreateUser($request);

        return $this->returnSuccessMessage(erorrNumber:'' , msg: 'Admin Created Succsesfully');

    }


}
