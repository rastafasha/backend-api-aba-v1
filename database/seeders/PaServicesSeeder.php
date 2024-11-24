<?php
namespace Database\Seeders;

use App\Models\PaService;
use Illuminate\Database\Seeder;

class PaServicesSeeder extends Seeder
{
    public function run()
    {
        $paServices = [
            [
                'patient_id' => 1,
                'pa_services' => 'service 1',
                'cpt' => '97151',
                'n_units' => 1000,
                'start_date' => '2024-01-01',
                'end_date' => '2024-01-01',
            ],
            [
                'patient_id' => 2,
                'pa_services' => 'service 2',
                'cpt' => '97153',
                'n_units' => 1000,
                'start_date' => '2024-01-01',
                'end_date' => '2024-01-01',
            ],
        ];

        foreach ($paServices as $paService) {
            PaService::create($paService);
        }
    }
}