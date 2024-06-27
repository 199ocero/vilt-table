<?php

namespace JAOcero\ViltTable\Table\Concerns;

use Closure;

trait HasEmptyState
{
    protected string|Closure|null $emptyStateHeading = null;

    protected string|Closure|null $emptyStateDescription = null;

    public function emptyStateHeading(string|Closure|null $emptyStateHeading): static
    {
        $this->emptyStateHeading = $emptyStateHeading;

        return $this;
    }

    public function emptyStateDescription(string|Closure|null $emptyStateDescription): static
    {
        $this->emptyStateDescription = $emptyStateDescription;

        return $this;
    }

    public function getEmptyStateHeading(): string|Closure|null
    {
        return $this->emptyStateHeading ?? 'No records found';
    }

    public function getEmptyStateDescription(): string|Closure|null
    {
        return $this->emptyStateDescription;
    }
}
