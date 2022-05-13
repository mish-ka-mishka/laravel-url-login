<?php

namespace UrlLogin\Providers;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Str;
use UrlLogin\Contracts\AuthenticatableViaUrl;

class UrlLoginEloquentUserProvider extends EloquentUserProvider implements UserProvider
{
    private string $authTokenHashKey;

    public function __construct(string $authTokenKey, HasherContract $hasher, $model)
    {
        $this->authTokenHashKey = $authTokenKey;

        parent::__construct($hasher, $model);
    }

    public function retrieveByCredentials(array $credentials): ?AuthenticatableViaUrl
    {
        $credentials = array_filter(
            $credentials,
            function ($key) {
                return !Str::contains($key, $this->authTokenHashKey);
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
            if (Str::contains($key, $this->authTokenHashKey)) {
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
        $plain = $credentials[$this->authTokenHashKey];

        // TODO validate expiration date

        return $this->hasher->check($plain, $user->getAuthPassword());
    }
}
