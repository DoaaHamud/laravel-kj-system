<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
             'phone' => 'required|string',
            'address' => 'sometimes|string',
            'image' => 'sometimes|image',
            'date_of_birth' => 'sometimes|date',
            'bio' => 'sometimes|string'
        ];
    }
}
