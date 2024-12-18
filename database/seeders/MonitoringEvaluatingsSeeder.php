<?php

namespace Database\Seeders;

use App\Models\Bip\MonitoringEvaluating;
use Illuminate\Database\Seeder;

class MonitoringEvaluatingsSeeder extends Seeder
{
    public function run(): void
    {
        $monitoringEvaluatings = [
            [
                'bip_id' => 1,
                'patient_identifier' => "PAT001",
                'client_id' => 1,
                'rbt_training_goals' => '[{
                    "index": 1,
                    "lto": "RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.",
                    "date": "2024-07-12T04:00:00.000Z",
                    "status": "inprogress",
                    "porcent_of_correct_response": "80"
                }]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'bip_id' => 2,
                'patient_identifier' => "PAT002",
                'client_id' => 2,
                'rbt_training_goals' => '[{
                    "index": 1,
                    "lto": "RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.",
                    "date": "2024-07-15T04:00:00.000Z",
                    "status": "inprogress",
                    "porcent_of_correct_response": "80"
                }]',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($monitoringEvaluatings as $monitoringEvaluating) {
            MonitoringEvaluating::create($monitoringEvaluating);
        }
    }
}
