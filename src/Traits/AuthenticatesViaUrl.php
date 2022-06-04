<?php

namespace UrlLogin\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use UrlLogin\Models\UrlLoginToken;

trait AuthenticatesViaUrl
{
    public function urlAuthTokens(): MorphMany
    {
        return $this->morphMany(UrlLoginToken::class, 'tokenable');
    }

    public function createUrlLoginToken(): array
    {
        $token = Str::random(config('url-login.auth_token_length'));

        $urlLoginToken = new UrlLoginToken();
        $urlLoginToken->tokenable()->associate($this);
        $urlLoginToken->expires_at = now()->addMinutes(config('url-login.auth_token_lifetime'));
        $urlLoginToken->token = Hash::make($token);
        $urlLoginToken->save();

        return [
            'public_id' => $urlLoginToken->public_id,
            'token' => $token,
            'expires_at' => $urlLoginToken->expires_at,
        ];
    }
}
