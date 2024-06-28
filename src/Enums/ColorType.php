<?php

namespace JAOcero\ViltTable\Enums;

enum ColorType: string
{
    case PRIMARY = 'primary';
    case SUCCESS = 'success';
    case DANGER = 'danger';
    case WARNING = 'warning';
    case INFO = 'info';
    case CUSTOM = 'custom';

    public static function getMainColorTypes(): array
    {
        return [
            self::PRIMARY->value,
            self::SUCCESS->value,
            self::DANGER->value,
            self::WARNING->value,
            self::INFO->value,
        ];
    }
}
