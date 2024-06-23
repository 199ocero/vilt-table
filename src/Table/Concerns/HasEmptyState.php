<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

use Closure;

trait HasEmptyState
{
    use HasEvaluate;

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

    public function getEmptyStateHeading(): ?string
    {
        return $this->evaluate($this->emptyStateHeading) ?? 'No records found';
    }

    public function getEmptyStateDescription(): ?string
    {
        return $this->evaluate($this->emptyStateDescription);
    }
}
