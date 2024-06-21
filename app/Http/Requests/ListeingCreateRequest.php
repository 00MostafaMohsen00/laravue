<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListeingCreateRequest extends FormRequest
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
            'beds' => 'required|numeric|min:0|max:10',
            'baths' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:1',
            'city' => 'required|string',
            'code' => 'required|string',
            'street' => 'required|string',
            'street_nr' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:1',
        ];
    }
}
