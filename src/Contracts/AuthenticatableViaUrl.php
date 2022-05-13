<?php

namespace UrlLogin\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthenticatableViaUrl extends Authenticatable
{
    public function getAuthTokenHash(): string;
}
