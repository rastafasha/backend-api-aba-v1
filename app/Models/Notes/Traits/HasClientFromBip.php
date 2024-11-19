<?php

namespace App\Models\Notes\Traits;

use App\Models\Bip\Bip;

trait HasClientFromBip
{
    protected function getClientIdAttribute()
    {
        return $this->bip ? $this->bip->client_id : null;
    }
}
