<?php

namespace App\Http\Requests\Notes;

use App\Http\Requests\Notes\Traits\ValidatesTimeOverlap;
use App\Http\Requests\Notes\Traits\ValidatesTimeLimits;
use App\Http\Requests\Notes\Traits\ValidatesBackdatedNotes;
use Illuminate\Foundation\Http\FormRequest;

class NoteRbtRequest extends FormRequest
{
    use ValidatesTimeOverlap;
    use ValidatesTimeLimits;
    use ValidatesBackdatedNotes;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'insurance_id' => 'nullable|exists:insurances,id',
            'patient_id' => 'required|exists:patients,id',
            'patient_identifier' => 'nullable|string',
            'doctor_id' => 'nullable|exists:users,id',
            'pa_service_id' => 'required|exists:pa_services,id',
            'bip_id' => 'nullable|exists:bips,id',
            'pos' => 'nullable|string',
            'session_date' => 'required|date|before:tomorrow',
            'participants' => 'nullable|string',
            'time_in' => 'nullable|date_format:H:i,H:i:s',
            'time_out' => 'nullable|date_format:H:i,H:i:s|after:time_in',
            'time_in2' => 'nullable|date_format:H:i,H:i:s',
            'time_out2' => 'nullable|date_format:H:i,H:i:s|after:time_in2',
            'environmental_changes' => 'nullable|string',
            'maladaptives' => 'nullable|array',
            'maladaptives.*.id' => 'nullable|exists:plans,id',
            'maladaptives.*.name' => 'required|string',
            'maladaptives.*.ocurrences' => 'required|integer',
            'replacements' => 'nullable|array',
            'replacements.*.id' => 'required|exists:plans,id',
            'replacements.*.name' => 'required|string',
            'replacements.*.total_trials' => 'required|integer',
            'replacements.*.correct_responses' => 'required|integer',
            'interventions' => 'nullable|array',
            'interventions.*' => 'string',
            'meet_with_client_at' => 'nullable|string',
            'client_appeared' => 'nullable|string',
            'as_evidenced_by' => 'nullable|string',
            'rbt_modeled_and_demonstrated_to_caregiver' => 'nullable|string',
            'client_response_to_treatment_this_session' => 'nullable|string',
            'progress_noted_this_session_compared_to_previous_session' => 'nullable|string',
            'next_session_is_scheduled_for' => 'nullable|date|after:session_date',
            'provider_id' => 'nullable|exists:users,id',
            'provider_signature' => 'nullable|string',
            'provider_credential' => 'nullable|string',
            'supervisor_signature' => 'nullable|string',
            // 'supervisor_name' => 'nullable|exists:users,id',
            'billed' => 'boolean',
            'paid' => 'boolean',
            'cpt_code' => 'nullable|string',
            'status' => 'nullable|in:pending,ok,no,review',
            'location_id' => 'nullable|exists:locations,id',
            'insuranceId' => 'nullable|string',
            'insurance_identifier' => 'nullable|string',
            'supervisor_id' => 'nullable|exists:users,id',
            'summary_note' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'session_date.before' => 'Oops! It looks like you’re trying to save a session note with a future date. '
            . 'Please ensure the date and time are accurate before saving.',
            'next_session_is_scheduled_for.after' => 'Oops! It looks like you’re trying to save a next session date that is before the current session date. '
            . 'Please ensure the date and time are accurate before saving.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('session_date')) {
            $this->merge([
                'session_date' => date('Y-m-d', strtotime($this->session_date))
            ]);
        }

        if ($this->has('next_session_is_scheduled_for')) {
            $this->merge([
                'next_session_is_scheduled_for' => date('Y-m-d', strtotime($this->next_session_is_scheduled_for))
            ]);
        }

        // Convert HH:MM:SS to HH:MM for all time fields
        foreach (['time_in', 'time_out', 'time_in2', 'time_out2'] as $timeField) {
            if ($this->has($timeField) && strlen($this->$timeField) > 5) {
                $this->merge([
                    $timeField => date('H:i', strtotime($this->$timeField))
                ]);
            }
        }
    }

    public function withValidator($validator)
    {
        $this->validateTimeOverlap($validator);
        $this->validateTimeLimits($validator);
        $this->validateBackdatedNotes($validator);
    }
}
