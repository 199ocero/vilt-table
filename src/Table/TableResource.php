<?php

namespace JAOcero\LaravelInertiaTable\Table;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use JAOcero\LaravelInertiaTable\Table\Concerns\CanFormatDate;
use JAOcero\LaravelInertiaTable\Table\Contracts\HasTable;

class TableResource implements HasTable
{
    use CanFormatDate;

    protected ?string $model = null;

    protected Table $table;

    public function __construct()
    {
        $this->table = Table::make();
    }

    public static function make(): static
    {
        $static = app(static::class);

        return $static;
    }

    public function table(): Table
    {
        return $this->table;
    }

    protected function prepareResourceRecords(): LengthAwarePaginator
    {
        $query = $this->getResourceModel();

        $filters = $this->getFilters();

        $columns = $this->table()->getColumns();

        $this->resolveNestedColumns($columns, $query, $filters['search']);

        $paginator = $query->paginate($filters['perPage'], ['*'], 'page', $filters['page']);

        if ($paginator->isEmpty() && $filters['page'] > 1) {
            $paginator = $query->paginate($filters['perPage'], ['*'], 'page', 1);
        }

        return $paginator
            ->onEachSide($filters['onEachSide'])
            ->withQueryString()
            ->through(fn ($item) => $this->getTransformedItems($item, $columns));
    }

    protected function getResourceModel(): Builder
    {
        if (! $this->model) {
            throw new ModelNotFoundException('Model not found for resource '.get_class($this));
        }

        return $this->model::query();
    }

    protected function getFilters(): array
    {
        return [
            'search' => request()->input('search', ''),
            'perPage' => request()->input('perPage', 10),
            'page' => request()->input('page', 1),
            'onEachSide' => 0,
        ];
    }

    protected function getTransformedItems($item, array $columns): array
    {
        $transformedItem = [];

        foreach ($columns as $column) {

            if (str_contains($column['name'], '.')) {

                [$relation, $relationColumn] = explode('.', $column['name']);

                $value = data_get($item, $relation.'.'.$relationColumn);
            } else {

                $value = $item->{$column['name']};
            }

            if ($column['date'] && $column['date']['format'] && $column['date']['timezone']) {
                $value = $this->formatDate($value, $column['date']['format'], $column['date']['timezone'], $column['name']);
            }

            $transformedItem[$column['name']] = $value;
        }

        return $transformedItem;
    }

    protected function resolveNestedColumns(
        array $columns,
        Builder $query,
        ?string $search
    ) {
        $relationships = [];
        $searchConditions = [];

        foreach ($columns as $column) {
            $name = $column['name'];
            $searchable = $column['searchable']['enabled'] ?? false;

            if ($searchable) {
                if (strpos($name, '.') !== false) {
                    $parts = explode('.', $name);
                    $columnName = array_pop($parts);
                    $relationshipPath = implode('.', $parts);

                    if (! isset($relationships[$relationshipPath])) {
                        $relationships[$relationshipPath] = [];
                    }
                    $relationships[$relationshipPath][] = [
                        'column' => $columnName,
                        'searchable' => $searchable,
                    ];
                } else {
                    $searchConditions[] = function ($query) use ($name, $search) {
                        $query->orWhere($name, 'like', "%{$search}%");
                    };
                }
            }
        }

        $withArray = [];
        foreach ($relationships as $relationship => $columns) {
            $withArray[] = $relationship;
            foreach ($columns as $column) {
                $searchConditions[] = function ($query) use (
                    $relationship,
                    $column,
                    $search
                ) {
                    $query->orWhereHas($relationship, function ($query) use (
                        $column,
                        $search
                    ) {
                        $query->where($column['column'], 'like', "%{$search}%");
                    });
                };
            }
        }

        // Apply the eager loading with columns to the query
        if (! empty($withArray)) {
            $query->with($withArray);
        }

        // Apply the search conditions to the query
        if (! empty($searchConditions)) {
            $query->where(function ($query) use ($searchConditions) {
                foreach ($searchConditions as $condition) {
                    $condition($query);
                }
            });
        }
    }

    public function getResourceRecords(): Collection
    {
        return collect([
            'table' => $this->prepareResourceRecords(),
            'filters' => $this->getFilters(),
            'pagination' => $this->table->getPaginate(),
            'columns' => $this->table->getColumnLabels(),
            'heading' => $this->table->getHeading(),
            'description' => $this->table->getDescription(),
            'emptyStateHeading' => $this->table->getEmptyStateHeading(),
            'emptyStateDescription' => $this->table->getEmptyStateDescription(),
        ]);
    }
}
