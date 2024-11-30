<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_locations')->insert([
            ['id' => 1, 'user_id' => 1, 'location_id' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 2, 'user_id' => 2, 'location_id' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 3, 'user_id' => 3, 'location_id' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 4, 'user_id' => 4, 'location_id' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 5, 'user_id' => 5, 'location_id' => 1, 'created_at' => null, 'updated_at' => null],
            ['id' => 6, 'user_id' => 6, 'location_id' => 1, 'created_at' => null, 'updated_at' => null],
        ]);
    }
}
