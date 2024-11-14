<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

final class User extends Resource
{
    /**
     * @link https://api.ynab.com/v1#/User/getUser
     */
    public function get()
    {
        return $this->client->get('/user');
    }
}
