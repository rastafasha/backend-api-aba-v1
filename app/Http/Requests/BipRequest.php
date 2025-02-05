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
            'prevalent_setting_event_and_antecedents' => 'nullable|array',
            'assestment_evaluation_settings' => 'sometimes|nullable|array',
            'interventions' => 'nullable|array',
            'tangibles' => 'nullable|array',
            'attention' => 'nullable|array',
            'escape' => 'nullable|array',
            'sensory' => 'nullable|array',

            // Physical and medical records validation
            'physical_and_medical' => 'nullable|array',
            // 'physical_and_medical.*.index' => 'required|integer',
            'physical_and_medical.*.medication' => 'required|string',
            'physical_and_medical.*.dose' => 'required|string',
            'physical_and_medical.*.frequency' => 'required|string',
            'physical_and_medical.*.reason' => 'required|string',
            'physical_and_medical.*.preescribing_physician' => 'required|string',

            // Attention records validation
            'attention' => 'nullable|array',
            // 'attention.*.index' => 'required|integer',
            'attention.*.preventive_strategies' => 'required|string',
            'attention.*.replacement_skills' => 'required|string',
            'attention.*.manager_strategies' => 'required|string',

            // Text fields
            'background_information' => 'nullable|string',
            'previous_treatment_and_result' => 'nullable|string',
            'current_treatment_and_progress' => 'nullable|string',
            'education_status' => 'nullable|string',
            'physical_and_medical_status' => 'nullable|string',
            'strengths' => 'nullable|string',
            'weaknesses' => 'nullable|string',
            'assestment_conducted' => 'nullable|string',
            'hypothesis_based_intervention' => 'nullable|string',

            // new fields
            'discharge_plan' => 'nullable|string',
            'fading_plan' => 'nullable|string',
            'risk_assessment' => 'nullable|string',
            'generalization_training' => 'nullable|string',

            // Json fields
            'crisis_plan' => 'nullable|array',
            'crisis_plan.description' => 'nullable|string',
            'crisis_plan.prevention' => 'nullable|string',
            'de_escalation_techniques' => 'nullable|array',
            'de_escalation_techniques.*.description' => 'nullable|string',
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

            // Physical and medical records messages
            // 'physical_and_medical.*.index.required' => 'The index field is required for each medical record.',
            'physical_and_medical.*.medication.required' => 'The medication field is required for each medical record.',
            'physical_and_medical.*.dose.required' => 'The dose field is required for each medical record.',
            'physical_and_medical.*.frequency.required' => 'The frequency field is required for each medical record.',
            'physical_and_medical.*.reason.required' => 'The reason field is required for each medical record.',
            'physical_and_medical.*.preescribing_physician.required' => 'The prescribing physician field is required for each medical record.',
        ];
    }
}
