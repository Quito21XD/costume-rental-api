<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePieceRequest extends FormRequest
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
            'replacement_cost' => 'required|decimal:0,2|min:0',
            'material' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'details' => 'nullable|string|max:1000',
        ];
    }
    public function messages(): array
    {
        return [

            'replacement_cost.required' => 'El costo de reemplazo es obligatorio.',
            'material.required' => 'El material de la pieza es obligatorio.',
            'color.required' => 'El color de la pieza es obligatorio.',
            'type.required' => 'El tipo de pieza es obligatorio.',
            'size.required' => 'La talla de la pieza es obligatoria.',
            'details.max' => 'Los detalles no pueden exceder los 1000 caracteres.',
        ];
    }
}
