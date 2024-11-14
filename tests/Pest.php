<?php

use Illuminate\Support\Facades\Route;
use YnabSdkLaravel\YnabSdkLaravel\Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(function () {
        Route::ynabSdkLaravelOauth();

        Route::get('/', function () {
            return 'Hello World';
        })->name('home');
    })
    ->in(__DIR__);
