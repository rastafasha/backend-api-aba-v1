<?php

namespace Database\Seeders;

use App\Models\Notes\NoteBcba;
use Carbon\Carbon;
use App\Models\Notes\NoteRbt;
use Illuminate\Database\Seeder;

class NotesSeeder extends Seeder
{
    public function run()
    {
        // First, let's ensure PaServices have their spent_units set to 0 initially
        $paServices = [
            [
                'patient_id' => 1,
                'pa_service' => 'Behavioral Analysis',
                'cpt' => '97153',
                'n_units' => 100,
                'spent_units' => 0,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(30),
            ],
            [
                'patient_id' => 1,
                'pa_service' => 'BCBA Supervision',
                'cpt' => '97155',
                'n_units' => 50,
                'spent_units' => 0,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(30),
            ],
            [
                'patient_id' => 2,
                'pa_service' => 'Behavioral Analysis',
                'cpt' => '97153',
                'n_units' => 100,
                'spent_units' => 0,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(30),
            ],
            [
                'patient_id' => 2,
                'pa_service' => 'BCBA Supervision',
                'cpt' => '97155',
                'n_units' => 50,
                'spent_units' => 0,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(30),
            ],
        ];

        foreach ($paServices as $service) {
            \App\Models\PaService::create($service);
        }

        $notes = [
            // Notes for Patient 1
            [
                'patient_id' => 1,
                'patient_identifier' => 'PAT001',
                'insurance_id' => 1,
                'doctor_id' => 3,
                'pa_service_id' => 1,
                'bip_id' => 1,
                'insurance_identifier' => '123456789',
                'provider_id' => 5,
                'supervisor_name' => 3,
                'supervisor_id' => 3,
                'pos' => '12',
                'session_date' => Carbon::now()->subDays(5),
                'time_in' => '09:00:00',
                'time_out' => '11:00:00',
                'session_length_total' => 2.0,
                'environmental_changes' => 'None noted',
                'maladaptives' => [
                    'tantrums' => 3,
                    'aggression' => 1
                ],
                'replacements' => [
                    'verbal_requests' => 5,
                    'waiting_quietly' => 4
                ],
                'interventions' => [
                    'positive_reinforcement' => true,
                    'prompting' => true,
                    'redirection' => true
                ],
                'meet_with_client_at' => 'Home',
                'client_appeared' => 'Alert and engaged',
                'as_evidenced_by' => 'Active participation in activities',
                'rbt_modeled_and_demonstrated_to_caregiver' => 'Positive reinforcement techniques',
                'client_response_to_treatment_this_session' => 'Client showed good progress with verbal requests',
                'progress_noted_this_session_compared_to_previous_session' => 'Improvement in communication skills',
                'next_session_is_scheduled_for' => Carbon::now()->addDays(2),
                'provider_signature' => 'Alice RBT',
                'provider_credential' => 'RBT',
                'supervisor_signature' => 'Sarah BCBA',
                'status' => 'ok',
                'summary_note' => 'Patient demonstrated improved task engagement. Token economy system is proving effective.',
                'location_id' => 1,
                'cpt_code' => '97153',
            ],
            [
                'patient_id' => 1,
                'patient_identifier' => 'PAT001',
                'insurance_id' => 1,
                'doctor_id' => 3,
                'pa_service_id' => 1,
                'bip_id' => 1,
                'insurance_identifier' => '123456789',
                'provider_id' => 5,
                'supervisor_name' => 3,
                'supervisor_id' => 3,
                'pos' => '12',
                'session_date' => Carbon::now()->subDays(3),
                'time_in' => '14:00:00',
                'time_out' => '16:00:00',
                'session_length_total' => 2.0,
                'environmental_changes' => 'Minimal distractions',
                'maladaptives' => [
                    'tantrums' => 2,
                    'aggression' => 0
                ],
                'replacements' => [
                    'verbal_requests' => 6,
                    'waiting_quietly' => 5
                ],
                'interventions' => [
                    'positive_reinforcement' => true,
                    'prompting' => true,
                    'modeling' => true
                ],
                'meet_with_client_at' => 'Home',
                'client_appeared' => 'Calm and cooperative',
                'as_evidenced_by' => 'Following instructions consistently',
                'rbt_modeled_and_demonstrated_to_caregiver' => 'Behavior management strategies',
                'client_response_to_treatment_this_session' => 'Decreased maladaptive behaviors',
                'progress_noted_this_session_compared_to_previous_session' => 'Continuing improvement in behavior control',
                'next_session_is_scheduled_for' => Carbon::now()->addDays(4),
                'provider_signature' => 'Alice RBT',
                'provider_credential' => 'RBT',
                'supervisor_signature' => 'Sarah BCBA',
                'status' => 'ok',
                'summary_note' => 'Client demonstrates improved task engagement. Token economy system is proving effective.',
                'location_id' => 1,
                'cpt_code' => '97153',
            ],

            // Notes for Patient 2
            [
                'patient_id' => 2,
                'patient_identifier' => 'PAT002',
                'insurance_id' => 1,
                'doctor_id' => 4,
                'pa_service_id' => 3,
                'bip_id' => 2,
                'insurance_identifier' => '987654321',
                'provider_id' => 6,
                'supervisor_name' => 4,
                'supervisor_id' => 4,
                'pos' => '12',
                'session_date' => Carbon::now()->subDays(4),
                'time_in' => '10:00:00',
                'time_out' => '12:00:00',
                'session_length_total' => 2.0,
                'environmental_changes' => 'Structured environment',
                'maladaptives' => [
                    'self_stimming' => 4,
                    'avoidance' => 2
                ],
                'replacements' => [
                    'task_completion' => 5,
                    'social_interaction' => 3
                ],
                'interventions' => [
                    'positive_reinforcement' => true,
                    'token_economy' => true,
                    'visual_schedules' => true
                ],
                'meet_with_client_at' => 'Home',
                'client_appeared' => 'Energetic but focused',
                'as_evidenced_by' => 'Completed multiple learning activities',
                'rbt_modeled_and_demonstrated_to_caregiver' => 'Token economy system',
                'client_response_to_treatment_this_session' => 'Responded well to token system',
                'progress_noted_this_session_compared_to_previous_session' => 'Improved task completion',
                'next_session_is_scheduled_for' => Carbon::now()->addDays(3),
                'provider_signature' => 'Bob RBT',
                'provider_credential' => 'RBT',
                'supervisor_signature' => 'Mike BCBA',
                'status' => 'ok',
                'summary_note' => 'Patient demonstrated improved task engagement. Token economy system is proving effective.',
                'location_id' => 2,
                'cpt_code' => '97153',
            ],
            [
                'patient_id' => 2,
                'patient_identifier' => 'PAT002',
                'insurance_id' => 1,
                'doctor_id' => 4,
                'pa_service_id' => 3,
                'bip_id' => 2,
                'insurance_identifier' => '987654321',
                'provider_id' => 6,
                'supervisor_name' => 4,
                'supervisor_id' => 4,
                'pos' => '12',
                'session_date' => Carbon::now()->subDays(2),
                'time_in' => '13:00:00',
                'time_out' => '15:00:00',
                'session_length_total' => 2.0,
                'environmental_changes' => 'Quiet study area',
                'maladaptives' => [
                    'self_stimming' => 3,
                    'avoidance' => 1
                ],
                'replacements' => [
                    'task_completion' => 6,
                    'social_interaction' => 4
                ],
                'interventions' => [
                    'positive_reinforcement' => true,
                    'token_economy' => true,
                    'social_stories' => true
                ],
                'meet_with_client_at' => 'Home',
                'client_appeared' => 'Well-regulated',
                'as_evidenced_by' => 'Maintained attention throughout session',
                'rbt_modeled_and_demonstrated_to_caregiver' => 'Social story implementation',
                'client_response_to_treatment_this_session' => 'Good engagement with social stories',
                'progress_noted_this_session_compared_to_previous_session' => 'Increased social interaction',
                'next_session_is_scheduled_for' => Carbon::now()->addDays(5),
                'provider_signature' => 'Bob RBT',
                'provider_credential' => 'RBT',
                'supervisor_signature' => 'Mike BCBA',
                'status' => 'ok',
                'summary_note' => 'Patient demonstrated improved task engagement. Token economy system is proving effective.',
                'location_id' => 2,
                'cpt_code' => '97153',
            ],
        ];

        $bcba_notes = [
            // BCBA Note for Patient 1
            [
                'patient_id' => 1,
                'insurance_id' => 2,
                'doctor_id' => 3,
                'pa_service_id' => 2,
                'bip_id' => 1,
                'insurance_identifier' => '123456789',
                'provider_id' => 3,
                'supervisor_id' => 3,
                'session_date' => Carbon::now()->subDays(4),
                'time_in' => '13:00:00',
                'time_out' => '14:00:00',
                'session_length_total' => 1.0,
                'summary_note' => 'Patient showing consistent progress in communication skills. RBT implementation of behavior protocols is effective.',
                'note_description' => 'Patient showing consistent progress in communication skills. RBT implementation of behavior protocols is effective.',
                'caregiver_goals' => [
                    [
                        'criteria' => 'test',
                        'initiation' => '2024-07-12T04:00:00.000Z',
                        'caregiver_goal' => 'test',
                        'current_status' => 'new',
                        'outcome_measure' => 'test',
                        'porcent_of_correct_response' => 12
                    ]
                ],
                'rbt_training_goals' => [
                    [
                        'lto' => 'RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.',
                        'date' => '2024-07-12T04:00:00.000Z',
                        'status' => 'inprogress',
                        'porcent_of_correct_response' => 32
                    ]
                ],
                'meet_with_client_at' => 'Home',
                'provider_signature' => 'Sarah BCBA',
                'supervisor_signature' => 'Sarah BCBA',
                'status' => 'ok',
                'location_id' => 1,
                'cpt_code' => '97155',
            ],

            // BCBA Note for Patient 2
            [
                'patient_id' => 2,
                'insurance_id' => 2,
                'doctor_id' => 4,
                'pa_service_id' => 4,
                'bip_id' => 1,
                'insurance_identifier' => '987654321',
                'provider_id' => 4,
                'supervisor_id' => 4,
                'session_date' => Carbon::now()->subDays(3),
                'time_in' => '15:00:00',
                'time_out' => '16:00:00',
                'session_length_total' => 1.0,
                'summary_note' => 'Client demonstrates improved task engagement. Token economy system is proving effective.',
                'note_description' => 'Patient demonstrated improved task engagement. Token economy system is proving effective.',
                'caregiver_goals' => [
                    [
                        'criteria' => 'test',
                        'initiation' => '2024-07-12T04:00:00.000Z',
                        'caregiver_goal' => 'test',
                        'current_status' => 'new',
                        'outcome_measure' => 'test',
                        'porcent_of_correct_response' => 12
                    ]
                ],
                'rbt_training_goals' => [
                    [
                        'lto' => 'RBT will independently demonstrate appropriate data collection, near 100% of opportunities, across two consecutive observations.',
                        'date' => '2024-07-12T04:00:00.000Z',
                        'status' => 'inprogress',
                        'porcent_of_correct_response' => 32
                    ]
                ],
                'meet_with_client_at' => 'Home',
                'provider_signature' => 'Mike BCBA',
                'supervisor_signature' => 'Mike BCBA',
                'status' => 'ok',
                'location_id' => 2,
                'cpt_code' => '97155',
            ]
        ];

        foreach ($notes as $note) {
            NoteRbt::create($note);
        }

        foreach ($bcba_notes as $note) {
            NoteBcba::create($note);
        }
    }
}
