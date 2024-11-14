<?php

use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Ynab;

describe('gets a list of scheduled transactions', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/scheduled_transactions';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->scheduledTransactions()->list('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with last knowledge of server', function () {
        Http::fake([
            $this->mockedUrl.'?last_knowledge_of_server=0' => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->scheduledTransactions()->list('default', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->scheduledTransactions()->list('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('creates a scheduled transaction', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/scheduled_transactions';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->scheduledTransactions()->create('default', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->scheduledTransactions()->create('default', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a scheduled transaction', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/scheduled_transactions/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->scheduledTransactions()->get('default', '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->scheduledTransactions()->get('default', '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});
