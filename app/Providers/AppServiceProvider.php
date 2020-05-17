<?php

namespace App\Providers;

use App\User;
use App\Mail\UserCreated;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        User::created(function($user){
            Mail::to($user)->send(new UserCreated($user));
        });
    }
}
