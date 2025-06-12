<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'phone' => 'required|string|min:10',
            'address' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg,gif',
            'date_of_birth' => 'required|date',
            'bio' => 'required|string'
        ];
    }
}
