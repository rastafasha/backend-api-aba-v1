<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Bip;
use App\Models\User;
use App\Models\Bip\ReductionGoal;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReductionGoalFactory extends Factory
{
    protected $model = ReductionGoal::class;

    public function definition(): array
    {
        $maladaptiveBehaviors = [
            'Inappropriate Language',
            'Physical Aggression',
            'Verbal Aggression',
            'Self-Injurious Behavior',
            'Property Destruction',
            'Elopement',
            'Non-Compliance',
            'Tantrums',
            'Disruption',
            'Social Withdrawal'
        ];

        return [
            'bip_id' => Bip::factory(),
            'patient_identifier' => 'PAT' . str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'client_id' => User::factory(),
            'current_status' => $this->faker->randomElement(['active', 'completed', 'on hold', 'discontinued']),
            'maladaptive' => $this->faker->randomElement($maladaptiveBehaviors),
            'goalstos' => '[{
                    "sto": "1",
                    "index": 1,
                    "status_sto": "inprogress",
                    "maladaptive": "Bad Words",
                    "end_date_sto": "2024-12-28T04:00:00.000Z",
                    "status_sto_edit": "inprogress",
                    "initial_date_sto": "2024-12-04T04:00:00.000Z"
                }]',

            'goalltos' => '[{
                    "lto": "1",
                    "index": 1,
                    "status_lto": "inprogress",
                    "end_date_lto": "2024-12-28T04:00:00.000Z",
                    "initial_date_lto": "2024-12-04T04:00:00.000Z"
                }]',
        ];
    }

    public function active(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'current_status' => 'active'
            ];
        });
    }

    public function completed(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'current_status' => 'completed'
            ];
        });
    }

    public function forBip(Bip $bip): self
    {
        return $this->state(function (array $attributes) use ($bip) {
            return [
                'bip_id' => $bip->id
            ];
        });
    }

    public function forClient(User $client): self
    {
        return $this->state(function (array $attributes) use ($client) {
            return [
                'client_id' => $client->id
            ];
        });
    }

    public function forPatient(string $patientIdentifier): self
    {
        return $this->state(function (array $attributes) use ($patientIdentifier) {
            return [
                'patient_identifier' => $patientIdentifier
            ];
        });
    }
}
