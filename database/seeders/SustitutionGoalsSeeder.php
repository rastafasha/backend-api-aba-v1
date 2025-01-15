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
                "end_sustitution_date_sto": null,
                "index": 1,
                "sustitution_date_sto": "2024-12-04T04:00:00.000Z",
                "sustitution_decription_sto": "test",
                "sustitution_status_sto": "inprogress",
                "sustitution_status_sto_edit": "inprogress",
                "sustitution_sto": "STO#1",
                "target": "80"

            }]',
            'goalltos' => '[{
                "sustitution_lto": "1",
                "sustitution_date_lto": "2024-12-04T04:00:00.000Z",
                "end_sustitution_date_lto": "2024-12-28T04:00:00.000Z",
                "sustitution_status_lto": "inprogress",
                "sustitution_status_lto_edit": "inprogress",
                "sustitution_decription_lto": "test"

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
                "end_sustitution_date_sto": null,
                "index": 1,
                "sustitution_date_sto": "2024-12-04T04:00:00.000Z",
                "sustitution_decription_sto": "test",
                "sustitution_status_sto": "inprogress",
                "sustitution_status_sto_edit": "inprogress",
                "sustitution_sto": "STO#1",
                "target": "70"
            }]',
            'goalltos' => '[{
                "sustitution_lto": "1",
                "sustitution_date_lto": "2024-12-04T04:00:00.000Z",
                "end_sustitution_date_lto": "2024-12-28T04:00:00.000Z",
                "sustitution_status_lto": "initiated",
                "decription_lto": "test"

            }]',
        ]);
    }
}
