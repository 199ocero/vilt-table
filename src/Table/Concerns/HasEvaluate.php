<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

trait HasEvaluate
{
    public function evaluate($value): mixed
    {
        if (is_callable($value)) {
            return $value();
        }

        return $value;
    }
}
