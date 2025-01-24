<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="CrisisPlan",
 *     title="CrisisPlan",
 *     description="Model for documenting crisis management plans",
 *     @OA\Property(property="id", type="integer", format="int64", example=1),
 *     @OA\Property(property="bip_id", type="integer", format="int64", example=1, description="ID of the BIP this crisis plan belongs to"),
 *     @OA\Property(property="crisis_description", type="string", description="Description of the crisis situation"),
 *     @OA\Property(property="crisis_note", type="string", description="Additional notes about the crisis"),
 *     @OA\Property(property="caregiver_requirements_for_prevention_of_crisis", type="string", description="Requirements for caregivers to prevent crisis"),
 *     @OA\Property(
 *         property="risk_factors",
 *         type="array",
 *         description="List of risk factors",
 *         @OA\Items(type="string")
 *     ),
 *     @OA\Property(
 *         property="suicidalities",
 *         type="array",
 *         description="List of suicidality factors",
 *         @OA\Items(type="string")
 *     ),
 *     @OA\Property(
 *         property="homicidalities",
 *         type="array",
 *         description="List of homicidality factors",
 *         @OA\Items(type="string")
 *     ),
 *     @OA\Property(property="created_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-01-01 00:00:00"),
 *     @OA\Property(property="deleted_at", type="string", format="datetime", nullable=true)
 * )
 */
class CrisisPlan
{
}
