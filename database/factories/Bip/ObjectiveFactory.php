<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Plan;
use App\Models\Bip\Objective;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjectiveFactory extends Factory
{
    protected $model = Objective::class;

    public function definition()
    {
        return [
            'plan_id' => Plan::factory(),
            'type' => $this->faker->randomElement(['LTO', 'STO']),
            'status' => $this->faker->randomElement(['not started', 'in progress', 'mastered', 'discontinued', 'maintenance']),
            'initial_date' => $this->faker->optional()->date(),
            'end_date' => $this->faker->optional()->date(),
            'description' => $this->faker->sentence(),
            'target' => $this->faker->numberBetween(0, 100),
            'order' => $this->faker->numberBetween(1, 10)
        ];
    }

    public function lto()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'LTO',
                'order' => 999
            ];
        });
    }

    public function sto()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'STO',
                'order' => $this->faker->numberBetween(1, 10)
            ];
        });
    }

    public function forPlan(Plan $plan)
    {
        return $this->state(function (array $attributes) use ($plan) {
            // Set target based on plan category
            $target = $plan->category === 'maladaptive'
                ? $this->faker->numberBetween(0, 40) // Lower targets for maladaptive (reduction)
                : $this->faker->numberBetween(60, 100); // Higher targets for others (improvement)

            return [
                'plan_id' => $plan->id,
                'target' => $target
            ];
        });
    }

    public function notStarted()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'not started',
                'initial_date' => null,
                'end_date' => null
            ];
        });
    }

    public function inProgress()
    {
        return $this->state(function (array $attributes) {
            $initialDate = now()->subDays($this->faker->numberBetween(1, 30));
            return [
                'status' => 'in progress',
                'initial_date' => $initialDate,
                'end_date' => null
            ];
        });
    }

    public function mastered()
    {
        return $this->state(function (array $attributes) {
            $initialDate = now()->subMonths($this->faker->numberBetween(1, 6));
            return [
                'status' => 'mastered',
                'initial_date' => $initialDate,
                'end_date' => now()
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
