<?php

namespace App\Services\Instagram;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class InstagramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(InstagramApi::class, function ($app) {
            return new SpatieInstagramApi($app->make(Client::class));
        });
    }
}
