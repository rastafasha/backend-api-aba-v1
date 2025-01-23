<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Bip;
use App\Models\Bip\CrisisPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrisisPlanFactory extends Factory
{
    protected $model = CrisisPlan::class;

    public function definition()
    {
        return [
            'bip_id' => Bip::factory(),
            'crisis_description' => $this->faker->paragraph(),
            'crisis_note' => $this->faker->sentence(),
            'caregiver_requirements_for_prevention_of_crisis' => $this->faker->paragraph(),
            'risk_factors' => [
                'do_not_apply' => $this->faker->boolean(),
                'elopement' => $this->faker->boolean(),
                'assaultive_behavior' => $this->faker->boolean(),
                'aggression' => $this->faker->boolean(),
                'self_injurious_behavior' => $this->faker->boolean(),
                'sexually_offending_behavior' => $this->faker->boolean(),
                'fire_setting' => $this->faker->boolean(),
                'current_substance_abuse' => $this->faker->boolean(),
                'impulsive_behavior' => $this->faker->boolean(),
                'psychotic_symptoms' => $this->faker->boolean(),
                'self_mutilation_cutting' => $this->faker->boolean(),
                'caring_for_ill_family_recipient' => $this->faker->boolean(),
                'current_family_violence' => $this->faker->boolean(),
                'dealing_with_significant' => $this->faker->boolean(),
                'prior_psychiatric_inpatient_admission' => $this->faker->boolean(),
                'other' => ''
            ],
            'suicidalities' => [
                'not_present' => $this->faker->boolean(),
                'ideation' => $this->faker->boolean(),
                'plan' => $this->faker->boolean(),
                'means' => $this->faker->boolean(),
                'prior_attempt' => $this->faker->boolean()
            ],
            'homicidalities' => [
                'not_present' => $this->faker->boolean(),
                'ideation' => $this->faker->boolean(),
                'plan' => $this->faker->boolean(),
                'means' => $this->faker->boolean(),
                'prior_attempt' => $this->faker->boolean()
            ]
        ];
    }
}