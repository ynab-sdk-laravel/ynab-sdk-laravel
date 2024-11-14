<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

use Illuminate\Support\Carbon;

final class Month extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/Months/getBudgetMonths
     */
    public function list(string $budgetId, ?int $lastKnowledgeOfServer = null)
    {
        $url = "/budgets/{$budgetId}/months";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server={$lastKnowledgeOfServer}";
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Months/getBudgetMonth
     */
    public function get(string $budgetId, Carbon|string $month)
    {
        if ($month instanceof Carbon) {
            $month = $month->format('Y-m-d');
        }

        return $this->client->get("/budgets/{$budgetId}/months/{$month}");
    }
}
