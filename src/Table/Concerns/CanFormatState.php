<?php

namespace JAOcero\ViltTable\Table\Concerns;

use Closure;

trait CanFormatState
{
    protected ?Closure $state = null;

    public function formatStateUsing(?Closure $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getFormattedState(): ?Closure
    {
        if ($this->state) {
            return $this->state;
        }

        return null;
    }
}
