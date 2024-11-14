<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Resources;

use Illuminate\Http\Client\PendingRequest;

class Resource
{
    public function __construct(
        protected PendingRequest $client,
    ) {}
}
