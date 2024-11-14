<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Events\AccessTokenRetrieved;

class YnabCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->missing('code')) {
            abort(400, 'Authorization code is required');
        }

        $query = [
            'client_id' => config('ynab-sdk-laravel.client.id'),
            'client_secret' => config('ynab-sdk-laravel.client.secret'),
            'redirect_uri' => route(config('ynab-sdk-laravel.oauth.base_name').'.callback'),
            'grant_type' => 'authorization_code',
            'code' => $request->query('code'),
        ];

        $query = http_build_query($query);

        $ynabRequest = Http::post("https://app.ynab.com/oauth/token?$query")->throw();

        $afterCallback = config('ynab-sdk-laravel.redirect_to.after_callback');

        $redirectTo = config('ynab-sdk-laravel.redirect_to.use_route_names', true) ? route($afterCallback) : $afterCallback;

        if ($ynabRequest->json('access_token')) {
            AccessTokenRetrieved::dispatch($ynabRequest->json(), now());

            return redirect($redirectTo)->with('success', 'Access token retrieved');
        } else {
            return redirect($redirectTo)->with('error', 'Failed to get access token');
        }
    }
}
