<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\Plan;
use App\Models\Bip\Objective;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    private function createObjectivesForPlan($plan, $baselineLevel = null)
    {
        if (in_array($plan->category, ['maladaptive', 'replacement'])) {
            $isMaladaptive = $plan->category === 'maladaptive';
            $baselineLevel = $baselineLevel ?? ($isMaladaptive ? 40 : 20);

            // For maladaptive: we want to reduce from baseline to 0
            // For replacement: we want to increase from baseline to 100
            $targetSteps = $isMaladaptive
                ? [
                    round($baselineLevel * 0.75), // 25% reduction
                    round($baselineLevel * 0.5),  // 50% reduction
                    round($baselineLevel * 0.25), // 75% reduction
                    0                             // complete elimination
                ]
                : [
                    min(100, round($baselineLevel * 1.5)),  // 50% improvement
                    min(100, round($baselineLevel * 2.0)),  // 100% improvement
                    min(100, round($baselineLevel * 2.5)),  // 150% improvement
                    100                                      // complete mastery
                ];

            $startPointSteps = $isMaladaptive ? [
                $baselineLevel,
                $baselineLevel * 0.75,
                $baselineLevel * 0.5,
                $baselineLevel * 0.25,
                0
            ] : [
                0,
                $baselineLevel * 0.25,
                $baselineLevel * 0.5,
                $baselineLevel * 0.75,
                100
            ];

            // Create LTO
            $ltoDescription = $isMaladaptive
                ? "Long term reduction of {$plan->name} to 0 occurrences across all settings"
                : "Long term improvement of {$plan->name} to achieve 100% mastery across all settings";

            $ltoTarget = $isMaladaptive ? 0 : 100;

            Objective::create([
                'plan_id' => $plan->id,
                'type' => 'LTO',
                'status' => 'not started',
                'description' => $ltoDescription,
                'target' => $ltoTarget,
                'initial_date' => now()->addMonths(6)->format('Y-m-d'),
                'end_date' => now()->addYear()->format('Y-m-d'),
                'order' => 999
            ]);

            // Create STOs with progressive targets
            foreach ($targetSteps as $index => $target) {
                $baseDate = now()->addMonths($index * 2);
                $status = $index === 0 ? 'in progress' : 'not started';

                Objective::create([
                    'plan_id' => $plan->id,
                    'type' => 'STO',
                    'status' => $status,
                    'description' => "Phase " . ($index + 1) . " " .
                        ($isMaladaptive ? "reduction" : "improvement") .
                        " of {$plan->name}" .
                        ($isMaladaptive
                            ? " to {$target} occurrences or less"
                            : " to achieve {$target}% success rate"),
                    'target' => $target,
                    'start_point' => $startPointSteps[$index],
                    'initial_date' => $baseDate->format('Y-m-d'),
                    'end_date' => $baseDate->addMonths(2)->subDay()->format('Y-m-d'),
                    'order' => $index + 1
                ]);
            }
        } else {
            // For caregiver and RBT training plans
            Objective::create([
                'plan_id' => $plan->id,
                'type' => 'LTO',
                'status' => 'not started',
                'description' => "Achieve full competency in {$plan->name}",
                'target' => 100,
                'initial_date' => now()->format('Y-m-d'),
                'end_date' => now()->addMonths(3)->format('Y-m-d'),
                'order' => 999
            ]);

            $phases = [
                ['name' => 'Introduction', 'target' => 33],
                ['name' => 'Practice', 'target' => 66],
                ['name' => 'Mastery', 'target' => 100]
            ];

            foreach ($phases as $index => $phase) {
                $baseDate = now()->addMonths($index);
                Objective::create([
                    'plan_id' => $plan->id,
                    'type' => 'STO',
                    'status' => $index === 0 ? 'in progress' : 'not started',
                    'description' => "{$phase['name']} phase of {$plan->name}",
                    'target' => $phase['target'],
                    'initial_date' => $baseDate->format('Y-m-d'),
                    'end_date' => $baseDate->addMonth()->subDay()->format('Y-m-d'),
                    'order' => $index + 1
                ]);
            }
        }
    }

    public function run()
    {
        // Get both BIPs created by BipSeeder
        $bips = Bip::take(2)->get();
        $nextPlanId = 11; // Starting ID to avoid conflicts with BipSeeder

        foreach ($bips as $bip) {
            // Maladaptive behaviors with realistic baselines
            $maladaptivePlans = [
                [
                    'name' => 'Aggressive Behavior',
                    'description' => 'Displays aggressive behavior towards others including hitting, kicking, and pushing',
                    'baseline_level' => 35,
                    'baseline_date' => now()->subDays(7)->format('Y-m-d'),
                    'initial_intensity' => 8,
                    'current_intensity' => 6,
                ],
                [
                    'name' => 'Self-Injurious Behavior',
                    'description' => 'Engages in self-harming behaviors such as head banging and biting self',
                    'baseline_level' => 42,
                    'baseline_date' => now()->subDays(7)->format('Y-m-d'),
                    'initial_intensity' => 7,
                    'current_intensity' => 5,
                ],
                [
                    'name' => 'Property Destruction',
                    'description' => 'Deliberately damages or destroys property in the environment',
                    'baseline_level' => 28,
                    'baseline_date' => now()->subDays(7)->format('Y-m-d'),
                    'initial_intensity' => 6,
                    'current_intensity' => 4,
                ]
            ];

            // Replacement behaviors with realistic baselines
            $replacementPlans = [
                [
                    'name' => 'Communication Skills',
                    'description' => 'Uses appropriate communication methods to express needs and feelings',
                    'baseline_level' => 15,
                    'baseline_date' => now()->subDays(7)->format('Y-m-d'),
                    'initial_intensity' => 2,
                    'current_intensity' => 3,
                ],
                [
                    'name' => 'Self-Regulation',
                    'description' => 'Uses coping strategies to manage emotions and behaviors',
                    'baseline_level' => 25,
                    'baseline_date' => now()->subDays(7)->format('Y-m-d'),
                    'initial_intensity' => 3,
                    'current_intensity' => 4,
                ],
                [
                    'name' => 'Social Interaction',
                    'description' => 'Engages in appropriate social interactions with peers',
                    'baseline_level' => 20,
                    'baseline_date' => now()->subDays(7)->format('Y-m-d'),
                    'initial_intensity' => 2,
                    'current_intensity' => 3,
                ]
            ];

            // Create plans for each category
            foreach ($maladaptivePlans as $planData) {
                $plan = Plan::create([
                    'id' => $nextPlanId++,
                    'bip_id' => $bip->id,
                    'category' => 'maladaptive',
                    'status' => 'active',
                ] + $planData);

                $this->createObjectivesForPlan($plan, $planData['baseline_level']);
            }

            foreach ($replacementPlans as $planData) {
                $plan = Plan::create([
                    'id' => $nextPlanId++,
                    'bip_id' => $bip->id,
                    'category' => 'replacement',
                    'status' => 'active',
                ] + $planData);

                $this->createObjectivesForPlan($plan, $planData['baseline_level']);
            }

            // Caregiver training plans
            $caregiverPlans = [
                [
                    'name' => 'Behavior Management Techniques',
                    'description' => 'Training on implementing behavior management strategies effectively',
                ],
                [
                    'name' => 'Crisis Prevention',
                    'description' => 'Training on identifying triggers and preventing crisis situations',
                ]
            ];

            foreach ($caregiverPlans as $planData) {
                $plan = Plan::create([
                    'id' => $nextPlanId++,
                    'bip_id' => $bip->id,
                    'category' => 'caregiver_training',
                    'status' => 'active',
                ] + $planData);

                $this->createObjectivesForPlan($plan);
            }

            // RBT training plans
            $rbtPlans = [
                [
                    'name' => 'Data Collection Training',
                    'description' => 'Training on accurate data collection and documentation methods',
                ],
                [
                    'name' => 'Intervention Implementation',
                    'description' => 'Training on implementing behavioral interventions consistently',
                ]
            ];

            foreach ($rbtPlans as $planData) {
                $plan = Plan::create([
                    'id' => $nextPlanId++,
                    'bip_id' => $bip->id,
                    'category' => 'rbt_training',
                    'status' => 'active',
                ] + $planData);

                $this->createObjectivesForPlan($plan);
            }
        }
    }
}
