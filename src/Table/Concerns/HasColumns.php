<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

use Illuminate\Support\Str;
use InvalidArgumentException;
use JAOcero\LaravelInertiaTable\Table\Columns\Column;

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
        $columnQuery = [];

        foreach ($this->columns as $column) {
            if ($column instanceof Column || is_subclass_of($column, Column::class)) {
                $columnQuery[] = [
                    'name' => $column->getName(),
                    'label' => $column->getLabel(),
                    'date' => [
                        'format' => method_exists($column, 'getFormat') ? $column->getFormat() : null,
                        'timezone' => method_exists($column, 'getTimezone') ? $column->getTimezone() : null,
                    ],
                    'searchable' => [
                        'enabled' => method_exists($column, 'isSearchable') ? $column->isSearchable() : null,
                        'debounce' => method_exists($column, 'getDebounce') ? $column->getDebounce() : null,
                    ],
                ];
            } else {
                throw new InvalidArgumentException('Table column must be an instance of '.Column::class.'.');
            }
        }

        return $columnQuery;
    }

    public function getColumnLabels(): array
    {
        $columnLabels = [];

        foreach ($this->columns as $column) {
            $parts = explode('.', $column->getName());
            $columnName = array_pop($parts);
            $label = Str::replace('.', ' ', $column->getLabel() ?? $columnName);
            $columnLabels[$column->getName()] = Str::title(Str::replace('_', ' ', $label));
        }

        return $columnLabels;
    }
}
