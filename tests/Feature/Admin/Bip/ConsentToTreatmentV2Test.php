<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Bip\ConsentToTreatment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ConsentToTreatmentV2Test extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Bip $bip;
    private ConsentToTreatment $consent;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        
        $this->user = User::factory()->create();
        $this->bip = Bip::factory()->create();
        $this->consent = ConsentToTreatment::factory()->create([
            'bip_id' => $this->bip->id,
            'analyst_signature' => 'signatures/test_analyst.png',
            'analyst_signature_date' => '2024-01-01 10:00:00',
            'parent_guardian_signature' => 'signatures/test_guardian.png',
            'parent_guardian_signature_date' => '2024-01-01 11:00:00'
        ]);
    }

    /** @test */
    public function it_can_list_consent_to_treatments()
    {
        $response = $this->getJson('/api/v2/consent-to-treatments');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'bip_id',
                            'analyst_signature',
                            'analyst_signature_date',
                            'parent_guardian_signature',
                            'parent_guardian_signature_date'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_filter_consents_by_bip_id()
    {
        $response = $this->getJson("/api/v2/consent-to-treatments?bip_id={$this->bip->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonCount(1, 'data.data');
    }

    /** @test */
    public function it_can_create_consent_to_treatment()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'analyst_signature' => 'signatures/new_analyst.png',
            'analyst_signature_date' => '2024-01-15',
            'parent_guardian_signature' => 'signatures/new_guardian.png',
            'parent_guardian_signature_date' => '2024-01-15'
        ];

        $response = $this->postJson('/api/v2/consent-to-treatments', $data);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Consent to treatment created successfully'
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'bip_id',
                    'analyst_signature',
                    'analyst_signature_date',
                    'parent_guardian_signature',
                    'parent_guardian_signature_date'
                ]
            ]);

        $this->assertDatabaseHas('consent_to_treatments', [
            'bip_id' => $this->bip->id,
            'analyst_signature' => 'signatures/new_analyst.png'
        ]);
    }

    /** @test */
    public function it_can_show_consent_to_treatment()
    {
        $response = $this->getJson("/api/v2/consent-to-treatments/{$this->consent->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success'
            ])
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'bip_id',
                    'analyst_signature',
                    'analyst_signature_date',
                    'parent_guardian_signature',
                    'parent_guardian_signature_date'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_for_non_existent_consent()
    {
        $response = $this->getJson('/api/v2/consent-to-treatments/99999');
        
        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Consent to treatment not found'
            ]);
    }

    /** @test */
    public function it_can_update_consent_to_treatment()
    {
        $data = [
            'bip_id' => $this->bip->id,
            'analyst_signature' => 'signatures/updated_analyst.png',
            'analyst_signature_date' => '2024-01-20',
            'parent_guardian_signature' => 'signatures/updated_guardian.png',
            'parent_guardian_signature_date' => '2024-01-20'
        ];

        $response = $this->putJson("/api/v2/consent-to-treatments/{$this->consent->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Consent to treatment updated successfully'
            ])
            ->assertJsonPath('data.analyst_signature', 'signatures/updated_analyst.png');

        $this->assertDatabaseHas('consent_to_treatments', [
            'id' => $this->consent->id,
            'analyst_signature' => 'signatures/updated_analyst.png'
        ]);
    }

    /** @test */
    public function it_can_delete_consent_to_treatment()
    {
        $response = $this->deleteJson("/api/v2/consent-to-treatments/{$this->consent->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Consent to treatment deleted successfully'
            ]);

        $this->assertSoftDeleted('consent_to_treatments', [
            'id' => $this->consent->id
        ]);
    }
}