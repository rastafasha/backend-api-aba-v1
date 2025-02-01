<?php

namespace App\Models;

use App\Models\Bip\Bip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Recommendation",
 *     title="Recommendation",
 *     description="Model for service recommendations in a Behavior Intervention Plan",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1,
 *         description="Unique identifier for the recommendation"
 *     ),
 *     @OA\Property(
 *         property="bip_id",
 *         type="integer",
 *         format="int64",
 *         example=1,
 *         description="ID of the BIP this recommendation belongs to"
 *     ),
 *     @OA\Property(
 *         property="cpt",
 *         type="string",
 *         example="97151",
 *         description="CPT (Current Procedural Terminology) code for the service"
 *     ),
 *     @OA\Property(
 *         property="description_service",
 *         type="string",
 *         example="Behavior identification assessment",
 *         description="Detailed description of the recommended service"
 *     ),
 *     @OA\Property(
 *         property="num_units",
 *         type="integer",
 *         example=32,
 *         description="Number of units recommended"
 *     ),
 *     @OA\Property(
 *         property="breakdown_per_week",
 *         type="string",
 *         example="8",
 *         description="Recommended distribution of units per week"
 *     ),
 *     @OA\Property(
 *         property="location",
 *         type="string",
 *         example="In Home/School",
 *         description="Location where the service should be provided"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp of when the recommendation was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp of when the recommendation was last updated"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Soft delete timestamp"
 *     )
 * )
 */
class Recommendation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'bip_id',
        'cpt',
        'description_service',
        'num_units',
        'breakdown_per_week',
        'location',
    ];

    public function bip()
    {
        return $this->belongsTo(Bip::class, 'bip_id');
    }
}
