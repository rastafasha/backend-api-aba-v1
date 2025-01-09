<?php

namespace App\Http\Requests\Notes;

use App\Http\Requests\Notes\Traits\ValidatesTimeOverlap;
use App\Http\Requests\Notes\Traits\ValidatesTimeLimits;
use App\Http\Requests\Notes\Traits\ValidatesBackdatedNotes;
use Illuminate\Foundation\Http\FormRequest;

class NoteBcbaRequest extends FormRequest
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
            'doctor_id' => 'nullable|exists:users,id',
            'bip_id' => 'nullable|exists:bips,id',
            'diagnosis_code' => 'nullable|string|max:50',
            'meet_with_client_at' => 'nullable|string',
            'session_date' => 'required|date|before:tomorrow',
            'next_session_is_scheduled_for' => 'nullable|date|after:session_date',
            'participants' => 'nullable|string',
            'pos' => 'nullable|string',
            'time_in' => 'nullable|date_format:H:i,H:i:s',
            'time_out' => 'nullable|date_format:H:i,H:i:s|after:time_in',
            'time_in2' => 'nullable|date_format:H:i,H:i:s',
            'time_out2' => 'nullable|date_format:H:i,H:i:s|after:time_in2',
            'session_length_total' => 'nullable|numeric',
            'note_description' => 'nullable|string',
            'rendering_provider' => 'nullable|exists:users,id',
            'supervisor_id' => 'nullable|exists:users,id',
            'caregiver_goals' => 'nullable|array',
            'rbt_training_goals' => 'nullable|array',
            'provider_signature' => 'nullable|string',
            'provider_id' => 'nullable|exists:users,id',
            'supervisor_signature' => 'nullable|string',
            'status' => 'nullable|in:pending,ok,no,review',
            'summary_note' => 'nullable|string',
            'billed' => 'boolean',
            'paid' => 'boolean',
            'cpt_code' => 'nullable|string',
            'location_id' => 'nullable|exists:locations,id',
            'pa_service_id' => 'nullable|exists:pa_services,id',
            'insuranceId' => 'nullable|string',
            'insurance_identifier' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'session_date.before' => 'Oops! It looks like you’re trying to save a session note with a future date. Please ensure the date and time are accurate before saving.',
            'next_session_is_scheduled_for.after' => 'Oops! It looks like you’re trying to save a next session date that is before the current session date. Please ensure the date and time are accurate before saving.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('session_date')) {
            $this->merge([
                'session_date' => date('Y-m-d', strtotime($this->session_date))
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
