<?php

namespace Database\Factories\Notes;

use App\Models\Notes\NoteBcba;
use App\Models\User;
use App\Models\Bip\Bip;
use App\Models\Insurance\Insurance;
use App\Models\Location;
use App\Models\PaService;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteBcbaFactory extends Factory
{
    protected $model = NoteBcba::class;

    public function definition()
    {
        // random times
        $isMorningSession = $this->faker->boolean;

        return [
            'insurance_id' => Insurance::factory(),
            'patient_id' => \App\Models\Patient\Patient::factory(),
            'patient_identifier' => \App\Models\Patient\Patient::factory(),
            'doctor_id' => User::factory(),
            'bip_id' => Bip::factory(),
            'diagnosis_code' => $this->faker->regexify('[A-Z]{1}[0-9]{2}.[0-9]{1}'),
            'location' => $this->faker->city,
            'meet_with_client_at' => $this->faker->word,
            'session_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'time_in' => $isMorningSession ? $timeIn = $this->faker->dateTimeBetween('00:00:00', '12:00:00')->format('H:i:s') : null,
            'time_out' => $isMorningSession ? $this->faker->dateTimeBetween($timeIn, date('H:i:s', strtotime($timeIn) + 4 * 3600))->format('H:i:s') : null,
            'time_in2' => !$isMorningSession ? $afternoonTime = $this->faker->dateTimeBetween('13:00:00', '15:00:00')->format('H:i:s') : null,
            'time_out2' => !$isMorningSession ? $this->faker->dateTimeBetween($afternoonTime, date('H:i:s', strtotime($afternoonTime) + 4 * 3600))->format('H:i:s') : null,
            'session_length_total' => $this->faker->randomFloat(2, 0.5, 4),
            'note_description' => $this->faker->paragraph,
            'rendering_provider' => User::factory(),
            'supervisor_id' => User::factory(),
            'caregiver_goals' => [
                'goal1' => $this->faker->sentence,
                'goal2' => $this->faker->sentence,
            ],
            'rbt_training_goals' => [
                'goal1' => $this->faker->sentence,
                'goal2' => $this->faker->sentence,
            ],
            'provider_signature' => $this->faker->md5,
            'provider_id' => User::factory(),
            'supervisor_signature' => $this->faker->md5,
            'status' => $this->faker->randomElement(['pending', 'ok', 'no', 'review']),
            'summary_note' => $this->faker->paragraph,
            'billed' => $this->faker->boolean,
            'paid' => $this->faker->boolean,
            'cpt_code' => $this->faker->numerify('####F'),
            'location_id' => Location::factory(),
            'pa_service_id' => PaService::factory(),
        ];
    }

    /**
     * Indicate that the note is billed.
     */
    public function billed()
    {
        return $this->state(function (array $attributes) {
            return [
                'billed' => true,
            ];
        });
    }

    /**
     * Indicate that the note is paid.
     */
    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'paid' => true,
            ];
        });
    }

    /**
     * Set the note status to 'ok'.
     */
    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'ok',
            ];
        });
    }

    /**
     * Set the note status to 'pending'.
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
            ];
        });
    }
}
