<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

use Closure;

trait HasHeading
{
    use HasEvaluate;

    protected string|Closure|null $heading = null;

    public function heading(string|Closure|null $heading): static
    {
        $this->heading = $heading;

        return $this;
    }

    public function getHeading(): ?string
    {
        return $this->evaluate($this->heading);
    }
}
