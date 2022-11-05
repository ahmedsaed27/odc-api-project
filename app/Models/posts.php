<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class posts extends Model
{
    use HasFactory;
    protected $table = "reels";

    public $fillable = ['reel' , 'caption' , 'user_id' , 'reel_id'];

    public $timestamps = false;

    protected $casts = [
        'reel' => 'encrypted'
    ];


    public function comments()
    {
        return $this->hasMany(comments::class , 'reels_id' , 'id')->with('user');
    }

    public function userWhoCreateThePost(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function react(){
        return $this->hasMany(actions::class , 'reels_id' , 'id')->with('user');
    }

}
