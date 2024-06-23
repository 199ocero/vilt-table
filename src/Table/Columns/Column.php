<?php

namespace JAOcero\LaravelInertiaTable\Table\Columns;

use JAOcero\LaravelInertiaTable\Table\Concerns\CanBeSearchable;
use JAOcero\LaravelInertiaTable\Table\Concerns\HasLabel;
use JAOcero\LaravelInertiaTable\Table\Concerns\HasName;

class Column
{
    use CanBeSearchable;
    use HasLabel;
    use HasName;

    public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);

        return $static;
    }
}
