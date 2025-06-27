<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCostumeRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'gender' => 'required|string',
            'rental_price' => 'required|numeric|min:0',

            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',

            'pieces' => 'required|array',
            'pieces.*.id' => 'exists:pieces,id',
            'pieces.*.stock' => 'required|integer|min:0',
        ];
    }
}
