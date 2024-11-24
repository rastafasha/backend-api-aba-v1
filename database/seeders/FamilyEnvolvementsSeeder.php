<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilyEnvolvementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('family_envolments')->insert([
            [
                'id' => 1,
                'bip_id' => 1,
                'patient_id' => 'PAT001',
                'client_id' => 1,
                'caregivers_training_goals' => json_encode([
                    [
                        "criteria" => "test",
                        "initiation" => "2024-07-12T04:00:00.000Z",
                        "caregiver_goal" => "test",
                        "current_status" => "new",
                        "outcome_measure" => "test",
                        "porcent_of_correct_response" => 12
                    ]
                ]),
                'created_at' => '2024-11-24 03:12:56',
                'updated_at' => '2024-11-24 03:12:56',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'bip_id' => 2,
                'patient_id' => 'PAT002',
                'client_id' => 2,
                'caregivers_training_goals' => json_encode([
                    [
                        "criteria" => "test",
                        "initiation" => "2024-07-15T04:00:00.000Z",
                        "caregiver_goal" => "test",
                        "current_status" => "new",
                        "outcome_measure" => "test",
                        "porcent_of_correct_response" => 16
                    ]
                ]),
                'created_at' => '2024-11-24 03:12:56',
                'updated_at' => '2024-11-24 03:12:56',
                'deleted_at' => null,
            ],
            // Puedes agregar más registros aquí si es necesario
        ]);
    }
}
