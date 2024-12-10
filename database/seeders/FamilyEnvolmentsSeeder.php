<?php

namespace Database\Seeders;

use App\Models\Bip\FamilyEnvolment;
use Illuminate\Database\Seeder;

class FamilyEnvolmentsSeeder extends Seeder
{
    public function run(): void
    {
        $familyEnvolments = [
            [
                'patient_identifier' => "PAT001",
                'client_id' => 1,
                'bip_id' => 1,
                'caregivers_training_goals' => '[{
                    "index": 1,
                    "caregiver_goal": "test",
                    "criteria": "90%",
                    "current_status": "inprogress",
                    "initiation": "2024-07-12T04:00:00.000Z",
                    "nombre": "test",
                    "outcome_measure": "Monthly fidelity checks in which the percentage of times (across 4 data points) the parent demonstrated concept.",
                }]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_identifier' => "PAT002",
                'client_id' => 2,
                'bip_id' => 2,
                'caregivers_training_goals' => '[{
                    "index": 1,
                    "caregiver_goal": "test",
                    "criteria": "90%",
                    "current_status": "inprogress",
                    "initiation": "2024-07-12T04:00:00.000Z",
                    "nombre": "test",
                    "outcome_measure": "Monthly fidelity checks in which the percentage of times (across 4 data points) the parent demonstrated concept.",
                }]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($familyEnvolments as $familyEnvolment) {
            FamilyEnvolment::create($familyEnvolment);
        }
    }
}

