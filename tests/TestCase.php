<?php

namespace YnabSdkLaravel\YnabSdkLaravel\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use YnabSdkLaravel\YnabSdkLaravel\YnabSdkLaravelServiceProvider;

class TestCase extends Orchestra
{
    protected ?array $json = null;

    public static $latestResponse = null;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'YnabSdkLaravel\\YnabSdkLaravel\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            YnabSdkLaravelServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $app->setBasePath(__DIR__.'/..');

        /*
        $migration = include __DIR__.'/../database/migrations/create_ynab-sdk-laravel_table.php.stub';
        $migration->up();
        */
    }
}
