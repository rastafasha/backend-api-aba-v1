<?php

namespace Database\Seeders;

use App\Models\Bip\ReductionGoal;
use Illuminate\Database\Seeder;

class ReductionGoalsSeeder extends Seeder
{
    public function run(): void
    {
        ReductionGoal::create([
            'bip_id' => 1,
            'patient_identifier' => "PAT001",
            'client_id' => 1,
            'current_status' => 'test',
            'maladaptive' => 'Bad Words',
            'goalstos' => '[{
                    "sto": "1",
                    "index": 1,
                    "status_sto": "inprogress",
                    "maladaptive": "Bad Words",
                    "end_date_sto": "2024-12-28T04:00:00.000Z",
                    "status_sto_edit": "inprogress",
                    "initial_date_sto": "2024-12-04T04:00:00.000Z"
                }]',

            'goalltos' => '[{
                    "lto": "1",
                    "index": 1,
                    "status_lto": "inprogress",
                    "end_date_lto": "2024-12-28T04:00:00.000Z",
                    "initial_date_lto": "2024-12-04T04:00:00.000Z"
                }]',
        ]);
    }
}
