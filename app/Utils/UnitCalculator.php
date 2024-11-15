<?php

namespace App\Utils;

class UnitCalculator
{
    const MINUTES_PER_UNIT = 15;
    const ROUNDING_THRESHOLD = 8;

    public function calculateUnits(int $minutes): int
    {
        $baseUnits = (int)($minutes / self::MINUTES_PER_UNIT);
        $remainingMinutes = $minutes % self::MINUTES_PER_UNIT;

        return $remainingMinutes >= self::ROUNDING_THRESHOLD
            ? $baseUnits + 1
            : $baseUnits;
    }
}
