<?php

namespace App\Models;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="PaService",
 *     required={"patient_id", "pa_services", "cpt", "n_units", "start_date", "end_date"},
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="patient_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="pa_services", type="string", example="Behavioral Analysis"),
 *     @OA\Property(property="cpt", type="string", example="97151"),
 *     @OA\Property(property="n_units", type="integer", example=8),
 *     @OA\Property(property="start_date", type="string", format="date", example="2024-03-01"),
 *     @OA\Property(property="end_date", type="string", format="date", example="2024-04-01"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-03-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-03-01T12:00:00Z"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */
class PaService extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'pa_services',
        'cpt',
        'n_units',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
