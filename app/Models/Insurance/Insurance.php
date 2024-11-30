<?php

namespace App\Models\Insurance;

use App\Models\Patient\Patient;
use App\Traits\LocationFilterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Insurance",
 *     required={"name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Insurance ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the insurance company",
 *         example="Blue Cross Blue Shield"
 *     ),
 *     @OA\Property(
 *         property="services",
 *         type="object",
 *         description="JSON object containing service details including codes, provider, description, unit price, hourly fee, and max allowed",
 *         example={
 *             "code": "97153",
 *             "provider": "BCBA",
 *             "description": "Adaptive behavior treatment",
 *             "unit_price": 65.00,
 *             "hourly_fee": 130.00,
 *             "max_allowed": 40
 *         }
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="object",
 *         description="JSON object containing additional notes and descriptions",
 *         example={
 *             "description": "Primary insurance provider for ABA therapy services"
 *         }
 *     ),
 *     @OA\Property(
 *         property="payer_id",
 *         type="string",
 *         description="Payer code used for EDI X12",
 *         example="00123"
 *     ),
 *     @OA\Property(
 *         property="street",
 *         type="string",
 *         description="Street address",
 *         example="123 Main Street"
 *     ),
 *     @OA\Property(
 *         property="street2",
 *         type="string",
 *         description="Additional street address information",
 *         example="Suite 100"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City name",
 *         example="Chicago"
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string",
 *         description="State code",
 *         example="IL"
 *     ),
 *     @OA\Property(
 *         property="zip",
 *         type="string",
 *         description="ZIP/Postal code",
 *         example="60601"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp",
 *         example="2023-01-01 12:00:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp",
 *         example="2023-01-01 12:00:00"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Soft delete timestamp",
 *         example=null
 *     )
 * )
 */
class Insurance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LocationFilterable;

    protected $fillable = [
        'name',
        'services', //Codes, provider, description, unit prize, Hourly Fee, max_allowed
        'notes', //description
        'payer_id', //payer code, used for EDI X12
        'street',
        'street2',
        'city',
        'state',
        'zip',
        'is_self_subscriber',
    ];

    protected $casts = [
        'services' => 'json',
        'notes' => 'json',
        'is_self_subscriber' => 'boolean',
    ];

    public function scopefilterAdvanceInsurance(
        $query,
        $name
    ) {

        if ($name) {
            $query->where("name", $name);
        }

        return $query;
    }


    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
