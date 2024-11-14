<?php

namespace YnabSdkLaravel\YnabSdkLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \YnabSdkLaravel\YnabSdkLaravel\Ynab
 *
 * @codeCoverageIgnore
 */
class Ynab extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \YnabSdkLaravel\YnabSdkLaravel\Ynab::class;
    }
}
