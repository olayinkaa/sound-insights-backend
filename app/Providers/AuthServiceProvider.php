<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(now()->addSeconds(30));
        Passport::refreshTokensExpireIn(now()->addDays(2));
        //

        Passport::tokensCan([
            'create-mp3' => 'Create new mp3 record',
            'update-mp3' => 'Edit existing mp3 record',
            'delete-mp3' => 'remove existing mp3 record',
            'create-aboutus'=>'Create new about us content',
            'update-aboutus'=>'Edit exsiting about us content',
            'delete-aboutus'=>'Delete existing about us content'
        ]);
    }
}
