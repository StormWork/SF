<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\InstagramApi;

/**
 * Service provider to provide a singleton of the InstagramApi class
 */
class InstagramServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(InstagramApi::class, function(){
            return new InstagramApi(config('services.instagram.client_id'), config('services.instagram.client_secret'), config('services.instagram.redirect'));
        });
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
