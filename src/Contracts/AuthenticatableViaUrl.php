<?php

namespace UrlLogin\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

/** @see \UrlLogin\Traits\AuthenticatesViaUrl */
interface AuthenticatableViaUrl extends Authenticatable
{
    public function getAuthTokenHash(): string;

    public function generateUrlAuthToken(): string;
}
