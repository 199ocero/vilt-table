<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

use Closure;

trait CanBeSearchable
{
    use HasEvaluate;

    protected bool|Closure $searchable;

    protected int|Closure $searchDebounce = 500;

    public function searchable(bool|Closure $searchable = true): static
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function isSearchable(): bool
    {
        return $this->evaluate($this->searchable ?? false);
    }

    public function searchDebounce(int|Closure $debounce = 500): static
    {
        $this->searchDebounce = $debounce;

        return $this;
    }

    public function getSearchDebounce(): int
    {
        return $this->evaluate($this->searchDebounce);
    }
}
