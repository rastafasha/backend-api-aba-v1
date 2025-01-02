<?php

namespace Database\Seeders;

use App\Models\Bip\BipV2;
use App\Models\User;
use App\Models\Bip\Replacement;
use App\Models\Bip\LongTermObjective;
use App\Models\Bip\ShortTermObjective;
use Illuminate\Database\Seeder;

class ReplacementSeeder extends Seeder
{
    public function run()
    {
        // Create a test client if it doesn't exist
        $testClient = User::firstOrCreate(
            ['id' => 1],
            array_merge(User::factory()->make()->toArray(), [
                'password' => bcrypt('password')
            ])
        );

        // Create a test BIP if it doesn't exist
        $testBip = BipV2::firstOrCreate(
            ['id' => 1],
            BipV2::factory()->make()->toArray()
        );

        $replacements = [
            [
                'id' => 1,
                'bip_id' => $testBip->id,
                'name' => 'Communication Skills',
                'description' => 'Uses appropriate communication methods to express needs and feelings',
                'baseline_level' => 3,
                'baseline_date' => '2025-01-02 12:40:04',
                'initial_intensity' => 2,
                'current_intensity' => 4,
                'status' => 'active'
            ],
            [
                'id' => 2,
                'bip_id' => $testBip->id,
                'name' => 'Self-Regulation',
                'description' => 'Uses coping strategies to manage emotions and behaviors',
                'baseline_level' => 2,
                'baseline_date' => '2025-01-02 12:40:04',
                'initial_intensity' => 3,
                'current_intensity' => 5,
                'status' => 'active'
            ],
            [
                'id' => 3,
                'bip_id' => $testBip->id,
                'name' => 'Social Interaction',
                'description' => 'Engages in appropriate social interactions with peers',
                'baseline_level' => 4,
                'baseline_date' => '2025-01-02 12:40:04',
                'initial_intensity' => 3,
                'current_intensity' => 6,
                'status' => 'monitoring'
            ]
        ];

        foreach ($replacements as $replacementData) {
            $replacement = Replacement::create($replacementData);

            // Create LTO for each replacement (not started, no dates)
            LongTermObjective::create([
                'replacement_id' => $replacement->id,
                'status' => 'not started',
                'description' => 'Long term improvement of ' . $replacement->name . ' to achieve mastery across all settings',
                'target' => 100
            ]);

            // Create 4 STOs with progressive status
            $baseDate = now()->subMonths(2);

            // First STO - Mastered with completed dates
            ShortTermObjective::create([
                'replacement_id' => $replacement->id,
                'status' => 'mastered',
                'initial_date' => $baseDate->format('Y-m-d'),
                'end_date' => $baseDate->addMonths(1)->format('Y-m-d'),
                'description' => 'First phase improvement of ' . $replacement->name,
                'target' => 25,
                'order' => 1
            ]);

            // Second STO - Mastered with completed dates
            ShortTermObjective::create([
                'replacement_id' => $replacement->id,
                'status' => 'mastered',
                'initial_date' => $baseDate->format('Y-m-d'),
                'end_date' => $baseDate->addMonths(1)->format('Y-m-d'),
                'description' => 'Second phase improvement of ' . $replacement->name,
                'target' => 50,
                'order' => 2
            ]);

            // Third STO - In progress with start date
            ShortTermObjective::create([
                'replacement_id' => $replacement->id,
                'status' => 'in progress',
                'initial_date' => $baseDate->format('Y-m-d'),
                'description' => 'Third phase improvement of ' . $replacement->name,
                'target' => 75,
                'order' => 3
            ]);

            // Fourth STO - Not started, no dates
            ShortTermObjective::create([
                'replacement_id' => $replacement->id,
                'status' => 'not started',
                'description' => 'Final phase improvement of ' . $replacement->name,
                'target' => 100,
                'order' => 4
            ]);
        }

        // Create a specific example replacement for testing
        $testReplacement = Replacement::create([
            'bip_id' => $testBip->id,
            'name' => 'Appropriate Language',
            'description' => 'Uses appropriate language to communicate needs and feelings',
            'baseline_level' => 2,
            'baseline_date' => '2025-01-02 12:40:04',
            'initial_intensity' => 2,
            'current_intensity' => 4,
            'status' => 'active'
        ]);

        // Add its LTO (not started)
        LongTermObjective::create([
            'replacement_id' => $testReplacement->id,
            'status' => 'not started',
            'description' => 'Achieve consistent use of appropriate language in all settings',
            'target' => 100
        ]);

        // Base date for the progression
        $baseDate = now()->subMonths(1);

        // Create STOs with different statuses
        $stos = [
            [
                'status' => 'mastered',
                'initial_date' => $baseDate->format('Y-m-d'),
                'end_date' => $baseDate->addWeeks(2)->format('Y-m-d'),
                'description' => 'Use appropriate language 25% of opportunities',
                'target' => 25,
                'order' => 1
            ],
            [
                'status' => 'in progress',
                'initial_date' => $baseDate->format('Y-m-d'),
                'description' => 'Use appropriate language 50% of opportunities',
                'target' => 50,
                'order' => 2
            ],
            [
                'status' => 'not started',
                'description' => 'Use appropriate language 75% of opportunities',
                'target' => 75,
                'order' => 3
            ],
            [
                'status' => 'not started',
                'description' => 'Use appropriate language 100% of opportunities',
                'target' => 100,
                'order' => 4
            ]
        ];

        foreach ($stos as $sto) {
            ShortTermObjective::create(array_merge($sto, [
                'replacement_id' => $testReplacement->id
            ]));
        }
    }
}
