<?php
namespace Database\Seeders;

use App\Models\Patient\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run()
    {
        $patients = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '123-555-0123',
                'patient_identifier' => 'PAT001',
                'birth_date' => '2015-01-01',
                'gender' => 1,
                'address' => '789 Patient St',
                'city' => 'Miami',
                'state' => 'FL',
                'zip' => '33101',
                'status' => 'active',
                'language' => 'English',
                'parent_guardian_name' => 'Jane Doe',
                'parent_gender' => 2,
                'parent_birth_date' => '1980-01-01',
                'parent_address' => '789 Patient St',
                'parent_city' => 'Miami',
                'parent_state' => 'FL',
                'parent_zip' => '33101',
                'relationship' => 'child',
                'location_id' => 1,
                'insurer_id' => 1,
                'insurance_identifier' => '123456789',
                'rbt_home_id' => 5, // RBT1
                'bcba_home_id' => 3, // BCBA1
                'clin_director_id' => 1, // Clin Director
                'diagnosis_code' => 'F84.0',
                'education' => '2nd Grade',
                'school_name' => 'School of the Future',
                'school_number' => '123456',
                'pos_covered' => ["03", "12"],
                'welcome' => 'yes',
                'consent' => 'yes',
                'insurance_card' => 'yes',
                'mnl' => 'yes',
                'referral' => 'yes',
                'ados' => 'yes',
                'iep' => 'yes',
                'asd_diagnosis' => 'yes',
                'cde' => 'yes',
                'submitted' => 'yes',
                'eligibility' => 'yes',
                'interview' => 'receive',
                'referring_provider_first_name' => 'Jeremy',
                'referring_provider_last_name' => 'Smith',
                'referring_provider_npi' => '1234567890',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@example.com',
                'phone' => '123-555-0124',
                'patient_identifier' => 'PAT002',
                'birth_date' => '2016-02-02',
                'gender' => 2,
                'address' => '987 Patient Ave',
                'city' => 'Orlando',
                'state' => 'FL',
                'zip' => '32801',
                'status' => 'active',
                'language' => 'Spanish',
                'parent_guardian_name' => 'John Smith',
                'parent_gender' => 1,
                'parent_birth_date' => '1980-01-01',
                'parent_address' => '789 Patient St',
                'parent_city' => 'Miami',
                'parent_state' => 'FL',
                'parent_zip' => '33101',
                'relationship' => 'child',
                'location_id' => 2,
                'insurer_id' => 2,
                'insurance_identifier' => '987654321',
                'rbt_home_id' => 6, // RBT2
                'bcba_home_id' => 4, // BCBA2
                'clin_director_id' => 1, // Clin Director
                'diagnosis_code' => 'F84.0',
                'education' => '3rd Grade',
                'school_name' => 'School of the Future',
                'school_number' => '123456',
                'pos_covered' => ["03", "12"],
                'welcome' => 'yes',
                'consent' => 'yes',
                'insurance_card' => 'yes',
                'mnl' => 'yes',
                'referral' => 'yes',
                'ados' => 'yes',
                'iep' => 'yes',
                'asd_diagnosis' => 'yes',
                'cde' => 'yes',
                'submitted' => 'yes',
                'eligibility' => 'yes',
                'interview' => 'pending',
                'referring_provider_first_name' => 'Jeremy',
                'referring_provider_last_name' => 'Smith',
                'referring_provider_npi' => '1234567890',
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
