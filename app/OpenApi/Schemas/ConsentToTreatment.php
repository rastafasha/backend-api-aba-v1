<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="ConsentToTreatment",
 *     title="ConsentToTreatment",
 *     description="Model for documenting consent to treatment agreements",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1, description="ID of the BIP this consent belongs to"),
 *     @OA\Property(property="analyst_signature", type="string", description="Signature of the analyst"),
 *     @OA\Property(property="analyst_signature_date", type="string", format="date", example="2024-01-01", description="Date of analyst signature"),
 *     @OA\Property(property="parent_guardian_signature", type="string", description="Signature of parent or guardian"),
 *     @OA\Property(property="parent_guardian_signature_date", type="string", format="date", example="2024-01-01", description="Date of parent/guardian signature"),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */
class ConsentToTreatment
{
}
