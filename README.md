# Laravel url login

This package extends Laravel’s EloquentUserProvider to support authentication with one-time secret url.

## Installation

Run the following command from your project directory to add the dependency:

```shell
composer require mkaverin/laravel-url-login
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

Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="UrlLogin\Providers\UrlLoginServiceProvider"
```

You can find published config in `config/url-login.php`.

## Testing

```shell
composer test
```
