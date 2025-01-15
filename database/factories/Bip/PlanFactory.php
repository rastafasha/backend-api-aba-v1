<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Bip;
use App\Models\Bip\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition()
    {
        return [
            'bip_id' => Bip::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'category' => $this->faker->randomElement(['maladaptive', 'replacement', 'caregiver_training', 'rbt_training']),
            'status' => $this->faker->randomElement(['active', 'completed', 'hold', 'discontinued', 'maintenance', 'met', 'monitoring']),
            'baseline_level' => null,
            'baseline_date' => null,
            'initial_intensity' => null,
            'current_intensity' => null,
        ];
    }

    public function maladaptive()
    {
        return $this->state(function (array $attributes) {
            return [
                'category' => 'maladaptive',
                'baseline_level' => $this->faker->numberBetween(1, 10),
                'baseline_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
                'initial_intensity' => $this->faker->numberBetween(5, 10),
                'current_intensity' => $this->faker->numberBetween(1, 5),
            ];
        });
    }

    public function replacement()
    {
        return $this->state(function (array $attributes) {
            return [
                'category' => 'replacement',
                'baseline_level' => $this->faker->numberBetween(1, 3),
                'baseline_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
                'initial_intensity' => $this->faker->numberBetween(1, 3),
                'current_intensity' => $this->faker->numberBetween(4, 10),
            ];
        });
    }

    public function caregiverTraining()
    {
        return $this->state(function (array $attributes) {
            return [
                'category' => 'caregiver_training'
            ];
        });
    }

    public function rbtTraining()
    {
        return $this->state(function (array $attributes) {
            return [
                'category' => 'rbt_training'
            ];
        });
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active'
            ];
        });
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed'
            ];
        });
    }

    public function withObjectives()
    {
        return $this->afterCreating(function (Plan $plan) {
            // Create LTO
            $ltoDescription = $plan->category === 'maladaptive'
                ? "Long term reduction of {$plan->name} to 0 per week across all settings"
                : "Long term improvement of {$plan->name} to achieve mastery across all settings";

            $ltoTarget = $plan->category === 'maladaptive' ? 0 : 100;

            \App\Models\Bip\Objective::factory()->create([
                'plan_id' => $plan->id,
                'type' => 'LTO',
                'status' => 'not started',
                'description' => $ltoDescription,
                'target' => $ltoTarget,
                'order' => 999
            ]);

            // Create 3 STOs with progressive status
            $baseDate = now()->subMonths(2);
            $statuses = ['mastered', 'in progress', 'not started'];
            $targets = $plan->category === 'maladaptive'
                ? [40, 30, 20]  // Decreasing targets for maladaptive
                : [25, 50, 75]; // Increasing targets for others

            foreach (range(0, 2) as $i) {
                \App\Models\Bip\Objective::factory()->create([
                    'plan_id' => $plan->id,
                    'type' => 'STO',
                    'status' => $statuses[$i],
                    'initial_date' => $i === 0 ? $baseDate : null,
                    'end_date' => $i === 0 ? $baseDate->copy()->addMonth() : null,
                    'description' => "Phase " . ($i + 1) . " " .
                        ($plan->category === 'maladaptive' ? 'reduction' : 'improvement') .
                        " of {$plan->name}",
                    'target' => $targets[$i],
                    'order' => $i + 1
                ]);
            }
        });
    }
}
