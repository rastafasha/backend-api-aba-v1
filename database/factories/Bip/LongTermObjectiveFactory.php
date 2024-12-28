<?php

namespace Database\Factories\Bip;

use App\Models\Bip\ReductionGoal;
use App\Models\Bip\LongTermObjective;
use Illuminate\Database\Eloquent\Factories\Factory;

class LongTermObjectiveFactory extends Factory
{
    protected $model = LongTermObjective::class;

    public function definition(): array
    {
        return [
            'reduction_goal_id' => ReductionGoal::factory(),
            'status' => $this->faker->randomElement(['in progress', 'mastered', 'initiated', 'on hold', 'discontinued', 'maintenance']),
            'initial_date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'description' => $this->faker->sentence(6),
            'target' => $this->faker->numberBetween(70, 100)
        ];
    }

    public function inProgress(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'in progress'
            ];
        });
    }

    public function mastered(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'mastered'
            ];
        });
    }

    public function forReductionGoal(ReductionGoal $goal): self
    {
        return $this->state(function (array $attributes) use ($goal) {
            return [
                'reduction_goal_id' => $goal->id
            ];
        });
    }
}
