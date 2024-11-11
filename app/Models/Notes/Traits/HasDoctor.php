<?php

namespace App\Models\Notes\Traits;

use App\Models\User;

trait HasDoctor
{
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function getDoctorAttribute()
    {
        return $this->doctor()->select(['id', 'name', 'surname', 'npi', 'electronic_signature'])->first();
    }
}
