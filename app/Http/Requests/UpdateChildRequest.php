<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChildRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'sometimes|string',
            'age' => 'sometimes|double',
            'gender' => 'sometimes|string',
            'image' => 'sometimes|image',
            'state_health' => 'sometimes|string',
            'note' => 'sometimes|string'
        ];
    }
}
