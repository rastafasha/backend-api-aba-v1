<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Bip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BipFactory extends Factory
{
    protected $model = Bip::class;

    public function definition()
    {
        return [
            'client_id' => User::factory(),
            'patient_identifier' => 'PAT' . $this->faker->unique()->numberBetween(1000, 9999),
            'doctor_id' => User::factory(),
            'type_of_assessment' => $this->faker->numberBetween(1, 5),
            'documents_reviewed' => json_encode($this->faker->words(3)),
            'background_information' => $this->faker->paragraph(),
            'previous_treatment_and_result' => $this->faker->paragraph(),
            'current_treatment_and_progress' => $this->faker->paragraph(),
            'education_status' => $this->faker->paragraph(),
            'physical_and_medical_status' => $this->faker->paragraph(),
            'strengths' => $this->faker->paragraph(),
            'weaknesses' => $this->faker->paragraph(),
            'physical_and_medical' => json_encode([
                [
                    'index' => 1,
                    'medication' => $this->faker->word(),
                    'dose' => $this->faker->numberBetween(5, 100) . 'mg',
                    'frequency' => $this->faker->randomElement(['Once daily', 'Twice daily', 'Three times daily']),
                    'reason' => $this->faker->sentence(),
                    'preescribing_physician' => 'Dr. ' . $this->faker->lastName()
                ]
            ]),
            'assestment_conducted' => $this->faker->paragraph(),
            'assestment_conducted_options' => json_encode($this->faker->randomElements([
                'Functional Behavior Assessment',
                'Clinical Interview',
                'Behavioral Observation',
                'Standardized Testing',
                'Record Review'
            ], 3)),
            'assestment_evaluation_settings' => json_encode($this->faker->randomElements([
                'Home',
                'School',
                'Clinic',
                'Community'
            ], 2)),
            'prevalent_setting_event_and_antecedents' => json_encode($this->faker->words(5)),
            'hypothesis_based_intervention' => $this->faker->paragraph(),
            'interventions' => json_encode([
                'token_economy' => $this->faker->boolean(),
                'positive_reinforcement' => $this->faker->boolean(),
                'visual_schedules' => $this->faker->boolean(),
                'behavioral_momentum' => $this->faker->boolean(),
                'differential_reinforcement' => $this->faker->boolean()
            ]),
            'tangibles' => json_encode($this->faker->randomElements([
                'toys',
                'stickers',
                'tokens',
                'preferred activities'
            ], 2)),
            'attention' => json_encode($this->faker->randomElements([
                'verbal praise',
                'physical attention',
                'social interaction'
            ], 2)),
            'escape' => json_encode($this->faker->randomElements([
                'task avoidance',
                'break requests',
                'environmental changes'
            ], 2)),
            'sensory' => json_encode($this->faker->randomElements([
                'tactile',
                'auditory',
                'visual',
                'vestibular'
            ], 2)),
            'discharge_plan' => $this->faker->paragraph(),
            'fading_plan' => $this->faker->paragraph(),
            'risk_assessment' => $this->faker->paragraph(),
            'generalization_training' => $this->faker->paragraph(),
            'crisis_plan' => json_encode(
                [
                    'description' => $this->faker->paragraph(),
                    'prevention' => $this->faker->paragraph()
                ]
            ),
            'de_escalation_techniques' => json_encode([
                [
                    'description' => $this->faker->paragraph()
                ]
            ]),
            'recommendations' => json_encode([
                [
                    'cpt' => '97153',
                    'description_service' => 'Behavioral Therapy',
                    'num_units' => 10,
                    'breakdown_per_week' => '2 sessions per week',
                    'location' => 'In-Home'
                ]
            ])
        ];
    }

    // State methods for different scenarios
    public function withMaladaptives()
    {
        return $this->afterCreating(function (Bip $bip) {
            $bip->maladaptives()->create([
                'name' => $this->faker->word(),
                'description' => $this->faker->paragraph(),
                'baseline_level' => $this->faker->numberBetween(1, 10),
                'baseline_date' => now(),
                'initial_intensity' => $this->faker->numberBetween(1, 10),
                'current_intensity' => $this->faker->numberBetween(1, 10),
                'status' => $this->faker->randomElement(['active', 'completed', 'hold', 'discontinued', 'maintenance', 'met', 'monitoring'])
            ]);
        });
    }

    public function complete()
    {
        return $this->withMaladaptives();
    }
}
