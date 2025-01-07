<?php

namespace Database\Seeders;

use App\Models\Bip\BipV2;
use App\Models\User;
use App\Models\Bip\Maladaptive;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Database\Seeder;

class MaladaptiveSeeder extends Seeder
{
    public function run()
    {
        // Create a test client if it doesn't exist
        $testClient = User::firstOrCreate(
            ['id' => 1],
            User::factory()->make()->toArray()
        );

        // Create a test BIP if it doesn't exist
        $testBip = BipV2::firstOrCreate(
            ['id' => 1],
            BipV2::factory()->make()->toArray()
        );

        $maladaptives = [
            [
                'id' => 1,
                'bip_id' => $testBip->id,
                'name' => 'Aggressive Behavior',
                'description' => 'Displays aggressive behavior towards others including hitting, kicking, and pushing',
                'baseline_level' => 7,
                'baseline_date' => '2025-01-02 12:40:04',
                'initial_intensity' => 8,
                'current_intensity' => 6,
                'status' => 'active'
            ],
            [
                'id' => 2,
                'bip_id' => $testBip->id,
                'name' => 'Self-Injurious Behavior',
                'description' => 'Engages in self-harming behaviors such as head banging and biting self',
                'baseline_level' => 5,
                'baseline_date' => '2025-01-02 12:40:04',
                'initial_intensity' => 6,
                'current_intensity' => 4,
                'status' => 'active'
            ],
            [
                'id' => 3,
                'bip_id' => $testBip->id,
                'name' => 'Property Destruction',
                'description' => 'Deliberately damages or destroys property in the environment',
                'baseline_level' => 6,
                'baseline_date' => '2025-01-02 12:40:04',
                'initial_intensity' => 7,
                'current_intensity' => 5,
                'status' => 'monitoring'
            ]
        ];

        foreach ($maladaptives as $maladaptiveData) {
            $maladaptive = Maladaptive::create($maladaptiveData);

            // Create LTO for each maladaptive (not started, no dates)
            LongTermObjective::create([
                'maladaptive_id' => $maladaptive->id,
                'status' => 'not started',
                'description' => 'Long term reduction of frequency of ' . $maladaptive->name . ' to 0 per week across all settings',
                'target' => 0
            ]);

            // Create 4 STOs with progressive status
            $baseDate = now()->subMonths(2);

            // First STO - Mastered with completed dates
            ShortTermObjective::create([
                'maladaptive_id' => $maladaptive->id,
                'status' => 'mastered',
                'initial_date' => $baseDate->format('Y-m-d'),
                'end_date' => $baseDate->addMonths(1)->format('Y-m-d'),
                'description' => 'First phase reduction of ' . $maladaptive->name,
                'target' => 40,
                'order' => 1
            ]);

            // Second STO - In Progress with only initial date
            ShortTermObjective::create([
                'maladaptive_id' => $maladaptive->id,
                'status' => 'in progress',
                'initial_date' => $baseDate->format('Y-m-d'),
                'description' => 'Second phase reduction of ' . $maladaptive->name,
                'target' => 30,
                'order' => 2
            ]);

            // Third and Fourth STOs - Not Started, no dates
            for ($i = 3; $i <= 4; $i++) {
                ShortTermObjective::create([
                    'maladaptive_id' => $maladaptive->id,
                    'status' => 'not started',
                    'description' => 'Phase ' . $i . ' reduction of ' . $maladaptive->name,
                    'target' => 40 - ($i * 10),
                    'order' => $i
                ]);
            }
        }

        // Create a specific example maladaptive for testing
        $testMaladaptive = Maladaptive::create([
            'bip_id' => $testBip->id,
            'name' => 'Inappropriate Language',
            'description' => 'Uses inappropriate or offensive language in various settings',
            'baseline_level' => 8,
            'baseline_date' => '2025-01-02 12:40:04',
            'initial_intensity' => 8,
            'current_intensity' => 6,
            'status' => 'active'
        ]);

        // Add its LTO (not started)
        LongTermObjective::create([
            'maladaptive_id' => $testMaladaptive->id,
            'status' => 'not started',
            'description' => 'Reduce inappropriate language usage to 0 per week in all settings',
            'target' => 0
        ]);

        // Base date for the progression
        $baseDate = now()->subMonths(1);

        // Add STOs with progression
        $stos = [
            [
                'status' => 'mastered',
                'initial_date' => $baseDate->format('Y-m-d'),
                'end_date' => $baseDate->addWeeks(2)->format('Y-m-d'),
                'description' => 'Reduce inappropriate language to less than 5 instances per day',
                'target' => 5,
                'order' => 1
            ],
            [
                'status' => 'in progress',
                'initial_date' => $baseDate->format('Y-m-d'),
                'description' => 'Reduce inappropriate language to less than 3 instances per day',
                'target' => 3,
                'order' => 2
            ],
            [
                'status' => 'not started',
                'description' => 'Reduce inappropriate language to 1 instance per day',
                'target' => 1,
                'order' => 3
            ],
            [
                'status' => 'not started',
                'description' => 'Eliminate inappropriate language across all settings',
                'target' => 0,
                'order' => 4
            ]
        ];

        foreach ($stos as $sto) {
            ShortTermObjective::create(array_merge($sto, [
                'maladaptive_id' => $testMaladaptive->id
            ]));
        }
    }
}
