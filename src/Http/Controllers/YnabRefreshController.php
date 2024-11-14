<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Events\AccessTokenRetrieved;

class YnabRefreshController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->missing('refresh_token')) {
            abort(400, 'Refresh token is required');
        }

        $query = [
            'client_id' => config('ynab-sdk-laravel.client.id'),
            'client_secret' => config('ynab-sdk-laravel.client.secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->query('refresh_token'),
        ];

        $query = http_build_query($query);

        $ynabRequest = Http::post("https://app.ynab.com/oauth/token?$query")->throw();

        $afterRefresh = config('ynab-sdk-laravel.redirect_to.after_refresh');

        $redirectTo = config('ynab-sdk-laravel.redirect_to.use_route_names', true) ? route($afterRefresh) : $afterRefresh;

        if ($ynabRequest->json('access_token')) {
            AccessTokenRetrieved::dispatch($ynabRequest->json(), now());

            return redirect($redirectTo)->with('success', 'New access token retrieved');
        } else {
            return redirect($redirectTo)->with('error', 'Failed to get new access token');
        }
    }
}
