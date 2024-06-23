<?php

namespace JAOcero\LaravelInertiaTable;

use JAOcero\LaravelInertiaTable\Commands\LaravelInertiaTableCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelInertiaTableServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-inertia-table')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-inertia-table_table')
            ->hasCommand(LaravelInertiaTableCommand::class);
    }
}
