<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

use Illuminate\Support\Facades\Http;

class Ynab
{
    protected $client;

    public function __construct(
        protected string $accessToken,
    ) {
        $this->client = Http::withToken($accessToken)->baseUrl(config('ynab-sdk-laravel.base_url'));
    }

    public function user(): User
    {
        return new User($this->client);
    }

    public function budgets(): Budget
    {
        return new Budget($this->client);
    }

    public function accounts(): Account
    {
        return new Account($this->client);
    }

    public function categories(): Category
    {
        return new Category($this->client);
    }

    public function payees(): Payee
    {
        return new Payee($this->client);
    }

    public function payeeLocations(): PayeeLocation
    {
        return new PayeeLocation($this->client);
    }

    public function months(): Month
    {
        return new Month($this->client);
    }

    public function transactions(): Transaction
    {
        return new Transaction($this->client);
    }

    public function scheduledTransactions(): ScheduledTransaction
    {
        return new ScheduledTransaction($this->client);
    }
}
