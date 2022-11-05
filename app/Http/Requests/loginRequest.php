<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;



class loginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if(\request()->routeIs('register')){
            $name = 'required|string';
            $unique = 'email|required|string|unique:users';
        }elseif(request()->routeIs('login')){
            $name = 'nullable';
            $unique = 'email|required|string';
        }
        return [
            'email' =>  $unique,
            'password' => 'required|string',
            'name' => $name
        ];
    }


    public function messages()
    {
        return [
            'email.required' => 'this input:email is required',
            'email.unique'=> 'this input:email must be unique',
            'password.required' => 'this input:password is required',
            'name.required'=> 'this input:name is required'
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'status' => false,

            'message' => 'Validation errors',

            'data' => $validator->errors()

        ]));

    }


}
