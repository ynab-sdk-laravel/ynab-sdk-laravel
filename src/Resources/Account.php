<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

final class Account extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/Accounts/getAccounts
     */
    public function list(string $budgetId, ?int $lastKnowledgeOfServer = null)
    {
        $url = "/budgets/$budgetId/accounts";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server=$lastKnowledgeOfServer";
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Accounts/createAccount
     */
    public function create(string $budgetId, string $name, string $type, int $balance)
    {
        return $this->client->post("/budgets/$budgetId/accounts", compact('name', 'type', 'balance'));
    }

    /**
     * @link https://api.ynab.com/v1#/Accounts/getAccountById
     */
    public function get(string $budgetId, string $accountId)
    {
        return $this->client->get("/budgets/$budgetId/accounts/$accountId");
    }
}
