<?php

namespace UrlLogin\Contracts;

use DateTimeInterface;
use Illuminate\Contracts\Auth\Authenticatable;

/** @see \UrlLogin\Traits\AuthenticatesViaUrl */
interface AuthenticatableViaUrl extends Authenticatable
{
    public function getAuthTokenHash(): ?string;

    public function getAuthTokenExpire(): ?DateTimeInterface;

    public function generateUrlAuthToken(): string;

    public function invalidateUrlAuthToken(): bool;
}
