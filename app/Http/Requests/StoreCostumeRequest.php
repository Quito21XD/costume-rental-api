<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCostumeRequest extends FormRequest
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
            'size' => 'required|string|max:255',

            'categories' => 'required|array', // no es obligatorio, puede venir vacío
            'categories.*' => 'exists:categories,id', // validación para cada id de categoría

            'pieces' => 'required|array',
            'pieces.*.id' => 'nullable|integer|exists:pieces,id',
            'pieces.*.replacement_cost' => 'required|decimal:0,2|min:0',
            'pieces.*.material' => 'required|string|max:255',
            'pieces.*.color' => 'required|string|max:255',
            'pieces.*.type' => 'required|string|max:255',
            'pieces.*.size' => 'required|string|max:255',
            'pieces.*.details' => 'nullable|string|max:1000',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del disfraz es obligatorio.',
            'rental_price.required' => 'El precio de alquiler es obligatorio.',
            'size.required' => 'La talla del disfraz es obligatoria.',
            'categories.required' => 'Debe seleccionar al menos una categoría.',
            'pieces.required' => 'Debe agregar al menos una pieza al disfraz.',
            'pieces.*.replacement_cost.required' => 'El costo de reemplazo de cada pieza es obligatorio.',
            'pieces.*.material.required' => 'El material de cada pieza es obligatorio.',
            'pieces.*.color.required' => 'El color de cada pieza es obligatorio.',
            'pieces.*.type.required' => 'El tipo de cada pieza es obligatorio.',
            'pieces.*.size.required' => 'La talla de cada pieza es obligatoria.',
            'pieces.*.details.max' => 'Los detalles de cada pieza no pueden exceder los 1000 caracteres.',
            'pieces.*.id.exists' => 'La pieza seleccionada no existe.',
            'categories.*.exists' => 'Una o más categorías seleccionadas no existen.',
        ];
    }

}
