<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class actions extends Model
{
    use HasFactory;

   protected $table = "react";
   public $fillable = ["react_like" , "user_id" , "reels_id"];

   public $timestamps = false ;

   public $hidden = ['id' , 'react_like' , 'user_id' , 'reels_id'];

   public function user(){
    return $this->belongsTo(User::class , 'user_id' , 'id');
   }

   public function reels(){
    return $this->belongsTo(posts::class , 'reels_id' , 'id');
   }
}
