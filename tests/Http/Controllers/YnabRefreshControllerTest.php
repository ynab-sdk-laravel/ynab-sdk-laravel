<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Events\AccessTokenRetrieved;

use function Pest\Laravel\get;

it('gets an access token using authorization code grant flow', function () {
    Event::fake();

    Carbon::setTestNow(Carbon::parse('2021-01-01 00:00:00'));

    Config::set('ynab-sdk-laravel.client.id', 'client-id');
    Config::set('ynab-sdk-laravel.client.secret', 'client-secret');

    $route = 'https://app.ynab.com/oauth/token?client_id=client-id&client_secret=client-secret&grant_type=refresh_token&refresh_token=refresh_token';

    Http::fake([
        $route => Http::response([
            'access_token' => 'access_token',
            'refresh_token' => 'refresh_token',
            'expires_in' => 10000,
        ]),
    ]);

    get(route('ynab-oauth.refresh', [
        'refresh_token' => 'refresh_token',
    ]))->assertRedirect(route('home'))->assertSessionHas('success', 'New access token retrieved');

    Event::assertDispatched(AccessTokenRetrieved::class, function (AccessTokenRetrieved $event) {
        return $event->data === [
            'access_token' => 'access_token',
            'refresh_token' => 'refresh_token',
            'expires_in' => 10000,
        ] && $event->retrievedAt->isToday();
    });
});

it('fails to get an access token using authorization code grant flow', function () {
    Event::fake();

    Config::set('ynab-sdk-laravel.client.id', 'client-id');
    Config::set('ynab-sdk-laravel.client.secret', 'client-secret');

    $route = 'https://app.ynab.com/oauth/token?client_id=client-id&client_secret=client-secret&grant_type=refresh_token&refresh_token=refresh_token';

    Http::fake([
        $route => Http::response([
            'access_token' => '',
        ]),
    ]);

    get(route('ynab-oauth.refresh', [
        'refresh_token' => 'refresh_token',
    ]))->assertRedirect(route('home'))->assertSessionHas('error', 'Failed to get new access token');

    Event::assertNotDispatched(AccessTokenRetrieved::class);
});

it('is missing refresh token', function () {
    Event::fake();

    Config::set('ynab-sdk-laravel.client.id', 'client-id');
    Config::set('ynab-sdk-laravel.client.secret', 'client-secret');

    get(route('ynab-oauth.refresh'))->assertBadRequest();

    Event::assertNotDispatched(AccessTokenRetrieved::class);

    Http::assertNothingSent();
});
