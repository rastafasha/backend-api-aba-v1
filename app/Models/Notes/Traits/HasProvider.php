<?php

namespace App\Models\Notes\Traits;

use App\Models\User;

trait HasProvider
{
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function getProviderAttribute()
    {
        return $this->provider()->select(['id', 'name', 'surname', 'npi', 'electronic_signature'])->first();
    }
}
