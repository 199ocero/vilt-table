<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

trait HasDate
{
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
        return $this->timezone ?? config('app.timezone');
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }
}
