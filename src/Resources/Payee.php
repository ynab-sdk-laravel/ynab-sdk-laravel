<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

final class Payee extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/Payees/getPayees
     */
    public function list(string $budgetId, ?int $lastKnowledgeOfServer = null)
    {
        $url = "/budgets/{$budgetId}/payees";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server={$lastKnowledgeOfServer}";
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Payees/getPayeeById
     */
    public function get(string $budgetId, string $payeeId)
    {
        return $this->client->get("/budgets/{$budgetId}/payees/{$payeeId}");
    }

    /**
     * @link https://api.ynab.com/v1#/Payees/updatePayee
     */
    public function update(string $budgetId, string $payeeId, string $name)
    {
        return $this->client->patch("/budgets/{$budgetId}/payees/{$payeeId}", compact('name'));
    }
}
