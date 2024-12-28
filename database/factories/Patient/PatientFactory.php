<?php

namespace Database\Factories\Patient;

use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement([1, 2]),
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'status' => 'active',
            'patient_identifier' => $this->faker->unique()->uuid,
            'language' => $this->faker->languageCode,
            'parent_guardian_name' => $this->faker->name,
            'relationship' => $this->faker->randomElement(['Parent', 'Guardian', 'Other']),
            'home_phone' => $this->faker->phoneNumber,
            'work_phone' => $this->faker->phoneNumber,
            'school_name' => $this->faker->company,
            'school_number' => $this->faker->phoneNumber,
            'special_note' => $this->faker->text(100),
            'telehealth' => $this->faker->randomElement(['true', 'false']),
            'referring_provider_first_name' => $this->faker->firstName,
            'referring_provider_last_name' => $this->faker->lastName,
            'referring_provider_npi' => $this->faker->randomNumber(9, true),
            'npi' => $this->faker->randomNumber(9, true),
        ];
    }
}
