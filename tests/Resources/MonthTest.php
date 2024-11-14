<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Ynab;

describe('gets a list of months', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/months';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->months()->list('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with last knowledge of server', function () {
        Http::fake([
            $this->mockedUrl.'?last_knowledge_of_server=0' => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->months()->list('default', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->months()->list('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a month', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/months/2024-01-01';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->months()->get('default', Carbon::parse('2024-01-01'));

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->months()->get('default', Carbon::parse('2024-01-01'));

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});
