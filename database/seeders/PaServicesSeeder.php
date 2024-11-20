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
                'pa_services' => 'service 1 RBT',
                'cpt' => '97153',
                'n_units' => 100,
                'remaining_units' => 100,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 1,
                'pa_services' => 'service 1 BCBA',
                'cpt' => '97155',
                'n_units' => 50,
                'remaining_units' => 50,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 2,
                'pa_services' => 'service 2 RBT',
                'cpt' => '97153',
                'n_units' => 100,
                'remaining_units' => 100,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
            [
                'patient_id' => 2,
                'pa_services' => 'service 2 BCBA',
                'cpt' => '97155',
                'n_units' => 50,
                'remaining_units' => 50,
                'start_date' => Date::now()->format('Y-m-d'),
                'end_date' => Date::now()->addDays(100)->format('Y-m-d'),
            ],
        ];

        foreach ($paServices as $paService) {
            PaService::create($paService);
        }
    }
}
