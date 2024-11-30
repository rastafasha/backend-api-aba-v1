<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:150',
            'address' => 'nullable|string',
            'phone1' => 'nullable|string|max:50',
            'phone2' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:150',
            'state' => 'nullable|string|max:150',
            'zip' => 'nullable|string|max:150',
            'email' => 'nullable|email|max:150',
            'telfax' => 'nullable|string',
            'avatar' => 'nullable|string'
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
            'title.required' => 'The location title is required.',
            'title.max' => 'The location title cannot exceed 150 characters.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'The email address cannot exceed 150 characters.',
        ];
    }
}
