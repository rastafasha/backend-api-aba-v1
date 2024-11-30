<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BipRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type_of_assessment' => 'required|integer',
            'client_id' => 'required|exists:users,id',
            'patient_identifier' => 'nullable|string|max:50',
            'doctor_id' => 'nullable|exists:users,id',

            // JSON fields
            'documents_reviewed' => 'nullable|array',
            'maladaptives' => 'nullable|array',
            'assestment_conducted_options' => 'nullable|array',
            'prevalent_setting_event_and_atecedents' => 'nullable|array',
            'assestmentEvaluationSettings' => 'nullable|array',
            'interventions' => 'nullable|array',
            'phiysical_and_medical_status' => 'nullable|array',
            'tangibles' => 'nullable|array',
            'attention' => 'nullable|array',
            'escape' => 'nullable|array',
            'sensory' => 'nullable|array',

            // Text fields
            'background_information' => 'nullable|string',
            'previus_treatment_and_result' => 'nullable|string',
            'current_treatment_and_progress' => 'nullable|string',
            'education_status' => 'nullable|string',
            'phisical_and_medical_status' => 'nullable|string',
            'strengths' => 'nullable|string',
            'weakneses' => 'nullable|string',
            'phiysical_and_medical' => 'nullable|string',
            'assestment_conducted' => 'nullable|string',
            'hypothesis_based_intervention' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'type_of_assessment.required' => 'The assessment type is required.',
            'client_id.required' => 'The client ID is required.',
            'client_id.exists' => 'The selected client does not exist.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'patient_id.max' => 'The patient ID may not be greater than 50 characters.',
        ];
    }
}
