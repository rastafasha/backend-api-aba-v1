<?php

namespace App\Models\Bip;

use App\Models\Bip\Bip;
use App\Models\User;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="ReductionGoal",
 *     title="Reduction Goal",
 *     description="A goal to reduce maladaptive behaviors",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="patient_identifier", type="string", example="PAT001"),
 *     @OA\Property(property="client_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="current_status", type="string", enum={"active", "completed", "on hold", "discontinued"}, example="active"),
 *     @OA\Property(property="maladaptive", type="string", example="Inappropriate Language"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true),
 *     @OA\Property(
 *         property="long_term_objective",
 *         ref="#/components/schemas/LongTermObjective",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="short_term_objectives",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ShortTermObjective")
 *     )
 * )
 */
class ReductionGoal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'patient_identifier',
        'client_id',
        'current_status',
        'maladaptive',
        'goalstos', //json
        'goalltos', //json
    ];

    public function bip()
    {
        return $this->belongsTo(Bip::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_identifier', 'patient_identifier');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function longTermObjective()
    {
        return $this->hasOne(LongTermObjective::class);
    }

    public function shortTermObjectives()
    {
        return $this->hasMany(ShortTermObjective::class)->orderBy('order');
    }
}
