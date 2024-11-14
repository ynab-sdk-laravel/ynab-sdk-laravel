<?php

use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Ynab;

beforeEach(function () {
    $this->mockedUrl = '*/user';
});

it('gets a user', function () {
    Http::fake([
        $this->mockedUrl => Http::response($this->json, 200),
    ]);

    $result = (new Ynab('test123'))->user()->get();

    expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
});

it('fails to get a user', function () {
    Http::fake([
        $this->mockedUrl => Http::response($this->json, 500),
    ]);

    $result = (new Ynab('test123'))->user()->get();

    expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
});
