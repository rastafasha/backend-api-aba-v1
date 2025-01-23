<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="DeEscalationTechnique",
 *     title="DeEscalationTechnique",
 *     description="Model for documenting techniques used to prevent and manage escalating behaviors",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1, description="ID of the BIP this technique belongs to"),
 *     @OA\Property(property="description", type="string", description="Description of the de-escalation technique"),
 *     @OA\Property(property="service_recomendation", type="string", description="Service recommendations"),
 *     @OA\Property(
 *         property="recomendation_lists",
 *         type="array",
 *         description="List of specific recommendations",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="cpt", type="string", example="97151", description="CPT code"),
 *             @OA\Property(property="location", type="string", example="In Home/School", description="Location where technique is applied"),
 *             @OA\Property(property="num_units", type="integer", example=32, description="Number of units"),
 *             @OA\Property(property="breakdown_per_week", type="string", example="8", description="Weekly breakdown"),
 *             @OA\Property(property="description_service", type="string", example="Assessment", description="Service description")
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */
class DeEscalationTechnique
{
}
