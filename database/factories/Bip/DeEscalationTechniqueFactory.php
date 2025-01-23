<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Bip;
use App\Models\Bip\DeEscalationTechnique;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeEscalationTechniqueFactory extends Factory
{
    protected $model = DeEscalationTechnique::class;

    public function definition()
    {
        return [
            'bip_id' => Bip::factory(),
            'description' => $this->faker->paragraph(),
            'service_recomendation' => $this->faker->sentence(),
            'recomendation_lists' => [
                [
                    'cpt' => '97151',
                    'location' => $this->faker->randomElement(['In Home', 'School', 'Clinic']),
                    'num_units' => $this->faker->numberBetween(1, 50),
                    'breakdown_per_week' => (string)$this->faker->numberBetween(1, 10),
                    'description_service' => $this->faker->sentence()
                ],
                [
                    'cpt' => '97153',
                    'location' => $this->faker->randomElement(['In Home', 'School', 'Clinic']),
                    'num_units' => $this->faker->numberBetween(1, 50),
                    'breakdown_per_week' => (string)$this->faker->numberBetween(1, 10),
                    'description_service' => $this->faker->sentence()
                ]
            ]
        ];
    }
}