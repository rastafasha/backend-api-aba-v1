<?php

namespace App\Traits;

trait TitleFilterable
{
    public function scopeFilterByTitle($query, $title)
    {
        return $query->when($title, function ($query) use ($title) {
            return $query->where('title', 'like', '%' . $title . '%');
        });
    }
}
