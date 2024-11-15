<?php

namespace App\Models\Notes\Traits;

use App\Models\User;

trait HasSupervisor
{
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function getSupervisorAttribute()
    {
        return $this->supervisor()->select(['id', 'name', 'surname', 'npi', 'electronic_signature'])->first();
    }
}
