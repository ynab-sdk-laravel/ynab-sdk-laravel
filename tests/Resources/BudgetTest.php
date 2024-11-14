<?php

use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Ynab;

describe('gets a list of budgets', function () {
    beforeEach(function () {
        $this->json = null;
        $this->mockedUrl = '*/budgets';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->budgets()->list();

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with include accounts', function () {
        Http::fake([
            $this->mockedUrl.'?include_accounts=true' => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->budgets()->list(true);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->budgets()->list();

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a budget', function () {
    beforeEach(function () {
        $this->json = null;
        $this->mockedUrl = '*/budgets/default';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->budgets()->get('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with last knowledge of server', function () {
        Http::fake([
            $this->mockedUrl.'?last_knowledge_of_server=0' => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->budgets()->get('default', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->budgets()->get('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets settings for a budget', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/settings';
        $this->json = null;
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->budgets()->settings('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response(status: 500),
        ]);

        $result = (new Ynab('test123'))->budgets()->settings('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});
