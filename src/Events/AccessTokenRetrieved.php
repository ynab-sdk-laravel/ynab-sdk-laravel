<?php

declare(strict_types=1);

namespace YnabSdkLaravel\YnabSdkLaravel\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class AccessTokenRetrieved
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public array $data,
        public Carbon $retrievedAt,
    ) {}
}
