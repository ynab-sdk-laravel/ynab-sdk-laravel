<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

use Illuminate\Support\Carbon;

final class Category extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/Categories/getCategories
     */
    public function list(string $budgetId, ?int $lastKnowledgeOfServer = null)
    {
        $url = "/budgets/$budgetId/categories";

        if (isset($lastKnowledgeOfServer)) {
            $url .= "?last_knowledge_of_server=$lastKnowledgeOfServer";
        }

        return $this->client->get($url);
    }

    /**
     * @link https://api.ynab.com/v1#/Categories/getCategoryById
     */
    public function get(string $budgetId, string $categoryId)
    {
        return $this->client->get("/budgets/$budgetId/categories/$categoryId");
    }

    /**
     * @link https://api.ynab.com/v1#/Categories/updateCategory
     */
    public function update(
        string $budgetId,
        string $categoryId,
        ?string $name,
        ?string $note,
        string $category_group_id,
    ) {
        return $this->client->patch(
            "/budgets/$budgetId/categories/$categoryId",
            compact('name', 'note', 'category_group_id')
        );
    }

    /**
     * @link https://api.ynab.com/v1#/Categories/getMonthCategoryById
     */
    public function getForBudgetMonth(
        string $budgetId,
        Carbon|string $month,
        string $categoryId,
    ) {
        if ($month instanceof Carbon) {
            $month = $month->format('Y-m-d');
        }

        return $this->client->get("/budgets/$budgetId/months/$month/categories/$categoryId");
    }

    /**
     * @link https://api.ynab.com/v1#/Categories/updateMonthCategory
     */
    public function updateForBudgetMonth(
        string $budgetId,
        Carbon|string $month,
        string $categoryId,
        int $budgeted,
    ) {
        if ($month instanceof Carbon) {
            $month = $month->format('Y-m-d');
        }

        return $this->client->patch("/budgets/$budgetId/months/$month/categories/$categoryId", compact('budgeted'));
    }
}
