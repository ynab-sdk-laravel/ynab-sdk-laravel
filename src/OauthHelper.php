<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel;

use Illuminate\Support\Carbon;

final class OauthHelper
{
    public static function getAuthUrl()
    {
        $query = http_build_query([
            'client_id' => config('ynab-sdk-laravel.client.id'),
            'redirect_uri' => route(config('ynab-sdk-laravel.oauth.base_name').'.callback'),
            'response_type' => config('ynab-sdk-laravel.response_type'),
        ]);

        return "https://app.ynab.com/oauth/authorize?$query";
    }

    public static function getExpirationTimeOfAccessToken(Carbon $dateRetrieved, int $expiresIn): Carbon
    {
        return Carbon::createFromTimestamp($dateRetrieved->getTimestamp() + $expiresIn);
    }
}
