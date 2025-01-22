<?php

namespace Tests\Feature\Admin\Bip;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bip\Bip;
use Illuminate\Support\Facades\DB;
use App\Models\Patient\Patient;
use Spatie\Permission\Models\Role;
use App\DataTransferObjects\PhysicalMedicalRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhysicalMedicalRecordTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Patient $patient;
    private array $validPhysicalMedicalData;

    protected function setUp(): void
    {
        parent::setUp();

        // Create and assign admin role
        Role::create(['name' => 'admin']);
        $this->user = User::factory()->create();
        $this->user->assignRole('admin');

        $this->patient = Patient::factory()->create();

        $this->validPhysicalMedicalData = [
            [
                'index' => 1,
                'medication' => 'Methylphenidate',
                'dose' => '10mg',
                'frecuency' => 'Twice daily',
                'reason' => 'ADHD management',
                'preescribing_physician' => 'Dr. Smith'
            ],
            [
                'index' => 2,
                'medication' => 'Sertraline',
                'dose' => '50mg',
                'frecuency' => 'Once daily',
                'reason' => 'Anxiety management',
                'preescribing_physician' => 'Dr. Johnson'
            ]
        ];
    }

    /** @test */
    public function it_can_create_bip_with_physical_medical_records()
    {
        $response = $this->actingAs($this->user)->postJson('/api/v2/bips', [
            'type_of_assessment' => 1,
            'client_id' => $this->patient->id,
            'patient_identifier' => 'TEST123',
            'physical_and_medical' => $this->validPhysicalMedicalData
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bips', ['id' => $response->json('data.id')]);

        $bip = Bip::find($response->json('data.id'));
        $this->assertCount(2, $bip->physical_and_medical);
        $this->assertInstanceOf(PhysicalMedicalRecord::class, $bip->physical_and_medical[0]);
        $this->assertEquals('Methylphenidate', $bip->physical_and_medical[0]->medication);
    }

    /** @test */
    public function it_validates_physical_medical_record_structure()
    {
        $invalidData = [
            [
                'index' => 1,
                'medication' => 'Methylphenidate',
                // missing required fields
            ]
        ];

        $response = $this->actingAs($this->user)->postJson('/api/v2/bips', [
            'type_of_assessment' => 1,
            'client_id' => $this->patient->id,
            'patient_identifier' => 'TEST123',
            'physical_and_medical' => $invalidData
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['physical_and_medical.0.dose', 'physical_and_medical.0.frecuency']);
    }

    /** @test */
    public function it_can_update_physical_medical_records()
    {
        // Create initial BIP
        $bip = Bip::create([
            'type_of_assessment' => 1,
            'client_id' => $this->patient->id,
            'patient_identifier' => 'TEST123',
            'physical_and_medical' => [$this->validPhysicalMedicalData[0]]
        ]);

        // Update with new records
        $response = $this->actingAs($this->user)->putJson("/api/v2/bips/{$bip->id}", [
            'type_of_assessment' => 1,
            'client_id' => $this->patient->id,
            'physical_and_medical' => $this->validPhysicalMedicalData
        ]);

        $response->assertStatus(200);
        $this->assertCount(2, $bip->fresh()->physical_and_medical);
        $this->assertEquals('Sertraline', $bip->fresh()->physical_and_medical[1]->medication);
    }

    /** @test */
    public function it_handles_null_physical_medical_records()
    {
        $response = $this->actingAs($this->user)->postJson('/api/v2/bips', [
            'type_of_assessment' => 1,
            'client_id' => $this->patient->id,
            'patient_identifier' => 'TEST123',
            'physical_and_medical' => null
        ]);

        $response->assertStatus(201);
        $bip = Bip::find($response->json('data.id'));
        $this->assertEmpty($bip->physical_and_medical);
    }

    /** @test */
    public function it_casts_physical_medical_records_correctly()
    {
        $bip = Bip::create([
            'type_of_assessment' => 1,
            'client_id' => $this->patient->id,
            'patient_identifier' => 'TEST123',
            'physical_and_medical' => $this->validPhysicalMedicalData
        ]);

        // Test that records are cast to PhysicalMedicalRecord objects
        $this->assertInstanceOf(PhysicalMedicalRecord::class, $bip->physical_and_medical[0]);

        // Test that records maintain their data after being cast
        $this->assertEquals('Methylphenidate', $bip->physical_and_medical[0]->medication);
        $this->assertEquals('10mg', $bip->physical_and_medical[0]->dose);

        // Test that records are stored as JSON in the database
        $rawBip = DB::table('bips')->where('id', $bip->id)->first();
        $this->assertJson($rawBip->physical_and_medical);

        // Test that JSON can be decoded back to the original structure
        $decodedRecords = json_decode($rawBip->physical_and_medical, true);
        $this->assertEquals($this->validPhysicalMedicalData[0]['medication'], $decodedRecords[0]['medication']);
    }
}
