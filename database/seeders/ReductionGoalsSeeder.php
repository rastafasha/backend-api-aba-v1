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

        // Create some reduction goals with complete objectives
        ReductionGoal::factory()
            ->count(5)
            ->forBip($testBip)
            ->forClient($testClient)
            ->create()
            ->each(function ($goal) {
                // Create one LTO for each goal
                LongTermObjective::factory()
                    ->forReductionGoal($goal)
                    ->create();

                // Create 3-5 STOs for each goal
                $numSTOs = rand(3, 5);
                for ($i = 1; $i <= $numSTOs; $i++) {
                    ShortTermObjective::factory()
                        ->forReductionGoal($goal, $i)
                        ->create();
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

        // Add its LTO
        LongTermObjective::create([
            'reduction_goal_id' => $testGoal->id,
            'status' => 'in progress',
            'initial_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(6)->format('Y-m-d'),
            'description' => 'Reduce inappropriate language usage by 80% in all settings',
            'target' => 80
        ]);

        // Add its STOs
        $stos = [
            [
                'description' => 'Use appropriate language in classroom settings',
                'target' => 60
            ],
            [
                'description' => 'Use appropriate language during therapy sessions',
                'target' => 70
            ],
            [
                'description' => 'Use appropriate language in social situations',
                'target' => 80
            ]
        ];

        foreach ($stos as $index => $sto) {
            ShortTermObjective::create([
                'reduction_goal_id' => $testGoal->id,
                'status' => 'in progress',
                'initial_date' => now()->format('Y-m-d'),
                'end_date' => now()->addMonths(3)->format('Y-m-d'),
                'description' => $sto['description'],
                'target' => $sto['target'],
                'order' => $index + 1
            ]);
        }
    }
}
