<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class User extends Authenticatable implements JWTSubject{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'email_verified_at',
        'google_id',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'updated_at',
        'created_at',
        'google_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeCreateUser($query , $request){
        if(request()->routeIs('admin')){
            $role = 1;
        }

        if(isset($request->password)){
            $password = bcrypt($request->password);
        }

        $password = bcrypt('password');
        $role = 0;
        
        $user = $query->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'email_verified_at'=>date('Y-m-d h:i:s'),
            'remember_token'=>\bcrypt(rand(10000,100000000)),
            'google_id' => $request->id,
            'role' => $role
        ]);
        return $user;
    }


    public function comments()
    {
        return $this->hasMany(comments::class, 'user_id', 'id');
    }

    public function react(){
        return $this->hasMany(actions::class, 'user_id', 'id');
    }

    public function post(){
        return $this->hasMany(posts::class, 'user_id', 'id');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [];
    }

}
