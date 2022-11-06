<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\social;
use App\Http\Controllers\posts;
use App\Http\Controllers\action;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/








Route::middleware(['chekAPI'])->group(function () {
    Route::post('register',[AuthController::class , 'register'])->name('register'); // register and make jwt token
    Route::post('login', [AuthController::class , 'login'])->name('login'); // login and make jwt token
    Route::post('google/auth/callback', [social::class, 'handleGoogleCallback']); // login with google
});



Route::middleware(['AssignGuard'])->group(function () {
    Route::post('admin/rigster', [adminController::class , 'adminRigster'])->name('admin'); // add admin role == 1
    Route::post('logout', [AuthController::class , 'logout']); // logout and bloced the token
    Route::post('carate/reel' , [posts::class , 'uplodeReel']); // make reel
    Route::get('refresh' , [AuthController::class , 'refresh']); // refreshTheToken and make new token
    Route::post('like' , [action::class , 'like']); // make like
    Route::post('comment' , [action::class , 'comment']); // make comment
    Route::get('posts' , [posts::class , 'allData']); // get all Posts
    Route::post('delete/reel' , [posts::class , 'deleteReel']); // delete reel
});










