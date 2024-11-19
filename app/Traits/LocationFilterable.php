<?php

namespace App\Traits;

trait LocationFilterable
{
    public function scopeFilterByCity($query, $city)
    {
        return $query->when($city, function ($query) use ($city) {
            return $query->where('city', $city);
        });
    }

    public function scopeFilterByState($query, $state)
    {
        return $query->when($state, function ($query) use ($state) {
            return $query->where('state', $state);
        });
    }

    public function scopeFilterByZip($query, $zip)
    {
        return $query->when($zip, function ($query) use ($zip) {
            return $query->where('zip', $zip);
        });
    }
}
