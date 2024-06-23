<?php

namespace JAOcero\LaravelInertiaTable\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use JAOcero\LaravelInertiaTable\LaravelInertiaTableServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'JAOcero\\LaravelInertiaTable\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelInertiaTableServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-inertia-table_table.php.stub';
        $migration->up();
        */
    }
}
