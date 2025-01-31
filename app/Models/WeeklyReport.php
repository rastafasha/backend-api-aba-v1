<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Bip\Plan;

/**
 * @OA\Schema(
 *     schema="WeeklyReport",
 *     required={"plan_id", "week_start", "week_end", "value"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Weekly report unique identifier",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="plan_id",
 *         type="integer",
 *         format="int64",
 *         description="ID of the associated plan",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="week_start",
 *         type="string",
 *         format="date",
 *         description="Start date of the week",
 *         example="2024-01-01"
 *     ),
 *     @OA\Property(
 *         property="week_end",
 *         type="string",
 *         format="date",
 *         description="End date of the week",
 *         example="2024-01-07"
 *     ),
 *     @OA\Property(
 *         property="value",
 *         type="integer",
 *         description="Value for the weekly report",
 *         example=75
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp of when the record was created",
 *         example="2024-01-30T19:49:04.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp of when the record was last updated",
 *         example="2024-01-30T19:49:04.000000Z"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Soft delete timestamp",
 *         example=null
 *     ),
 *     @OA\Property(
 *         property="plan",
 *         ref="#/components/schemas/Plan",
 *         description="The associated plan"
 *     )
 * )
 */
class WeeklyReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['plan_id', 'week_start', 'week_end', 'value'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
