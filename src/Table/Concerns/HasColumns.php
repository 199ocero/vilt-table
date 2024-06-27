<?php

namespace JAOcero\ViltTable\Table\Concerns;

use InvalidArgumentException;
use JAOcero\ViltTable\Table\Columns\Column;

trait HasColumns
{
    protected array $columns = [];

    public function columns(array $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function getColumns(): array
    {
        $columns = [];

        foreach ($this->columns as $column) {
            if ($column instanceof Column || is_subclass_of($column, Column::class)) {
                $columns[] = $column;
            } else {
                throw new InvalidArgumentException('Table column must be an instance of '.$column::class);
            }
        }

        return $columns;
    }
}
