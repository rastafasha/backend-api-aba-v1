<?php

namespace Database\Factories;

use App\Models\PaService;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PaServiceFactory extends Factory
{
    protected $model = PaService::class;

    public function definition()
    {
        $startDate = Carbon::now()->addDays(rand(-30, 0));
        $endDate = Carbon::parse($startDate)->addDays(rand(1, 90));

        return [
            'patient_id' => Patient::factory(),
            'pa_services' => $this->faker->randomElement([
                'Behavioral Analysis',
                'Therapy Session',
                'Assessment',
                'Parent Training',
                'Group Session'
            ]),
            'cpt' => $this->faker->randomElement([
                '97151', // Behavior identification assessment
                '97153', // Adaptive behavior treatment
                '97154', // Group adaptive behavior treatment
                '97155', // Adaptive behavior treatment with protocol modification
                '97156', // Family adaptive behavior treatment guidance
                '97157', // Multiple-family group adaptive behavior treatment guidance
            ]),
            'n_units' => $this->faker->numberBetween(1, 48),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

    // State methods for different scenarios
    public function expired()
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::now()->subMonths(3);
            $endDate = Carbon::now()->subMonth();

            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
        });
    }

    public function current()
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::now()->subDays(15);
            $endDate = Carbon::now()->addDays(15);

            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
        });
    }

    public function future()
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::now()->addMonth();
            $endDate = Carbon::now()->addMonths(2);

            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
        });
    }

    public function highUnits()
    {
        return $this->state(function (array $attributes) {
            return [
                'n_units' => $this->faker->numberBetween(24, 48),
            ];
        });
    }

    public function lowUnits()
    {
        return $this->state(function (array $attributes) {
            return [
                'n_units' => $this->faker->numberBetween(1, 8),
            ];
        });
    }
}
