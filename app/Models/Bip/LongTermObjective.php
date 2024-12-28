<?php

namespace App\Models\Bip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="LongTermObjective",
 *     title="Long Term Objective",
 *     description="A long-term objective for a reduction goal",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="reduction_goal_id", type="integer", format="int64", example=1),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"in progress", "mastered", "initiated", "on hold", "discontinued", "maintenance"},
 *         example="in progress"
 *     ),
 *     @OA\Property(property="initial_date", type="string", format="date", example="2024-01-01"),
 *     @OA\Property(property="end_date", type="string", format="date", example="2024-06-01"),
 *     @OA\Property(property="description", type="string", example="Reduce inappropriate language usage by 80% in all settings"),
 *     @OA\Property(property="target", type="number", format="float", example=80),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */
class LongTermObjective extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'reduction_goal_id',
        'status',
        'initial_date',
        'end_date',
        'description',
        'target'
    ];

    protected $casts = [
        'initial_date' => 'date',
        'end_date' => 'date',
        'target' => 'decimal:2'
    ];

    public function reductionGoal()
    {
        return $this->belongsTo(ReductionGoal::class);
    }
}
