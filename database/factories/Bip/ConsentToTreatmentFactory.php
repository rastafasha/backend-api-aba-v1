<?php

namespace Database\Factories\Bip;

use App\Models\Bip\Bip;
use App\Models\Bip\ConsentToTreatment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsentToTreatmentFactory extends Factory
{
    protected $model = ConsentToTreatment::class;

    public function definition()
    {
        return [
            'bip_id' => Bip::factory(),
            'analyst_signature' => 'signatures/' . $this->faker->md5() . '.png',
            'analyst_signature_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'parent_guardian_signature' => 'signatures/' . $this->faker->md5() . '.png',
            'parent_guardian_signature_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}