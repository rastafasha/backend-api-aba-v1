<?php

namespace App\Models\Notes\Traits;

use App\Models\Bip\Bip;

trait HasClientFromBip
{
  public function bip()
  {
    return $this->belongsTo(Bip::class, 'bip_id');
  }

  protected function getClientIdAttribute()
  {
    return $this->bip ? $this->bip->client_id : null;
  }
}
