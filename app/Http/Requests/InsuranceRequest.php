<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'services' => 'nullable|array',
            'notes' => 'nullable|array',
            'payer_id' => 'nullable|string|max:255',
            'street' => 'nullable|string',
            'street2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
        ];
    }
}
