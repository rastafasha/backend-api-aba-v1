<?php

namespace App\Traits;

trait CreatedAtFilterable
{
    public function scopeFilterByCreatedAtRange($query, $dateStart = null, $dateEnd = null)
    {
        if ($dateStart && $dateEnd) {
            return $query->whereBetween('created_at', [$dateStart, $dateEnd]);
        }

        if ($dateStart) {
            return $query->where('created_at', '>=', $dateStart);
        }

        if ($dateEnd) {
            return $query->where('created_at', '<=', $dateEnd);
        }

        return $query;
    }
}
