<?php

namespace App\Models\Bip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="ShortTermObjective",
 *     title="Short Term Objective",
 *     description="A short-term objective for a reduction goal",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="reduction_goal_id", type="integer", format="int64", example=1),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"in progress", "mastered", "not started", "discontinued", "maintenance"},
 *         example="in progress"
 *     ),
 *     @OA\Property(property="initial_date", type="string", format="date", example="2024-01-01"),
 *     @OA\Property(property="end_date", type="string", format="date", example="2024-03-01"),
 *     @OA\Property(property="description", type="string", example="Use appropriate language in classroom settings"),
 *     @OA\Property(property="target", type="number", format="float", example=60),
 *     @OA\Property(property="order", type="integer", format="int32", example=1),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */
class ShortTermObjective extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'reduction_goal_id',
        'status',
        'initial_date',
        'end_date',
        'description',
        'target',
        'order'
    ];

    protected $casts = [
        'initial_date' => 'date',
        'end_date' => 'date',
        'target' => 'decimal:2',
        'order' => 'integer'
    ];

    public function reductionGoal()
    {
        return $this->belongsTo(ReductionGoal::class);
    }
}
