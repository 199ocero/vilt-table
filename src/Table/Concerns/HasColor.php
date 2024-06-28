<?php

namespace JAOcero\ViltTable\Table\Concerns;

use JAOcero\ViltTable\Enums\ColorType;
use JAOcero\ViltTable\Support\Colors;

trait HasColor
{
    protected array $color = [];

    public function color(string $color): static
    {
        $name = ColorType::CUSTOM->value;

        if (in_array($color, ColorType::getMainColorTypes())) {
            $name = $color;
        }

        $hex = Colors::getColor($color);

        $this->color = [
            'name' => $name,
            'hex' => $hex,
        ];

        return $this;
    }

    public function getColor(): array
    {
        if (empty($this->color)) {
            $this->color = [
                'name' => ColorType::PRIMARY->value,
                'hex' => Colors::getColor(ColorType::PRIMARY->value),
            ];
        }

        return $this->color;
    }
}
