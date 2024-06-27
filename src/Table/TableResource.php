<?php

namespace JAOcero\ViltTable\Table;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JAOcero\ViltTable\Table\Concerns\CanEvaluateDependencyInjection;
use JAOcero\ViltTable\Table\Concerns\CanFormatDate;
use JAOcero\ViltTable\Table\Contracts\HasTable;

class TableResource implements HasTable
{
    use CanEvaluateDependencyInjection;
    use CanFormatDate;

    protected ?string $model = null;

    protected Table $table;

    protected array $columns = [];

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

        $this->columns = $columns;

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

            $name = $column->getName();

            if (str_contains($name, '.')) {
                $value = data_get($item, $name);
            } else {
                $value = $item->{$name};
            }

            // check if state can be formatted
            if (is_callable($column->getFormattedState())) {
                $value = $this->evaluate($column->getFormattedState(),
                    namedInjections: [
                        'state' => $value,
                        'record' => $item,
                    ],
                    typedInjections: [
                        Model::class => $item,
                        $this->model => $item,
                    ]
                );
            }

            // check if the date can be formatted
            if ($column->getFormat()) {
                $value = $this->formatDate($value, $column->getFormat(), $column->getTimezone(), $name);
            }

            $transformedItem[$name] = $value;
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
            $name = $column->getName();
            $searchable = $this->evaluate($column->isSearchable());

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

    protected function getColumnLabels(array $columns): array
    {
        $columnLabels = [];

        foreach ($columns as $column) {
            $parts = explode('.', $column->getName());
            $columnName = array_pop($parts);
            $label = Str::replace('.', ' ', $this->evaluate($column->getLabel()) ?? $columnName);
            $columnLabels[$column->getName()] = Str::title(Str::replace('_', ' ', $label));
        }

        return $columnLabels;
    }

    public function getResourceRecords(): Collection
    {
        return collect([
            'table' => $this->prepareResourceRecords(),
            'filters' => $this->getFilters(),
            'pagination' => $this->table->getPaginate(),
            'columns' => $this->getColumnLabels($this->columns),
            'heading' => $this->table->getHeading(),
            'description' => $this->table->getDescription(),
            'emptyStateHeading' => $this->table->getEmptyStateHeading(),
            'emptyStateDescription' => $this->table->getEmptyStateDescription(),
        ]);
    }
}
