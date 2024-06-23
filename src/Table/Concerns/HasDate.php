<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

trait HasDate
{
    use HasEvaluate;

    protected ?string $date = null;

    protected ?string $format = null;

    protected ?string $timezone = null;

    public function date(?string $format = null, ?string $timezone = null): static
    {
        $this->format = $format;
        $this->timezone = $timezone;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->evaluate($this->timezone) ?? config('app.timezone');
    }

    public function getFormat(): ?string
    {
        return $this->evaluate($this->format);
    }
}
