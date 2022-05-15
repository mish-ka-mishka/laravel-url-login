<?php

namespace UrlLogin\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use UrlLogin\Providers\UrlLoginServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            UrlLoginServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.driver', 'url_login_eloquent');
    }
}
