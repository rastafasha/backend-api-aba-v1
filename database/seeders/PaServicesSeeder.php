<?php

namespace Database\Seeders;

use App\Models\PaService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class PaServicesSeeder extends Seeder
{
    public function run()
    {
        $paServices = [
            [
                'patient_id' => 1,
                'pa_service' => 'P000001-01',
                'cpt' => '97151',
                'n_units' => 250,
                'spent_units' => 0,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 1,
                'pa_service' => 'P000001-01',
                'cpt' => '97153',
                'n_units' => 250,
                'spent_units' => 0,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 1,
                'pa_service' => 'P000001-01',
                'cpt' => '97155',
                'n_units' => 250,
                'spent_units' => 0,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 1,
                'pa_service' => 'P000001-01',
                'cpt' => '97156',
                'n_units' => 250,
                'spent_units' => 0,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 2,
                'pa_service' => 'P000002-02',
                'cpt' => '97151',
                'n_units' => 250,
                'spent_units' => 0,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 2,
                'pa_service' => 'P000002-02',
                'cpt' => '97153',
                'n_units' => 250,
                'spent_units' => 0,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 2,
                'pa_service' => 'P000002-02',
                'cpt' => '97155',
                'n_units' => 250,
                'spent_units' => 0,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 2,
                'pa_service' => 'P000002-02',
                'cpt' => '97156',
                'n_units' => 250,
                'spent_units' => 0,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
        ];

        foreach ($paServices as $paService) {
            PaService::create($paService);
        }
    }
}
