<?php

namespace YnabSdkLaravel\YnabSdkLaravel;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use YnabSdkLaravel\YnabSdkLaravel\Http\Controllers\YnabCallbackController;
use YnabSdkLaravel\YnabSdkLaravel\Http\Controllers\YnabRefreshController;

class YnabSdkLaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('ynab-sdk-laravel')
            ->hasConfigFile();
    }

    public function packageRegistered()
    {
        Route::macro('ynabSdkLaravelOauth', function () {
            $baseUrl = config('ynab-sdk-laravel.oauth.base_url');
            $baseName = config('ynab-sdk-laravel.oauth.base_name').'.';

            Route::prefix($baseUrl)->name($baseName)->group(function () {
                Route::get('/callback', YnabCallbackController::class)->name('callback');
                Route::get('/refresh', YnabRefreshController::class)->name('refresh');
            });
        });
    }
}
