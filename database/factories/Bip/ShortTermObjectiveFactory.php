<?php

namespace Database\Factories\Bip;

use App\Models\Bip\ReductionGoal;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortTermObjectiveFactory extends Factory
{
    protected $model = ShortTermObjective::class;

    public function definition(): array
    {
        return [
            'reduction_goal_id' => ReductionGoal::factory(),
            'status' => $this->faker->randomElement(['in progress', 'mastered', 'initiated', 'on hold', 'discontinued', 'maintenance']),
            'initial_date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'end_date' => $this->faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'description' => $this->faker->sentence(6),
            'target' => $this->faker->numberBetween(50, 100),
            'order' => 1
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

    public function forReductionGoal(ReductionGoal $goal, int $order = null): self
    {
        return $this->state(function (array $attributes) use ($goal, $order) {
            return [
                'reduction_goal_id' => $goal->id,
                'order' => $order ?? 1
            ];
        });
    }

    public function withOrder(int $order): self
    {
        return $this->state(function (array $attributes) use ($order) {
            return [
                'order' => $order
            ];
        });
    }
}
