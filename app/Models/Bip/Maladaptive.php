<?php

namespace App\Models\Bip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maladaptive extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'bip_id',
        'name',
        'description',
        'baseline_level',
        'baseline_date',
        'initial_intensity',
        'current_intensity',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'baseline_date' => 'datetime',
        'baseline_level' => 'integer',
        'initial_intensity' => 'integer',
        'current_intensity' => 'integer',
    ];

    /**
     * Get the BIP that owns the maladaptive behavior.
     */
    public function bip()
    {
        return $this->belongsTo(Bip::class);
    }
}
