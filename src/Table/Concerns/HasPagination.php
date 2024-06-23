<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

trait HasPagination
{
    use HasEvaluate;

    protected array $perPage = [10, 20, 50, 100];

    public function paginate(array $perPage = []): static
    {
        if (! empty($perPage)) {
            $this->perPage = $perPage;
        }

        return $this;
    }

    public function getPaginate(): array
    {
        return $this->evaluate($this->perPage);
    }
}
