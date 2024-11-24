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
            'patient_id' => 1,
            'client_id' => 1,
            'current_status' => 'test',
            'maladaptive' => 'test',
            'goalstos' => '[{
                "sto": "test",
                "date_sto": "2024-07-12T04:00:00.000Z", 
                "status_sto": "inprogress",
                "maladaptive": "test",
                "decription_sto": "test",
                "status_sto_edit": "inprogress"
            }]',
            'goalltos' => '[{
                "lto": "test",
                "date_lto": "2024-07-12T04:00:00.000Z",
                "status_lto": "initiated", 
                "decription_lto": "test"
            }]',
        ]);
    }
}
