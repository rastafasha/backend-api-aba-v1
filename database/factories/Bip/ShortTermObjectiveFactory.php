<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Maladaptive;
use App\Models\Bip\Replacement;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortTermObjectiveFactory extends Factory
{
    protected $model = ShortTermObjective::class;

    public function definition()
    {
        return [
            'status' => $this->faker->randomElement(['in progress', 'mastered', 'not started', 'discontinued', 'maintenance']),
            'initial_date' => $this->faker->optional()->date(),
            'end_date' => $this->faker->optional()->date(),
            'description' => $this->faker->sentence(),
            'target' => $this->faker->randomFloat(2, 0, 100),
            'order' => $this->faker->numberBetween(1, 10)
        ];
    }

    public function forMaladaptive(Maladaptive $maladaptive)
    {
        return $this->state(function (array $attributes) use ($maladaptive) {
            return [
                'maladaptive_id' => $maladaptive->id
            ];
        });
    }

    public function forReplacement(Replacement $replacement)
    {
        return $this->state(function (array $attributes) use ($replacement) {
            return [
                'replacement_id' => $replacement->id
            ];
        });
    }

    public function withOrder(int $order)
    {
        return $this->state(function (array $attributes) use ($order) {
            return [
                'order' => $order
            ];
        });
    }
}
