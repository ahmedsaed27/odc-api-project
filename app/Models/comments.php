<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class comments extends Model
{
    use HasFactory;
    protected $table = "comments";
    public $timestamps = false;
    public $fillable = ['user_id' , 'reels_id' , 'comment'];
    public $hidden = ['user_id' , 'reels_id'];







   public function reels(): BelongsTo
   {
       return $this->belongsTo(posts::class , 'reels_id' , 'id');
   }

   public function user(): BelongsTo
   {
        return $this->belongsTo(User::class , 'user_id' , 'id');
   }



}
