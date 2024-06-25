<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

use Closure;

trait CanBeSearchable
{
    protected bool|Closure $searchable = true;

    protected int|Closure $searchDebounce = 500;

    public function searchable(bool|Closure $searchable = true): static
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function isSearchable(): bool|Closure
    {
        return $this->searchable;
    }

    public function searchDebounce(int|Closure $debounce = 500): static
    {
        $this->searchDebounce = $debounce;

        return $this;
    }

    public function getSearchDebounce(): int|Closure
    {
        return $this->searchDebounce;
    }
}
