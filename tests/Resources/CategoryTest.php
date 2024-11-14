<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Ynab;

describe('gets a list of categories', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/categories';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->categories()->list('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with last knowledge of server', function () {
        Http::fake([
            $this->mockedUrl.'?last_knowledge_of_server=0' => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->categories()->list('default', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->categories()->list('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a category', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/categories/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->categories()->get('default', '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->categories()->get('default', '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('updates a category', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/categories/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->categories()->update('default', '123', 'Test', 'Note', '456');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->categories()->update('default', '123', 'Test', 'Note', '456');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a category for a budget month', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/months/2024-01-01/categories/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->categories()->getForBudgetMonth('default', Carbon::parse('2024-01-01'), '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->categories()->getForBudgetMonth('default', Carbon::parse('2024-01-01'), '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('updates a category for a budget month', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/months/2024-01-01/categories/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->categories()->updateForBudgetMonth('default', Carbon::parse('2024-01-01'), '123', 1000);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->categories()->updateForBudgetMonth('default', Carbon::parse('2024-01-01'), '123', 1000);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});
