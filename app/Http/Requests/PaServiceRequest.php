<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'pa_services' => 'required|string|max:255',
            'cpt' => 'required|string|max:255',
            'n_units' => 'required|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];

        // Make fields optional for PUT/PATCH requests
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = array_map(function ($rule) {
                return 'sometimes|' . $rule;
            }, $rules);
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'pa_services.required' => 'The PA service name is required.',
            'pa_services.max' => 'The PA service name cannot exceed 255 characters.',
            'cpt.required' => 'The CPT code is required.',
            'cpt.max' => 'The CPT code cannot exceed 255 characters.',
            'n_units.required' => 'The number of units is required.',
            'n_units.integer' => 'The number of units must be a whole number.',
            'n_units.min' => 'The number of units cannot be negative.',
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'Please provide a valid start date.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'Please provide a valid end date.',
            'end_date.after' => 'The end date must be after the start date.',
        ];
    }
}