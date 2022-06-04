<?php

namespace UrlLogin\Tests;

use Illuminate\Database\Eloquent\Model;
use UrlLogin\Traits\AuthenticatesViaUrl;

class AuthenticatesWithUrlTest extends TestCase
{
    public function testCreateUrlLoginToken()
    {
        $model = new class extends Model {
            use AuthenticatesViaUrl;
        };

        $model->id = 1;

        $tokenInfo = $model->createUrlLoginToken();

        $this->assertIsArray($tokenInfo);
        $this->assertArrayHasKey('public_id', $tokenInfo);
        $this->assertArrayHasKey('token', $tokenInfo);
        $this->assertArrayHasKey('expires_at', $tokenInfo);
    }
}
