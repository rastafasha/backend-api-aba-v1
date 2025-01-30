<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeeklyReportRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'plan_id' => 'required|exists:plans,id',
            'week_start' => 'required|date',
            'week_end' => 'required|date|after:week_start',
            'value' => 'required|integer',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'plan_id.required' => 'A plan is required',
            'plan_id.exists' => 'The selected plan does not exist',
            'week_start.required' => 'The week start date is required',
            'week_start.date' => 'The week start must be a valid date',
            'week_end.required' => 'The week end date is required',
            'week_end.date' => 'The week end must be a valid date',
            'week_end.after' => 'The week end must be after the week start',
            'value.required' => 'The value is required',
            'value.integer' => 'The value must be an integer',
        ];
    }
}
