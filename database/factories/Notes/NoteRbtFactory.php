<?php

namespace Database\Factories\Notes;

use App\Models\Bip\Bip;
use App\Models\Notes\NoteRbt;
use App\Models\User;
use App\Models\Location;
use App\Models\Insurance\Insurance;
use App\Models\PaService;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteRbtFactory extends Factory
{
    protected $model = NoteRbt::class;

    public function definition()
    {
        $isMorningSession = $this->faker->boolean;

        return [
            'patient_id' => \App\Models\Patient\Patient::factory(),
            'patient_identifier' => \App\Models\Patient\Patient::factory(),
            'provider_id' => User::factory(),
            'supervisor_id' => User::factory(),
            'doctor_id' => User::factory(),
            'location_id' => Location::factory(),
            'insurance_id' => Insurance::factory(),
            'bip_id' => Bip::factory(),
            'session_date' => $this->faker->dateTime(),
            'time_in' => $isMorningSession ? $timeIn = $this->faker->dateTimeBetween('00:00:00', '12:00:00')->format('H:i:s') : null,
            'time_out' => $isMorningSession ? $this->faker->dateTimeBetween($timeIn, date('H:i:s', strtotime($timeIn) + 4 * 3600))->format('H:i:s') : null,
            'time_in2' => !$isMorningSession ? $afternoonTime = $this->faker->dateTimeBetween('13:00:00', '15:00:00')->format('H:i:s') : null,
            'time_out2' => !$isMorningSession ? $this->faker->dateTimeBetween($afternoonTime, date('H:i:s', strtotime($afternoonTime) + 4 * 3600))->format('H:i:s') : null,
            'session_length_total' => $this->faker->randomFloat(2, 0.5, 4),
            'environmental_changes' => $this->faker->sentence,
            'maladaptives' => '[]',
            'replacements' => '[]',
            'interventions' => json_encode(['positive_reinforcement']),
            'meet_with_client_at' => $this->faker->randomElement(['Home', 'Office', 'School']),
            'client_appeared' => $this->faker->sentence,
            'as_evidenced_by' => $this->faker->sentence,
            'rbt_modeled_and_demonstrated_to_caregiver' => $this->faker->sentence,
            'client_response_to_treatment_this_session' => $this->faker->paragraph,
            'progress_noted_this_session_compared_to_previous_session' => $this->faker->sentence,
            'next_session_is_scheduled_for' => $this->faker->dateTimeBetween('now', '+1 week'),
            'provider_signature' => $this->faker->name,
            'provider_credential' => 'RBT',
            'supervisor_signature' => $this->faker->name,
            'status' => $this->faker->randomElement(['pending', 'ok', 'no', 'review']),
            'summary_note' => $this->faker->paragraph,
            'cpt_code' => '97153',
            'billed' => $this->faker->boolean,
            'paid' => $this->faker->boolean,
            'pa_service_id' => PaService::factory(),
        ];
    }
}
