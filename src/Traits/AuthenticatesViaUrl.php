<?php

namespace UrlLogin\Traits;

use DateTimeInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @see \UrlLogin\Contracts\AuthenticatableViaUrl */
trait AuthenticatesViaUrl
{
    public function initializeAuthenticatesViaUrl()
    {
        $this->hidden[] = config('url-login.model_parameters.auth_token_hash');
        $this->casts[config('url-login.model_parameters.auth_token_expire')] = 'datetime';
    }

    public function getAuthTokenHash(): ?string
    {
        return $this->{config('url-login.model_parameters.auth_token_hash')};
    }

    public function getAuthTokenExpire(): ?DateTimeInterface
    {
        return $this->{config('url-login.model_parameters.auth_token_expire')};
    }

    public function generateUrlAuthToken(): string
    {
        $token = Str::random(config('url-login.auth_token_length'));

        $this->{config('url-login.model_parameters.auth_token_hash')} = Hash::make($token);
        $this->{config('url-login.model_parameters.auth_token_expire')} = now()->addMinutes(config('url-login.model_parameters.auth_token_lifetime'));
        $this->save();

        return $token;
    }

    public function invalidateUrlAuthToken(): bool
    {
        $this->{config('url-login.model_parameters.auth_token_hash')} = null;
        $this->{config('url-login.model_parameters.auth_token_expire')} = null;

        return $this->save();
    }
}
