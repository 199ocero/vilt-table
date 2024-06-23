<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

use Closure;

trait HasLabel
{
    use HasEvaluate;

    protected string|Closure|null $label = null;

    public function label(string|Closure|null $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->evaluate($this->label);
    }
}
