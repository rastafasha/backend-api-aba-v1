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
            'documents_reviewed' => $this->faker->words(3),
            'background_information' => $this->faker->paragraph(),
            'previus_treatment_and_result' => $this->faker->paragraph(),
            'current_treatment_and_progress' => $this->faker->paragraph(),
            'education_status' => $this->faker->paragraph(),
            'physical_and_medical_status' => $this->faker->paragraph(),
            'strengths' => $this->faker->paragraph(),
            'weakneses' => $this->faker->paragraph(),
            'physical_and_medical' => null,
            'assestment_conducted' => null,
            'assestment_conducted_options' => null,
            'assestment_evaluation_settings' => null,
            'prevalent_setting_event_and_atecedents' => null,
            'hypothesis_based_intervention' => null,
            'interventions' => [
                'token_economy' => $this->faker->boolean(),
                'positive_reinforcement' => $this->faker->boolean(),
                'visual_schedules' => $this->faker->boolean()
            ],
            'tangibles' => null,
            'attention' => null,
            'escape' => null,
            'sensory' => null,
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
