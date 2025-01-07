<?php

namespace App\Models\Bip;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="ShortTermObjective",
 *     title="Short Term Objective",
 *     description="A short-term objective for a maladaptive",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="maladaptive_id", type="integer", format="int64", example=1),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"in progress", "mastered", "not started", "discontinued", "maintenance"},
 *         example="in progress"
 *     ),
 *     @OA\Property(property="initial_date", type="string", format="date", example="2024-01-01"),
 *     @OA\Property(property="end_date", type="string", format="date", example="2024-03-01"),
 *     @OA\Property(property="description", type="string", example="Reduce inappropriate language to less than 5 instances per day"),
 *     @OA\Property(property="target", type="number", format="float", example=5),
 *     @OA\Property(property="order", type="integer", example=1),
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
        'maladaptive_id',
        'replacement_id',
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

    public function maladaptive()
    {
        return $this->belongsTo(Maladaptive::class);
    }

    public function replacement()
    {
        return $this->belongsTo(Replacement::class);
    }
}
