<?php

namespace JAOcero\ViltTable\Table\Concerns;

use Closure;

trait HasDescription
{
    protected string|Closure|null $description = null;

    public function description(string|Closure|null $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string|Closure|null
    {
        return $this->description;
    }
}
