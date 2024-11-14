<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

final class PayeeLocation extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/Payee%20Locations/getPayeeLocations
     */
    public function list(string $budgetId)
    {
        return $this->client->get("/budgets/{$budgetId}/payee_locations");
    }

    /**
     * @link https://api.ynab.com/v1#/Payee%20Locations/getPayeeLocationById
     */
    public function get(string $budgetId, string $payeeLocationId)
    {
        return $this->client->get("/budgets/{$budgetId}/payee_locations/{$payeeLocationId}");
    }

    /**
     * @link https://api.ynab.com/v1#/Payee%20Locations/getPayeeLocationsByPayee
     */
    public function listForPayee(string $budgetId, string $payeeId)
    {
        return $this->client->get("/budgets/{$budgetId}/payees/{$payeeId}/payee_locations");
    }
}
