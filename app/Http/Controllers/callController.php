<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Artisan;

class callController extends Controller
{

    public function __invoke()
    {
       $seed =  Artisan::call('db:seed');
       return \redirect('/');
    }
}
