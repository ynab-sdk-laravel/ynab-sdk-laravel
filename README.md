# YNAB SDK for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ynab-sdk-laravel/ynab-sdk-laravel.svg?style=flat-square)](https://packagist.org/packages/ynab-sdk-laravel/ynab-sdk-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ynab-sdk-laravel/ynab-sdk-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ynab-sdk-laravel/ynab-sdk-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/ynab-sdk-laravel/ynab-sdk-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ynab-sdk-laravel/ynab-sdk-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ynab-sdk-laravel/ynab-sdk-laravel.svg?style=flat-square)](https://packagist.org/packages/ynab-sdk-laravel/ynab-sdk-laravel)

## Introduction

The YNAB SDK for Laravel provides an expressive interface for interacting with YNAB's API within a Laravel application.

## Installation

You can install the package via composer:

```bash
composer require ynab-sdk-laravel/ynab-sdk-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="ynab-sdk-laravel-config"
```

This is the contents of the published config file:

```php
return [
    'base_url' => 'https://api.ynab.com/v1',
    'client' => [
        'id' => env('YNAB_SDK_LARAVEL_CLIENT_ID'),
        'secret' => env('YNAB_SDK_LARAVEL_CLIENT_SECRET'),
    ],
    'oauth' => [
        'base_url' => env('YNAB_SDK_LARAVEL_OAUTH_BASE_URL', 'ynab-oauth'),
        'base_name' => env('YNAB_SDK_LARAVEL_OAUTH_BASE_NAME', 'ynab-oauth'),
    ],
    'response_type' => env('YNAB_SDK_LARAVEL_RESPONSE_TYPE', 'code'),
    'redirect_to' => [
        'use_route_names' => env('YNAB_SDK_LARAVEL_REDIRECT_TO_USE_ROUTE_NAMES', true),
        'after_callback' => env('YNAB_SDK_LARAVEL_REDIRECT_TO_AFTER_CALLBACK', 'home'),
        'after_refresh' => env('YNAB_SDK_LARAVEL_REDIRECT_TO_AFTER_REFRESH', 'home'),
    ]
];
```

## Usage

### Personal Access Tokens

You can enter a personal access token directly (see: https://api.ynab.com/#personal-access-tokens).

```php
use YnabSdkLaravel\YnabSdkLaravel\Ynab;

$ynab = new Ynab('insert-access-token-here');
```

This class exposes 9 resource methods for accessing YNAB's API (see: https://api.ynab.com/v1).

-   `$ynab->user()`
-   `$ynab->budgets()`
-   `$ynab->accounts()`
-   `$ynab->categories()`
-   `$ynab->payees()`
-   `$ynab->payeeLocations()`
-   `$ynab->months()`
-   `$ynab->transactions()`
-   `$ynab->scheduledTransactions()`

Each method within its resource aligns with an endpoint:

```php
<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

final class User extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/User/getUser
     */
    public function get()
    {
        return $this->client->get('/user');
    }
}
```

### Oauth

Oauth authentication must be used for applications that accept access tokens from other users (see: https://api.ynab.com/#oauth-applications).

#### Auth Url

The Auth Url can be retrieved with the `OauthHelper` class.

```php
use YnabSdkLaravel\YnabSdkLaravel\OauthHelper;

OauthHelper::getAuthUrl();
```

The auth url uses the following configuration parameters:

```php
[
    'client_id' => config('ynab-sdk-laravel.client.id'),
    'redirect_uri' => route(config('ynab-sdk-laravel.oauth.base_name').'.callback'),
    'response_type' => config('ynab-sdk-laravel.response_type'),
]
```

With the following parameters:

-   `client_id=123`
-   `redirect_uri=https://my-app.com/ynab-oauth/callback`
-   `response_type=code`

The auth url should be the following: https://app.ynab.com/oauth/authorize?client_id=123&redirect_uri=https%3A%2F%2Fmy-app.com%2Fynab-oauth%2Fcallback&response_type=code

When you click on the link, you should be sent to a YNAB page asking you to authorize.

The route used in the `redirect_uri` should be equal to the Callback Route you register via the package.

#### Callback Route

##### Registring the Route

A configurable route macro is registered by the package.

Place `Route::ynabSdkLaravelOauth();` in your routes file to instantiate it. By default, the url should look like this: `https://your-site.com/ynab-oauth/callback`.

You can configure the `$baseUrl` and `$baseName` in the `.env` like so:

```
YNAB_SDK_LARAVEL_OAUTH_BASE_URL='my-ynab-oauth'
YNAB_SDK_LARAVEL_OAUTH_BASE_NAME='my-ynab-oauth'
```

The route should then look like this: `https://your-site.com/my-ynab-oauth/callback`.

The second variable is for the name, such that you can access the route using something like `redirect()->route(config('ynab-sdk-laravel.oauth.base_name') . '.callback')`.

##### Accessing the Controller

The controller builds the route that is used to authenticate with YNAB. Here are the components:

```php
$query = [
    'client_id' => config('ynab-sdk-laravel.client.id'),
    'client_secret' => config('ynab-sdk-laravel.client.secret'),
    'redirect_uri' => route(config('ynab-sdk-laravel.oauth.base_name').'.callback'),
    'grant_type' => $request->query('grant_type', 'authorization_code'),
    'code' => $request->query('code'),
];

$query = http_build_query($query);

$ynabRequest = Http::post("https://app.ynab.com/oauth/token?$query")->throw();

$afterCallback = config('ynab-sdk-laravel.redirect_to.after_callback');

$redirectTo = config('ynab-sdk-laravel.redirect_to.use_route_names', true) ? route($afterCallback) : $afterCallback;
```

Other than the config variables, everything else can be left as is.

If the request is successful, the `AccessTokenRetrieved` event is dispatched. It accepts the following values:

-   The response JSON array comprised of: `access_token`, `token_type`, `expires_in`, `refresh_token`
-   A Carbon representing the current date time, which is used (in conjunction with `expires_in`) to determine when the `access_token` will expire

Create a listener for the event to interact with the data.

> [!IMPORTANT]
> Also, the controller uses a config (`ynab-sdk-laravel.redirect_to.after_callback`), which is "home" by default.
> 
> The config (`ynab-sdk-laravel.redirect_to.use_route_names`) dictates that the aformentioned config variable should be treated as a route name.
> 
> You may set it to false if you want to the literal route path.
> 
> If you make no changes, then the route name "home" is where the controller will be redirected to. If you do not register a route that is named "home" in your app, the controller will fail with a 500 error.

Once you have the `access_token`, you can access the API the way you would with a personal access token:

```php
use YnabSdkLaravel\YnabSdkLaravel\Ynab;

$ynab = new Ynab('insert-access-token-here');
```

Be wary that your `access_token` has an expiration date (i.e., `expires_in`). You may track when your token is expiring and then use `refresh_token` to reset your `access_token` without the user having to authenticate on YNAB again.

#### Refresh Route

##### Registering the Route

When you place `Route::ynabSdkLaravelOauth();` in your routes file, you also expose the refresh route. By default, the url should look like this: `https://your-site.com/ynab-oauth/refresh`.

This is, of course, configurable (see: [Callback Route Registration](#registring-the-route)).

##### Accessing the Controller

The controller accepts a `refresh_token` value and then calls YNAB to get a new access token given the information.

If successful, `AccessTokenRetrieved` is dispatched to expose the new `access_token`, `expires_in`, and `refresh_token` as well as the time retrieved so that you can determine when to refresh the token again.

##### When To Refresh The Token

The `OauthHelper` class provides a handy method to calculate the time when the token expires.

```php
use YnabSdkLaravel\YnabSdkLaravel\OauthHelper;

// ...

OauthHelper::getExpirationTimeOfAccessToken($dateRetrieved, $expiresIn);
```

The method takes the values which are exposed by the `AccessTokenRetrieved` event that runs when initially retrieving or refreshing the access token.

## Running Tests

To run tests, run the following command:

```bash
composer test
```

You may run tests with coverage:

```bash
composer test-coverage
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Daniel Haven](https://github.com/danielh-official)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
