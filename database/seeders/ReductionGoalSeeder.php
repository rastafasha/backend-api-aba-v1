<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReductionGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reduction_goals')->insert([
            [
                'id' => 1,
                'bip_id' => 1,
                'maladaptive' => 'test',
                'current_status' => 'test',
                'patient_id' => '1',
                'client_id' => 1,
                'goalstos' => json_encode([
                    [
                        "sto" => "test",
                        "date_sto" => "2024-07-12T04:00:00.000Z",
                        "status_sto" => "inprogress",
                        "maladaptive" => "test",
                        "decription_sto" => "test",
                        "status_sto_edit" => "inprogress"
                    ]
                ]),
                'goalltos' => json_encode([
                    [
                        "lto" => "test",
                        "date_lto" => "2024-07-12T04:00:00.000Z",
                        "status_lto" => "initiated",
                        "decription_lto" => "test"
                    ]
                ]),
                'created_at' => '2024-11-24 03:12:56',
                'updated_at' => '2024-11-24 03:12:56',
                'deleted_at' => null,
            ],
            
        ]);
    }
}
