<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            LocationSeeder::class,
            InsuranceSeeder::class,
            UserSeeder::class,
            PatientSeeder::class,
            PaServicesSeeder::class,
            BipSeeder::class,
            NotesSeeder::class,
            FamilyEnvolvementsSeeder::class,
            ReductionGoalSeeder::class,
            UserLocationsSeeder::class,

        ]);

    }
}
