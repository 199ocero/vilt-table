<?php

namespace JAOcero\LaravelInertiaTable\Table\Concerns;

use Exception;
use Illuminate\Support\Carbon;
use InvalidArgumentException;

trait CanFormatDate
{
    public function formatDate(string $date, string $format, string $timezone, string $column): ?string
    {
        try {
            $carbonDate = Carbon::parse($date);
        } catch (Exception $e) {
            throw new InvalidArgumentException('Column '.$column.' must be a valid date');
        }

        $date = Carbon::parse($carbonDate)
            ->setTimezone($timezone);

        if ($format) {
            return $date->translatedFormat($format);
        } else {
            return $date;
        }
    }
}
