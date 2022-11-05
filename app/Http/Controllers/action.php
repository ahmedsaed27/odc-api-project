<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\actions;
use App\Models\comments;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Exception;

class action extends Controller
{
    use GeneralTrait;

    /////////////////////////////////////////     make a like      \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    public function like(Request $requset) :JsonResponse{ // if ha have a like he will make unlike
       if(Gate::allows('isUser')){

            $rules = ['reels_id' => 'required|numeric'];

            $validation = Validator::make($requset->all() , $rules);

            if($validation->fails()){
                return $this->catchTheError(validation: $validation);
            }

            return $this->cheackTheLike($requset->reels_id);
       }
       return  $this->returnError(errorNumber:'' , msg:'only user can make like');
    }

    private function unlike($post_id) :JsonResponse{
        actions::where('id' , $post_id)->delete();
        return $this->returnSuccessMessage(erorrNumber:'' , msg:'react delated');
    }


    private function storeLike($reels_id) :JsonResponse{

        $creatLike = actions::create([
            'react_like' => 1 ,
            'user_id' => auth()->user()->id,
            'reels_id' => $reels_id
        ]);

        if($creatLike){
            return $this->likeResponse(reels_id: $reels_id);
        }
        return  $this->returnError(errorNumber:'' , msg:'Data dose not saved');
    }


    private function cheackTheLike($requset) :JsonResponse{
        $like = actions::where('user_id' , auth()->user()->id)->where('reels_id' , $requset)->first();
            if($like){
                return $this->unlike(post_id: $like->id);
            }
        return $this->storeLike(reels_id: $requset);
    }

    /////////////////////////////////////////     make a Comment       \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    public function comment(Request $requset) :JsonResponse{ // make comment
        if(Gate::allows('isUser')){
            $rules = ['reels_id' => 'required|numeric' , 'comment' => 'required|string'];

            $validation = Validator::make($requset->all() , $rules);

            if($validation->fails()){
                return $this->catchTheError(validation: $validation);
            }

            return $this->storeComment(reels_id: $requset->reels_id , comment: $requset->comment);
        }
        return  $this->returnError(errorNumber:'' , msg:'only user can make like');
    }


    private function storeComment($reels_id , $comment) :JsonResponse{

        try{
            $comment = comments::create([
                'user_id' => auth()->user()->id,
                'reels_id' => $reels_id,
                'comment' => $comment
            ]);

            return $this->returnSuccessMessage(erorrNumber:'', msg:'comment saved');

        }catch(Exception $e){
            return $this->returnError(errorNumber:'' , msg:'post not found');
        }

    }
    



}
