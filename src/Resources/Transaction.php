<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

use Illuminate\Support\Carbon;

final class Transaction extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/Transactions/getTransactions
     */
    public function list(
        string $budgetId,
        Carbon|string|null $sinceDate = null,
        ?string $type = null,
        ?int $lastKnowledgeOfServer = null
    ) {
        $url = "/budgets/{$budgetId}/transactions";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server={$lastKnowledgeOfServer}";
        }

        if ($sinceDate instanceof Carbon) {
            $url .= '&since_date='.$sinceDate->format('Y-m-d');
        } elseif (isset($sinceDate)) {
            $url .= '&since_date='.$sinceDate;
        }

        if (isset($type)) {
            $url .= '&type='.$type;
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/createTransaction
     */
    public function createSingleOrMultiple(string $budgetId, array $data)
    {
        return $this->client->post("/budgets/$budgetId/transactions", $data);
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/updateTransactions
     */
    public function updateMultiple(string $budgetId, array $data)
    {
        return $this->client->patch("/budgets/$budgetId/transactions", $data);
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/importTransactions
     */
    public function import(string $budgetId)
    {
        return $this->client->post("/budgets/$budgetId/transactions/import");
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/getTransactionById
     */
    public function get(string $budgetId, string $transactionId)
    {
        return $this->client->get("/budgets/$budgetId/transactions/$transactionId");
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/updateTransaction
     */
    public function update(string $budgetId, string $transactionId, array $data)
    {
        return $this->client->put("/budgets/$budgetId/transactions/$transactionId", $data);
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/deleteTransaction
     */
    public function delete(string $budgetId, string $transactionId)
    {
        return $this->client->delete("/budgets/$budgetId/transactions/$transactionId");
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/getTransactionsByAccount
     */
    public function listForAccount(
        string $budgetId,
        string $accountId,
        Carbon|string|null $sinceDate = null,
        ?string $type = null,
        ?int $lastKnowledgeOfServer = null
    ) {
        $url = "/budgets/{$budgetId}/accounts/{$accountId}/transactions";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server={$lastKnowledgeOfServer}";
        }

        if ($sinceDate instanceof Carbon) {
            $url .= '&since_date='.$sinceDate->format('Y-m-d');
        } elseif (isset($sinceDate)) {
            $url .= '&since_date='.$sinceDate;
        }

        if (isset($type)) {
            $url .= '&type='.$type;
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/getTransactionsByCategory
     */
    public function listForCategory(
        string $budgetId,
        string $categoryId,
        Carbon|string|null $sinceDate = null,
        ?string $type = null,
        ?int $lastKnowledgeOfServer = null
    ) {
        $url = "/budgets/{$budgetId}/categories/{$categoryId}/transactions";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server={$lastKnowledgeOfServer}";
        }

        if ($sinceDate instanceof Carbon) {
            $url .= '&since_date='.$sinceDate->format('Y-m-d');
        } elseif (isset($sinceDate)) {
            $url .= '&since_date='.$sinceDate;
        }

        if (isset($type)) {
            $url .= '&type='.$type;
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/getTransactionsByPayee
     */
    public function listForPayee(
        string $budgetId,
        string $payeeId,
        Carbon|string|null $sinceDate = null,
        ?string $type = null,
        ?int $lastKnowledgeOfServer = null
    ) {
        $url = "/budgets/{$budgetId}/payees/{$payeeId}/transactions";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server={$lastKnowledgeOfServer}";
        }

        if ($sinceDate instanceof Carbon) {
            $url .= '&since_date='.$sinceDate->format('Y-m-d');
        } elseif (isset($sinceDate)) {
            $url .= '&since_date='.$sinceDate;
        }

        if (isset($type)) {
            $url .= '&type='.$type;
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Transactions/getTransactionsByMonth
     */
    public function listForMonth(
        string $budgetId,
        Carbon|string $month,
        Carbon|string|null $sinceDate = null,
        ?string $type = null,
        ?int $lastKnowledgeOfServer = null
    ) {
        if ($month instanceof Carbon) {
            $month = $month->format('Y-m-d');
        }

        $url = "/budgets/{$budgetId}/months/{$month}/transactions";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server={$lastKnowledgeOfServer}";
        }

        if ($sinceDate instanceof Carbon) {
            $url .= '&since_date='.$sinceDate->format('Y-m-d');
        } elseif (isset($sinceDate)) {
            $url .= '&since_date='.$sinceDate;
        }

        if (isset($type)) {
            $url .= '&type='.$type;
        }

        return $this->client->get($url);
    }
}
