<?php

namespace Database\Seeders;

use App\Models\Bip\Bip;
use Illuminate\Database\Seeder;

class BipSeeder extends Seeder
{
    public function run()
    {
        $bips = [
            [
                'id' => 1,
                'client_id' => 1, // Make sure this user exists
                'patient_identifier' => 'PAT001',
                'doctor_id' => 3, // BCBA1
                'type_of_assessment' => 3,
                'documents_reviewed' => ['Initial Assessment', 'Medical Records'],
                'background_information' => 'Patient background information for PAT001',
                'previus_treatment_and_result' => 'Previous ABA therapy with positive outcomes',
                'current_treatment_and_progress' => 'Currently receiving regular ABA therapy',
                'education_status' => 'Attending special education program',
                'phisical_and_medical_status' => 'Generally healthy, no major concerns',
                'strengths' => 'Good motor skills, responsive to reinforcement',
                'weakneses' => 'Communication difficulties, attention challenges',

                'maladaptives' => [
                    [
                        'index' => 1,
                        'maladaptive_behavior' => 'Bad Words',
                        'topografical_definition' => 'Said bad word every day',
                        'baseline_level' => '43',
                        'baseline_date' => '2024-11-23T04:00:00.000Z',
                        'initial_interesting' => 30,
                        'current_intensity' => 58
                    ],
                    [
                        'index' => 2,
                        'maladaptive_behavior' => 'Drawin walls', 
                        'topografical_definition' => 'draw wall til sleep',
                        'baseline_level' => '30',
                        'baseline_date' => '2024-11-24T04:00:00.000Z',
                        'initial_interesting' => 30,
                        'current_intensity' => 70
                    ]
                ],


            ],
            [
                'id' => 2,
                'client_id' => 2, // Make sure this user exists
                'patient_identifier' => 'PAT002',
                'doctor_id' => 4, // BCBA2
                'type_of_assessment' => 3,
                'documents_reviewed' => ['Behavioral Assessment', 'School Records'],
                'background_information' => 'Patient background information for PAT002',
                'previus_treatment_and_result' => 'First time in ABA therapy',
                'current_treatment_and_progress' => 'New to ABA treatment program',
                'education_status' => 'Mainstream education with support',
                'phisical_and_medical_status' => 'No significant health concerns',
                'strengths' => 'Strong visual learning skills',
                'weakneses' => 'Social interaction challenges',

                'maladaptives' => [
                    [
                        'index' => 1,
                        'maladaptive_behavior' => 'Bad Words',
                        'topografical_definition' => 'Said bad word every day',
                        'baseline_level' => '43',
                        'baseline_date' => '2024-11-23T04:00:00.000Z',
                        'initial_interesting' => 30,
                        'current_intensity' => 58
                    ],
                    [
                        'index' => 2,
                        'maladaptive_behavior' => 'Drawin walls',
                        'topografical_definition' => 'draw wall til sleep',
                        'baseline_level' => '30',
                        'baseline_date' => '2024-11-24T04:00:00.000Z',
                        'initial_interesting' => 30,
                        'current_intensity' => 70
                    ]
                ],



            ],
        ];

        foreach ($bips as $bip) {
            Bip::create($bip);
        }
    }
}
