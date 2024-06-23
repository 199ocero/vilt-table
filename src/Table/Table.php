<?php

namespace JAOcero\LaravelInertiaTable\Table;

use JAOcero\LaravelInertiaTable\Table\Concerns\CanFormatDate;
use JAOcero\LaravelInertiaTable\Table\Concerns\HasColumns;
use JAOcero\LaravelInertiaTable\Table\Concerns\HasDescription;
use JAOcero\LaravelInertiaTable\Table\Concerns\HasEmptyState;
use JAOcero\LaravelInertiaTable\Table\Concerns\HasHeading;
use JAOcero\LaravelInertiaTable\Table\Concerns\HasPagination;

class Table
{
    use CanFormatDate;
    use HasColumns;
    use HasDescription;
    use HasEmptyState;
    use HasHeading;
    use HasPagination;

    public function __construct() {}

    public static function make(): static
    {
        $static = app(static::class);

        return $static;
    }
}
