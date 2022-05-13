<?php

namespace UrlLogin\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class UrlLoginServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/url-login.php', 'url-login.php');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/url-login.php' => config_path('url-login.php'),
        ], 'config');

        Auth::provider('url_login_eloquent', function ($app, array $config) {
            return new UrlLoginEloquentUserProvider(
                $config['url-login']['auth_token_hash'],
                $this->app['hash'],
                $config['model']
            );
        });
    }
}
