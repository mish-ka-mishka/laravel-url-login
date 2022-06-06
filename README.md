# Laravel url login

This package enables support for authentication with one-time secret url.
## Installation

Run the following command from your project directory to add the dependency:

```shell
composer require mkaverin/laravel-url-login
```

Then, run database migrations:

```shell
php artisan migrate
```

### Laravel without auto-discovery

If you don't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`:

```php
'providers' => [
    ...
    UrlLogin\Providers\UrlLoginServiceProvider::class,
],
```

## Configuration

You can copy the package config with the publish command:

```shell
php artisan vendor:publish --provider="UrlLogin\Providers\UrlLoginServiceProvider"
```

You can find published config in `config/url-login.php`.

## Usage

### Preparing your model

The model you want to use for authentication should use the `AuthenticatesViaUrl` trait. 
It provides the `createUrlLoginToken` method and `urlAuthTokens()` relation.

### Using UrlAuthController

`UrlAuthController` shipped with this package is an abstract controller that provides 
authenticate() and logout() methods. You can use it as a base for your own controller:

```php
<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use UrlLogin\Http\Controllers\UrlAuthController;

class AdminAuthController extends UrlAuthController
{
    protected function getAuthGuardName(): string
    {
        return 'admin';
    }

    protected function isNeededToRemember(Request $request, Authenticatable $user): bool
    {
        return $request->has('remember') && $request->input('remember') === 'true';
    }
}
```

#### Customizing authentication guard

This package uses default authentication guard, but you can use any guard you like by 
overriding the `getAuthGuardName()` or `getAuthGuard()` method in your `UrlAuthController`.

#### Remembering users

If you would like to provide "remember me" functionality in your application, you may use the
`isNeededToRemember()` method. This method accepts authentication request and retrieved
user model so you can determine if the user should be remembered.

## Testing

```shell
composer test
```
