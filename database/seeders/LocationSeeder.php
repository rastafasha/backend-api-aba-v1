<?php
namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            [
                'title' => 'Main Office',
                'city' => 'Miami',
                'state' => 'FL',
                'zip' => '33101',
                'address' => '123 Main St',
                'email' => 'main@example.com',
                'phone1' => '305-555-0123',
                'phone2' => '305-555-0124',
                'telfax' => '305-555-0125'
            ],
            [
                'title' => 'Branch Office',
                'city' => 'Orlando',
                'state' => 'FL',
                'zip' => '32801',
                'address' => '456 Branch Ave',
                'email' => 'orlando@example.com',
                'phone1' => '407-555-0123',
                'phone2' => '407-555-0124',
                'telfax' => '407-555-0125'
            ],
            [
                'title' => 'South Miami Center',
                'city' => 'Miami',
                'state' => 'FL',
                'zip' => '33143',
                'address' => '789 Treatment Blvd',
                'email' => 'south@example.com',
                'phone1' => '305-555-0126',
                'phone2' => '305-555-0127',
                'telfax' => '305-555-0128'
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
