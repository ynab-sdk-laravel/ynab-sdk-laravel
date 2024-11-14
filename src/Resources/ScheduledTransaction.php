<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

final class ScheduledTransaction extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/Scheduled%20Transactions/getScheduledTransactions
     */
    public function list(string $budgetId, ?int $lastKnowledgeOfServer = null)
    {
        $url = "/budgets/$budgetId/scheduled_transactions";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server=$lastKnowledgeOfServer";
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Scheduled%20Transactions/createScheduledTransaction
     */
    public function create(string $budgetId, array $data)
    {
        return $this->client->post("/budgets/$budgetId/scheduled_transactions", $data);
    }

    /**
     * @link https://api.ynab.com/v1#/Scheduled%20Transactions/getScheduledTransactionById
     */
    public function get(string $budgetId, string $scheduledTransactionId)
    {
        return $this->client->get("/budgets/$budgetId/scheduled_transactions/$scheduledTransactionId");
    }
}
