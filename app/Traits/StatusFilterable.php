<?php

namespace App\Traits;

trait StatusFilterable
{
    public function scopeFilterByStatus($query, $status)
    {
        return $query->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        });
    }
}
