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
            'patient_id' => 'PAT' . $this->faker->unique()->numberBetween(1000, 9999),
            'doctor_id' => User::factory(),
            'type_of_assessment' => $this->faker->numberBetween(1, 5),
            'documents_reviewed' => $this->faker->words(3),
            'background_information' => $this->faker->paragraph(),
            'previus_treatment_and_result' => $this->faker->paragraph(),
            'current_treatment_and_progress' => $this->faker->paragraph(),
            'education_status' => $this->faker->paragraph(),
            'phisical_and_medical_status' => $this->faker->paragraph(),
            'strengths' => $this->faker->paragraph(),
            'weakneses' => $this->faker->paragraph(),
            'phiysical_and_medical' => null,
            'phiysical_and_medical_status' => null,
            'maladaptives' => [
                'tantrums' => $this->faker->boolean(),
                'aggression' => $this->faker->boolean(),
                'self_stimming' => $this->faker->boolean(),
                'avoidance' => $this->faker->boolean()
            ],
            'assestment_conducted' => null,
            'assestment_conducted_options' => null,
            'assestmentEvaluationSettings' => null,
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
    public function withReductionGoals()
    {
        return $this->afterCreating(function (Bip $bip) {
            $bip->reduction_goals()->create([
                'patient_id' => $bip->patient_id,
                'client_id' => $bip->client_id,
                'current_status' => $this->faker->paragraph(),
                'maladaptive' => $this->faker->word(),
                'goalstos' => $this->faker->words(3),
                'goalltos' => $this->faker->words(3),
            ]);
        });
    }

    public function withSustitutionGoals()
    {
        return $this->afterCreating(function (Bip $bip) {
            $bip->sustitution_goals()->create([
                'patient_id' => $bip->patient_id,
                'client_id' => $bip->client_id,
                'current_status' => $this->faker->paragraph(),
                'goal' => $this->faker->sentence(),
                'description' => $this->faker->paragraph(),
                'goalstos' => $this->faker->words(3),
                'goalltos' => $this->faker->words(3),
            ]);
        });
    }

    public function withCrisisPlan()
    {
        return $this->afterCreating(function (Bip $bip) {
            $bip->crisis_plans()->create([
                'patient_id' => $bip->patient_id,
                'client_id' => $bip->client_id,
                'crisis_description' => $this->faker->paragraph(),
                'crisis_note' => $this->faker->paragraph(),
                'caregiver_requirements_for_prevention_of_crisis' => $this->faker->paragraph(),
                'risk_factors' => $this->faker->words(3),
                'suicidalities' => $this->faker->words(3),
                'homicidalities' => $this->faker->words(3),
            ]);
        });
    }

    public function complete()
    {
        return $this->withReductionGoals()
            ->withSustitutionGoals()
            ->withCrisisPlan();
    }
}
