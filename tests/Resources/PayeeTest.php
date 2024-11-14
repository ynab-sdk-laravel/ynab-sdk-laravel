<?php

use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Ynab;

describe('gets a list of payees', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/payees';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->payees()->list('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with last knowledge of server', function () {
        Http::fake([
            $this->mockedUrl.'?last_knowledge_of_server=0' => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->payees()->list('default', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->payees()->list('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a payee', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/payees/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->payees()->get('default', '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->payees()->get('default', '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('updates a payee', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/payees/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->payees()->update('default', '123', 'Test');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->payees()->update('default', '123', 'Test');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});
