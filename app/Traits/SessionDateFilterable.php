<?php

namespace App\Traits;

trait SessionDateFilterable
{
    public function scopeFilterByDateRange($query, $dateStart = null, $dateEnd = null)
    {
        if ($dateStart && $dateEnd) {
            return $query->whereBetween('session_date', [$dateStart, $dateEnd]);
        }

        if ($dateStart) {
            return $query->where('session_date', '>=', $dateStart);
        }

        if ($dateEnd) {
            return $query->where('session_date', '<=', $dateEnd);
        }

        return $query;
    }
}
