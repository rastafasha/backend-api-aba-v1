<?php

namespace App\Http\Requests\Notes;

use Illuminate\Foundation\Http\FormRequest;

class NoteBcbaRequest extends FormRequest
{
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
            'summary_note' => 'nullable|string',
            'note_description' => 'nullable|string',

            'session_date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i:s',
            'time_out' => 'nullable|date_format:H:i:s|after:time_in',
            'time_in2' => 'nullable|date_format:H:i:s',
            'time_out2' => 'nullable|date_format:H:i:s|after:time_in2',
            'session_length_total' => 'nullable|numeric',

            'supervisor_id' => 'nullable|exists:users,id',
            'caregiver_goals' => 'nullable|array',
            'rbt_training_goals' => 'nullable|array',

            'provider_signature' => 'nullable|string',
            'provider_id' => 'nullable|exists:users,id',
            'supervisor_signature' => 'nullable|string',

            'meet_with_client_at' => 'nullable|string',

            'billed' => 'boolean',
            'paid' => 'boolean',
            'cpt_code' => 'nullable|string',
            'status' => 'nullable|in:pending,ok,no,review',
            'location_id' => 'nullable|exists:locations,id',
            'pa_service_id' => 'nullable|exists:pa_services,id',
            'insuranceId' => 'nullable|string',
            'insurance_identifier' => 'nullable|string',
        ];
    }
}
