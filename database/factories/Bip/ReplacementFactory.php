<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Bip;
use App\Models\Bip\Replacement;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplacementFactory extends Factory
{
    protected $model = Replacement::class;

    public function definition()
    {
        return [
            'bip_id' => Bip::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'baseline_level' => $this->faker->numberBetween(1, 10),
            'baseline_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'initial_intensity' => $this->faker->numberBetween(1, 10),
            'current_intensity' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['completed', 'hold', 'discontinued', 'maintenance', 'met', 'monitoring'])
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active'
            ];
        });
    }
}
