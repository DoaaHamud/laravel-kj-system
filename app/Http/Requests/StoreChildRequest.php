<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildRequest extends FormRequest
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
            'full_name' => 'required|string',
            'age' => 'required|numeric',
            'gender' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg,gif',
            'state_health' => 'required|string',
            'note' => 'required|string'
        ];
    }
}
