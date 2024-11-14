<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

final class Budget extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/Budgets/getBudgets
     */
    public function list(?bool $include_accounts = null)
    {
        $url = '/budgets';

        if (isset($include_accounts)) {
            $include_accounts = $include_accounts ? 'true' : 'false';

            $url .= "?include_accounts=$include_accounts";
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Budgets/getBudgetById
     */
    public function get(string $budgetId, ?int $lastKnowledgeOfServer = null)
    {
        $url = "/budgets/$budgetId";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server=$lastKnowledgeOfServer";
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Budgets/getBudgetSettingsById
     */
    public function settings(string $budgetId)
    {
        return $this->client->get("/budgets/$budgetId/settings");
    }
}
