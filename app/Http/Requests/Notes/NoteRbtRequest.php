<?php

namespace App\Http\Requests\Notes;

use App\Http\Requests\Notes\Traits\ValidatesTimeOverlap;
use Illuminate\Foundation\Http\FormRequest;

class NoteRbtRequest extends FormRequest
{
    use ValidatesTimeOverlap;

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
            'pa_service_id' => 'required|exists:pa_services,id',
            'bip_id' => 'nullable|exists:bips,id',
            'pos' => 'nullable|string',
            'session_date' => 'required|date|before:tomorrow',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i|after:time_in',
            'time_in2' => 'nullable|date_format:H:i',
            'time_out2' => 'nullable|date_format:H:i|after:time_in2',
            'environmental_changes' => 'nullable|string',
            'maladaptives' => 'nullable|array',
            'replacements' => 'nullable|array',
            'interventions' => 'nullable|array',
            'meet_with_client_at' => 'nullable|string',
            'client_appeared' => 'nullable|string',
            'as_evidenced_by' => 'nullable|string',
            'rbt_modeled_and_demonstrated_to_caregiver' => 'nullable|string',
            'client_response_to_treatment_this_session' => 'nullable|string',
            'progress_noted_this_session_compared_to_previous_session' => 'nullable|string',
            'next_session_is_scheduled_for' => 'nullable|date',
            'provider_id' => 'nullable|exists:users,id',
            'provider_signature' => 'nullable|string',
            'provider_credential' => 'nullable|string',
            'supervisor_signature' => 'nullable|string',
            'supervisor_name' => 'nullable|exists:users,id',
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

    protected function prepareForValidation()
    {
        if ($this->has('session_date')) {
            $this->merge([
                'session_date' => date('Y-m-d', strtotime($this->session_date))
            ]);
        }
    }

    public function withValidator($validator)
    {
        $this->validateTimeOverlap($validator);
    }
}
