<?php

namespace UrlLogin\Tests;

use UrlLogin\Providers\UrlLoginEloquentUserProvider;
use UrlLogin\Traits\AuthenticatesViaUrl;

class AuthenticatesWithUrlTest extends TestCase
{
    public function testCreateUrlLoginToken()
    {
        $model = $this->getMockForTrait(AuthenticatesViaUrl::class, [], 'FakeClassName', false);
        $model->id = 1;

        $tokenInfo = $model->createUrlLoginToken();

        $this->assertIsArray($tokenInfo);
        $this->assertArrayHasKey('public_id', $tokenInfo);
        $this->assertArrayHasKey('token', $tokenInfo);
        $this->assertArrayHasKey('expires_at', $tokenInfo);
    }
}
