<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use App\Models\posts as post;
use Auth;
use Exception;


class posts extends Controller
{
    use GeneralTrait;

    public function uplodeReel(Request $reqeust) :JsonResponse{
        if(Gate::allows('role') == false){

            $validation = $this->reel_validation($reqeust->all());

            if($validation->fails()){
                return $this->catchTheError(validation: $validation);
            }

            $uploade_reel_and_get_theName = $this->moveReel(reel: $reqeust->file('reel'));

            $new_Reel = $this->createReel(caption: $reqeust->caption , name: $uploade_reel_and_get_theName);

            if($new_Reel && $uploade_reel_and_get_theName){
                return $this->returnSuccessMessage(erorrNumber:'' , msg: 'uploded succsess');
            }

            return $this->returnError(errorNumber:'' , msg: 'filed to add reel');
        }
        return  $this->returnError(errorNumber:'' , msg:'only user can make like');
    }

    private function createReel($caption , $name) :post{
        $createReel = post::create([
            'reel' => $name,
            'caption' => $caption,
            'user_id'=> auth()->user()->id
        ]);
        return $createReel;
    }


    private function moveReel($reel){
        $reel_tmp = $reel->getRealPath();
        $reel_Extension = $reel->getClientOriginalExtension();
        $reel_name = time().".".$reel_Extension;
        if(!file_exists(public_path('video'))){
            mkdir(public_path('video'));
        }
        move_uploaded_file($reel_tmp , public_path('video/'.$reel_name));
        return $name = $reel_name;
    }

    private function reel_validation($requestAll){
        $rules = ['reel'=>'required|file|mimes:mp4','caption'=>'required|string'];
        return validator::make($requestAll , $rules);
    }


    public function allData() :array
    {
        $postsData['posts'] = post::with(['userWhoCreateThePost' , 'comments' => function($q){
            $q->select('reels_id'  , 'comment' , 'user_id');
        },'react'])->withcount('react')->get();

        return $postsData;
    }



    public function deleteReel(Request $reqeust) :JsonResponse
    {
        try{
            $validation = Validator::make($reqeust->all() , ['reels_id' => 'required|numeric']);

            if($validation->fails()){
                return $this->catchTheError(validation: $validation);
            }

            $id = post::findOrFail($reqeust->reels_id);
            $imgPath = \public_path("video/$id->reel");

            if(\file_exists($imgPath)){
                \unlink($imgPath);
            }

            $id->delete();
            return $this->returnSuccessMessage(erorrNumber:'' , msg: 'reel deleted sucsses');
        }catch(Exception $e){
            return  $this->returnError(errorNumber:'' , msg:'cant find this post');
        }
    }










}
