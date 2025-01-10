<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="GeneralizationTraining",
 *     title="GeneralizationTraining",
 *     description="Model for documenting generalization training and transition plans",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1, description="ID of the BIP this training belongs to"),
 *     @OA\Property(property="patient_identifier", type="string", example="PAT123", description="Patient identifier"),
 *     @OA\Property(property="client_id", type="integer", format="int64", example=1, description="ID of the client"),
 *     @OA\Property(property="discharge_plan", type="string", description="Plan for discharge from services"),
 *     @OA\Property(
 *         property="transition_fading_plans",
 *         type="array",
 *         description="List of transition and fading plans",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="transition_plan", type="string", description="Description of the transition plan"),
 *             @OA\Property(property="fading_plan", type="string", description="Description of the fading plan"),
 *             @OA\Property(property="timeline", type="string", description="Timeline for the transition/fading plan")
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */
class GeneralizationTraining
{
}
