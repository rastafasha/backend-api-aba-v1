<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create superadmin
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
            'gender' => 1,
        ]);
        $superadmin->assignRole('SUPERADMIN');

        // Create manager
        $manager = User::create([
            'name' => 'John Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
            'gender' => 1,
        ]);
        $manager->assignRole('MANAGER');

        // Create BCBAs
        $bcba1 = User::create([
            'name' => 'Sarah BCBA',
            'email' => 'bcba1@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'gender' => 2,
            'phone' => '1234567890',
            'npi' => '1234567890',
            'certificate_number' => 'BCBA12345',
        ]);
        $bcba1->assignRole('BCBA');

        $bcba2 = User::create([
            'name' => 'Mike BCBA',
            'email' => 'bcba2@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'gender' => 1,
            'phone' => '1234567891',
            'npi' => '1234567891',
            'certificate_number' => 'BCBA12346',
        ]);
        $bcba2->assignRole('BCBA');

        // Create RBTs
        $rbt1 = User::create([
            'name' => 'Alice RBT',
            'email' => 'rbt1@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'gender' => 2,
            'phone' => '1234567892',
            'certificate_number' => 'RBT12345',
        ]);
        $rbt1->assignRole('RBT');

        $rbt2 = User::create([
            'name' => 'Bob RBT',
            'email' => 'rbt2@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'gender' => 1,
            'phone' => '1234567893',
            'certificate_number' => 'RBT12346',
        ]);
        $rbt2->assignRole('RBT');

        // Assign users to locations
        foreach (User::all() as $user) {
            UserLocation::create([
                'user_id' => $user->id,
                'location_id' => 1 // Main office
            ]);
        }
    }
}
