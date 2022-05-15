<?php

namespace UrlLogin\Tests;

use Illuminate\Support\Facades\Auth;
use UrlLogin\Providers\UrlLoginEloquentUserProvider;

class UrlLoginServiceProviderTest extends TestCase
{
    public function testAuthProviderIsInstanceOfUrlLoginServiceProvider()
    {
        $this->assertInstanceOf(
            UrlLoginEloquentUserProvider::class,
            Auth::guard()->getProvider()
        );
    }
}
