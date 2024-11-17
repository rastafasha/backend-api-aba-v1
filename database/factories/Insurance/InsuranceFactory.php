<?php

namespace Database\Factories\Insurance;

use App\Models\Insurance\Insurance;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsuranceFactory extends Factory
{
    protected $model = Insurance::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company . ' Insurance',
            'services' => [
                'code' => $this->faker->randomElement(['97153', '97154', '97155']),
                'provider' => $this->faker->randomElement(['BCBA', 'RBT', 'BCaBA']),
                'description' => $this->faker->sentence,
                'unit_price' => $this->faker->randomFloat(2, 50, 200),
                'hourly_fee' => $this->faker->randomFloat(2, 100, 400),
                'max_allowed' => $this->faker->numberBetween(20, 60)
            ],
            'notes' => [
                'description' => $this->faker->paragraph
            ],
            'payer_id' => $this->faker->numerify('#####'),
            'street' => $this->faker->streetAddress,
            'street2' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
        ];
    }
}