<?php

namespace JAOcero\ViltTable\Table\Concerns;

trait HasPagination
{
    protected array $perPage = [10, 20, 50, 100];

    public function pagination(array $perPage = []): static
    {
        if (! empty($perPage)) {
            $this->perPage = $perPage;
        }

        return $this;
    }

    public function getPagination(): array
    {
        return $this->perPage;
    }
}
