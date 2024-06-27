<?php

namespace JAOcero\ViltTable\Table\Columns;

use JAOcero\ViltTable\Table\Concerns\CanBeSearchable;
use JAOcero\ViltTable\Table\Concerns\CanFormatState;
use JAOcero\ViltTable\Table\Concerns\HasLabel;
use JAOcero\ViltTable\Table\Concerns\HasName;

class Column
{
    use CanBeSearchable;
    use CanFormatState;
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
