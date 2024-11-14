<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use YnabSdkLaravel\YnabSdkLaravel\Ynab;

describe('gets a list of transactions', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/transactions?last_knowledge_of_server=0&since_date=2021-01-01&type=uncategorized';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->list('default', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with carbon since date', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->list('default', Carbon::parse('2021-01-01'), 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->list('default', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('creates one or more transactions', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/transactions';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->createSingleOrMultiple('default', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->createSingleOrMultiple('default', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('updates multiple transactions', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/transactions';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->updateMultiple('default', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->updateMultiple('default', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('imports transactions', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/transactions/import';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->import('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->import('default');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('get a transaction', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/transactions/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->get('default', '123', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->get('default', '123', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('update a transaction', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/transactions/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->update('default', '123', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->update('default', '123', []);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('delete a transaction', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/transactions/123';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->delete('default', '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->delete('default', '123');

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a list of transactions for account', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/accounts/test/transactions?last_knowledge_of_server=0&since_date=2021-01-01&type=uncategorized';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForAccount('default', 'test', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with carbon since date', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForAccount('default', 'test', Carbon::parse('2021-01-01'), 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForAccount('default', 'test', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a list of transactions for category', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/categories/test/transactions?last_knowledge_of_server=0&since_date=2021-01-01&type=uncategorized';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForCategory('default', 'test', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with carbon since date', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForCategory('default', 'test', Carbon::parse('2021-01-01'), 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForCategory('default', 'test', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a list of transactions for payee', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/payees/test/transactions?last_knowledge_of_server=0&since_date=2021-01-01&type=uncategorized';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForPayee('default', 'test', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with carbon since date', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForPayee('default', 'test', Carbon::parse('2021-01-01'), 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForPayee('default', 'test', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});

describe('gets a list of transactions for month', function () {
    beforeEach(function () {
        $this->mockedUrl = '*/budgets/default/months/2021-01-01/transactions?last_knowledge_of_server=0&since_date=2021-01-01&type=uncategorized';
    });

    it('succeeds', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForMonth('default', '2021-01-01', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('succeeds with carbon since date', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 200),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForMonth('default', Carbon::parse('2021-01-01'), Carbon::parse('2021-01-01'), 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(200);
    });

    it('fails', function () {
        Http::fake([
            $this->mockedUrl => Http::response($this->json, 500),
        ]);

        $result = (new Ynab('test123'))->transactions()->listForMonth('default', '2021-01-01', '2021-01-01', 'uncategorized', 0);

        expect($result->json())->toEqual($this->json)->and($result->status())->toBe(500);
    });
});
