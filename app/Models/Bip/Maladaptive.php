<?php

namespace App\Models\Bip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bip\ShortTermObjective;
use App\Models\Bip\LongTermObjective;

/**
 * @OA\Schema(
 *     schema="Maladaptive",
 *     title="Maladaptive",
 *     description="Maladaptive behavior model",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="name", type="string", example="Aggressive Behavior"),
 *     @OA\Property(property="description", type="string", example="Displays aggressive behavior towards others"),
 *     @OA\Property(property="baseline_level", type="integer", format="int32", example=5),
 *     @OA\Property(property="baseline_date", type="string", format="date-time"),
 *     @OA\Property(property="initial_intensity", type="integer", format="int32", example=7),
 *     @OA\Property(property="current_intensity", type="integer", format="int32", example=4),
 *     @OA\Property(property="status", type="string", enum={"active", "completed", "hold", "discontinued", "maintenance", "met", "monitoring"}),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
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

    public function shortTermObjectives()
    {
        return $this->hasMany(ShortTermObjective::class);
    }

    public function longTermObjectives()
    {
        return $this->hasMany(LongTermObjective::class);
    }
}
