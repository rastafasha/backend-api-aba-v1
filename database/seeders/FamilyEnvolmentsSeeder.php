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
                'patient_id' => "PAT001",
                'client_id' => 1,
                'bip_id' => 1,
                'caregivers_training_goals' => '[{
                    "criteria": "test",
                    "initiation": "2024-07-12T04:00:00.000Z",
                    "caregiver_goal": "test",
                    "current_status": "new",
                    "outcome_measure": "test",
                    "porcent_of_correct_response": 12
                }]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'patient_id' => "PAT002",
                'client_id' => 2,
                'bip_id' => 2,
                'caregivers_training_goals' => '[{
                    "criteria": "test",
                    "initiation": "2024-07-15T04:00:00.000Z",
                    "caregiver_goal": "test",
                    "current_status": "new",
                    "outcome_measure": "test",
                    "porcent_of_correct_response": 16
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

