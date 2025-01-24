<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Bip;
use App\Models\Bip\GeneralizationTraining;
use Illuminate\Database\Eloquent\Factories\Factory;

class GeneralizationTrainingFactory extends Factory
{
    protected $model = GeneralizationTraining::class;

    public function definition()
    {
        return [
            'bip_id' => Bip::factory(),
            'discharge_plan' => $this->faker->paragraph(),
            'transition_fading_plans' => [
                [
                    'transition_plan' => $this->faker->sentence(),
                    'fading_plan' => $this->faker->sentence(),
                    'timeline' => $this->faker->date('Y-m-d')
                ],
                [
                    'transition_plan' => $this->faker->sentence(),
                    'fading_plan' => $this->faker->sentence(),
                    'timeline' => $this->faker->date('Y-m-d')
                ]
            ]
        ];
    }
}