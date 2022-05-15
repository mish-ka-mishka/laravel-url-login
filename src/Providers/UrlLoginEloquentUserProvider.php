<?php

namespace UrlLogin\Providers;

use Closure;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use UrlLogin\Contracts\AuthenticatableViaUrl;

class UrlLoginEloquentUserProvider extends EloquentUserProvider implements UserProvider
{
    public function retrieveByCredentials(array $credentials): ?AuthenticatableViaUrl
    {
        $credentials = array_filter(
            $credentials,
            function ($key) {
                return ! Str::contains($key, config('url-login.model_parameters.auth_token_hash'));
            },
            ARRAY_FILTER_USE_KEY
        );

        if (empty($credentials)) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in an
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (Str::contains($key, config('url-login.model_parameters.auth_token_hash'))) {
                continue;
            }

            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } elseif ($value instanceof Closure) {
                $value($query);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    /**
     * Validate a user against the given credentials.
     */
    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        $expire = $user->getAuthTokenExpire();

        if (now() > $expire) {
            return false;
        }

        $plain = $credentials[config('url-login.model_parameters.auth_token_hash')];

        return $this->hasher->check($plain, $user->getAuthTokenHash());
    }
}
