<?php

namespace JAOcero\ViltTable\Table\Concerns;

use Closure;

trait HasLabel
{
    protected string|Closure|null $label = null;

    public function label(string|Closure|null $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string|Closure|null
    {
        return $this->label;
    }
}
