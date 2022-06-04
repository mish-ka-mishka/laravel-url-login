<?php

namespace UrlLogin\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase as Orchestra;
use UrlLogin\Providers\UrlLoginServiceProvider;

class TestCase extends Orchestra
{
    use DatabaseMigrations;

    protected function getPackageProviders($app): array
    {
        return [
            UrlLoginServiceProvider::class,
        ];
    }
}
