<?php

namespace JAOcero\LaravelInertiaTable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JAOcero\LaravelInertiaTable\LaravelInertiaTable
 */
class LaravelInertiaTable extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JAOcero\LaravelInertiaTable\LaravelInertiaTable::class;
    }
}
