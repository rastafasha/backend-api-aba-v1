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
                'patient_id' => 'PAT001',
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
                    'tantrums' => true,
                    'aggression' => true
                ],
                'interventions' => [
                    'positive_reinforcement' => true,
                    'token_economy' => true
                ],
            ],
            [
                'id' => 2,
                'client_id' => 2, // Make sure this user exists
                'patient_id' => 'PAT002',
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
                    'self_stimming' => true,
                    'avoidance' => true
                ],
                'interventions' => [
                    'positive_reinforcement' => true,
                    'visual_schedules' => true
                ],
            ],
        ];

        foreach ($bips as $bip) {
            Bip::create($bip);
        }
    }
}