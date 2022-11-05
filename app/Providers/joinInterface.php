<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class joinInterface extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(JWTSubject::class , User::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
