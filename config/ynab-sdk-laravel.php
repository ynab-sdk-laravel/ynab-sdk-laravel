<?php

// config for YnabSdkLaravel/YnabSdkLaravel
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
    ],
];
