<?php

namespace UrlLogin\Providers;

use Illuminate\Support\ServiceProvider;

class UrlLoginServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/url-login.php', 'url-login');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/url-login.php' => config_path('url-login.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
