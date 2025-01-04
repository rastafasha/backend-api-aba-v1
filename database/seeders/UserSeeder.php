<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Old Superadmin
        $oldSuperadmin = User::create([
            'name' => 'Old Super Admin',
            'email' => 'superadmin@superadmin.com',
            'password' => Hash::make('superadmin'),
            'status' => 'active',
            'email_verified_at' => now(),
            'gender' => 1,
            'location_id' => 1,
            'npi' => '1111234567',
        ]);
        $oldSuperadmin->assignRole('SUPERADMIN');

        // Create superadmin
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
            'gender' => 1,
            'location_id' => 1,
            'npi' => '1245319599',
        ]);
        $superadmin->assignRole('SUPERADMIN');

        // Create manager
        $manager = User::create([
            'name' => 'John Manager',
            'surname' => 'Doe',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'gender' => 1,
            'email_verified_at' => now(),
            'electronic_signature' => 'signatures/example.png',
            'location_id' => 1,
            'npi' => '1497842694',
        ]);
        $manager->assignRole('MANAGER');

        // Create BCBAs
        $bcba1 = User::create([
            'name' => 'Sarah BCBA',
            'surname' => 'Howard',
            'email' => 'bcba1@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'gender' => 2,
            'phone' => '1234567890',
            'npi' => '3309871234',
            'certificate_number' => 'BCBA12345',
            'electronic_signature' => 'signatures/example.png',
            'location_id' => 1,
        ]);
        $bcba1->assignRole('BCBA');

        $bcba2 = User::create([
            'name' => 'Mike BCBA',
            'surname' => 'Smith',
            'email' => 'bcba2@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'gender' => 1,
            'phone' => '1234567891',
            'npi' => '3333312334',
            'certificate_number' => 'BCBA12346',
            'electronic_signature' => 'signatures/example.png',
            'location_id' => 1,
        ]);
        $bcba2->assignRole('BCBA');

        // Create RBTs
        $rbt1 = User::create([
            'name' => 'Alice RBT',
            'surname' => 'Brown',
            'email' => 'rbt1@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'gender' => 2,
            'phone' => '1234567892',
            'npi' => '3333345454',
            'certificate_number' => 'RBT12345',
            'electronic_signature' => 'signatures/example.png',
            'location_id' => 1,
        ]);
        $rbt1->assignRole('RBT');

        $rbt2 = User::create([
            'name' => 'Bob RBT',
            'surname' => 'Johnson',
            'email' => 'rbt2@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'gender' => 1,
            'phone' => '1234567893',
            'certificate_number' => 'RBT12346',
            'npi' => '5421369874',
            'electronic_signature' => 'signatures/example.png',
            'location_id' => 1,
        ]);
        $rbt2->assignRole('RBT');
    }
}
