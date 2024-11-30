<?php

namespace Database\Seeders;

use App\Models\Bip\SustitutionGoal;
use Illuminate\Database\Seeder;

class SustitutionGoalsSeeder extends Seeder
{
    public function run(): void
    {
        SustitutionGoal::create([
            'bip_id' => 1,
            'patient_identifier' => "PAT001",
            'client_id' => 1,
            'current_status' => 'test',
            'goal' => 'test goal',
            'description' => 'test description',
            'goalstos' => '[{
                "sto": "test",
                "date_sto": "2024-07-12T04:00:00.000Z",
                "sustitution_status_sto": "inprogress",
                "sustitution_sto": "test",
                "decription_sto": "test",
                "sustitution_status_sto_edit": "inprogress"
            }]',
            'goalltos' => '[{
                "lto": "test",
                "date_lto": "2024-07-12T04:00:00.000Z",
                "status_lto": "initiated",
                "decription_lto": "test"
            }]',
        ]);

        SustitutionGoal::create([
            'bip_id' => 2,
            'patient_identifier' => "PAT002",
            'client_id' => 2,
            'current_status' => 'in progress',
            'goal' => 'communication improvement',
            'description' => 'improve verbal communication skills',
            'goalstos' => '[{
                "sto": "use complete sentences",
                "date_sto": "2024-07-15T04:00:00.000Z",
                "sustitution_status_sto": "inprogress",
                "sustitution_sto": "verbal communication",
                "decription_sto": "practice forming complete sentences",
                "sustitution_status_sto_edit": "inprogress"
            }]',
            'goalltos' => '[{
                "lto": "maintain conversations",
                "date_lto": "2024-07-15T04:00:00.000Z",
                "status_lto": "initiated",
                "decription_lto": "ability to maintain basic conversations"
            }]',
        ]);
    }
}
