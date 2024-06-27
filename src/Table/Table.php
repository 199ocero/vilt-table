<?php

namespace JAOcero\ViltTable\Table;

use JAOcero\ViltTable\Table\Concerns\CanFormatDate;
use JAOcero\ViltTable\Table\Concerns\HasColumns;
use JAOcero\ViltTable\Table\Concerns\HasDescription;
use JAOcero\ViltTable\Table\Concerns\HasEmptyState;
use JAOcero\ViltTable\Table\Concerns\HasHeading;
use JAOcero\ViltTable\Table\Concerns\HasPagination;

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
