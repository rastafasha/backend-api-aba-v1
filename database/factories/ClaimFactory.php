<?php

namespace Database\Factories;

use App\Models\Claim;
use App\Models\Notes\NoteBcba;
use App\Models\Notes\NoteRbt;
use App\Services\ClaimsService;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClaimFactory extends Factory
{
    protected $model = Claim::class;

    public function definition()
    {
        // Create some random RBT and BCBA notes
        $rbtNotes = NoteRbt::factory()->count(2)->create();
        $bcbaNotes = NoteBcba::factory()->count(1)->create();

        // Get their IDs
        $rbtNotesIds = $rbtNotes->pluck('id')->toArray();
        $bcbaNotesIds = $bcbaNotes->pluck('id')->toArray();

        // Generate the claim content using the ClaimsService
        $claimsService = app(ClaimsService::class);
        $content = $claimsService->generateFromNotes($rbtNotesIds, $bcbaNotesIds);

        return [
            'status' => $this->faker->randomElement(['pending', 'sent', 'processed', 'rejected']),
            'rbt_notes_ids' => $rbtNotesIds,
            'bcba_notes_ids' => $bcbaNotesIds,
            'filename' => $this->faker->randomElement(['Claim.dat', 'EDI837.dat', 'ClaimFile.dat']),
            'content' => $content,
        ];
    }

    /**
     * Configure the factory to create a claim with only RBT notes
     */
    public function withRbtNotesOnly(int $count = 2)
    {
        return $this->state(function (array $attributes) use ($count) {
            $rbtNotes = NoteRbt::factory()->count($count)->create();
            $rbtNotesIds = $rbtNotes->pluck('id')->toArray();

            $claimsService = app(ClaimsService::class);
            $content = $claimsService->generateFromNotes($rbtNotesIds, []);

            return [
                'rbt_notes_ids' => $rbtNotesIds,
                'bcba_notes_ids' => [],
                'content' => $content,
            ];
        });
    }

    /**
     * Configure the factory to create a claim with only BCBA notes
     */
    public function withBcbaNotesOnly(int $count = 2)
    {
        return $this->state(function (array $attributes) use ($count) {
            $bcbaNotes = NoteBcba::factory()->count($count)->create();
            $bcbaNotesIds = $bcbaNotes->pluck('id')->toArray();

            $claimsService = app(ClaimsService::class);
            $content = $claimsService->generateFromNotes([], $bcbaNotesIds);

            return [
                'rbt_notes_ids' => [],
                'bcba_notes_ids' => $bcbaNotesIds,
                'content' => $content,
            ];
        });
    }

    /**
     * Configure the factory to create a claim with specific status
     */
    public function withStatus(string $status)
    {
        return $this->state(function (array $attributes) use ($status) {
            return [
                'status' => $status,
            ];
        });
    }
}
