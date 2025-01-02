<?php

namespace Database\Seeders;

use App\Models\Bip\Bip;
use App\Models\User;
use App\Models\Bip\ReductionGoal;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Database\Seeder;

class ReductionGoalsSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test client if it doesn't exist
        $testClient = User::firstOrCreate(
            ['id' => 1],
            User::factory()->make()->toArray()
        );

        // Create a test BIP if it doesn't exist
        $testBip = Bip::firstOrCreate(
            ['id' => 1],
            Bip::factory()->make()->toArray()
        );

        // Create some reduction goals with objectives following progression logic
        ReductionGoal::factory()
            ->count(5)
            ->forBip($testBip)
            ->forClient($testClient)
            ->create()
            ->each(function ($goal) {
                // Create LTO for each goal (not started, no dates)
                LongTermObjective::create([
                    'reduction_goal_id' => $goal->id,
                    'status' => 'not started',
                    'description' => 'Long term reduction of frequency of ' . $goal->maladaptive . ' to 0 per week across all settings',
                    'target' => 0
                ]);

                // Create 4 STOs with progressive status
                $baseDate = now()->subMonths(2);

                // First STO - Mastered with completed dates
                ShortTermObjective::create([
                    'reduction_goal_id' => $goal->id,
                    'status' => 'mastered',
                    'initial_date' => $baseDate->format('Y-m-d'),
                    'end_date' => $baseDate->addMonths(1)->format('Y-m-d'),
                    'description' => 'First phase reduction of ' . $goal->maladaptive,
                    'target' => 40,
                    'order' => 1
                ]);

                // Second STO - In Progress with only initial date
                ShortTermObjective::create([
                    'reduction_goal_id' => $goal->id,
                    'status' => 'in progress',
                    'initial_date' => $baseDate->format('Y-m-d'),
                    'description' => 'Second phase reduction of ' . $goal->maladaptive,
                    'target' => 30,
                    'order' => 2
                ]);

                // Third and Fourth STOs - Not Started, no dates
                for ($i = 3; $i <= 4; $i++) {
                    ShortTermObjective::create([
                        'reduction_goal_id' => $goal->id,
                        'status' => 'not started',
                        'description' => 'Phase ' . $i . ' reduction of ' . $goal->maladaptive,
                        'target' => 40 - ($i * 10),
                        'order' => $i
                    ]);
                }
            });

        // Create a specific example goal for testing
        $testGoal = ReductionGoal::create([
            'bip_id' => $testBip->id,
            'patient_identifier' => "PAT001",
            'client_id' => $testClient->id,
            'current_status' => 'active',
            'maladaptive' => 'Inappropriate Language'
        ]);

        // Add its LTO (not started)
        LongTermObjective::create([
            'reduction_goal_id' => $testGoal->id,
            'status' => 'not started',
            'description' => 'Reduce inappropriate language usage to 0 per week in all settings',
            'target' => 0
        ]);

        // Base date for the progression
        $baseDate = now()->subMonths(1);

        // Add its STOs with progression
        $stos = [
            [
                'description' => 'Reduce frequency of inappropriate language to 40 per week in all settings',
                'target' => 30,
                'status' => 'mastered',
                'initial_date' => $baseDate->format('Y-m-d'),
                'end_date' => $baseDate->addMonths(1)->format('Y-m-d')
            ],
            [
                'description' => 'Reduce frequency of inappropriate language to 30 per week in all settings',
                'target' => 20,
                'status' => 'in progress',
                'initial_date' => $baseDate->format('Y-m-d'),
                'end_date' => null
            ],
            [
                'description' => 'Reduce frequency of inappropriate language to 20 per week in all settings',
                'target' => 10,
                'status' => 'not started',
                'initial_date' => null,
                'end_date' => null
            ],
            [
                'description' => 'Reduce frequency of inappropriate language to 10 per week in all settings',
                'target' => 0,
                'status' => 'not started',
                'initial_date' => null,
                'end_date' => null
            ]
        ];

        foreach ($stos as $index => $sto) {
            ShortTermObjective::create([
                'reduction_goal_id' => $testGoal->id,
                'status' => $sto['status'],
                'initial_date' => $sto['initial_date'],
                'end_date' => $sto['end_date'],
                'description' => $sto['description'],
                'target' => $sto['target'],
                'order' => $index + 1
            ]);
        }
    }
}
