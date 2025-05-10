<?php

namespace App\Http\Requests;

use App\Enums\CostumePieceStatus;
use App\Enums\CostumeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'gender' => 'required|string',
            'rental_price' => 'required|numeric|min:0',
            'status' => ['required', Rule::enum(CostumeStatus::class)],

            'categories' => 'required|array', // no es obligatorio, puede venir vacío
            'categories.*' => 'exists:categories,id', //validación para cada id de categoría

            'pieces' => 'required|array',
            'pieces.*.name' => 'required|string|max:255',
            'pieces.*.replacement_cost' => 'required|numeric|min:0',
            'pieces.*.material' => 'required|string|max:255',
            'pieces.*.color' => 'required|string|max:255',
            'pieces.*.piece_type_id' => 'required|exists:piece_types,id',
            'pieces.*.size_id' => 'required|exists:sizes,id',

            'pieces.*.stock' => 'required|integer|min:0',
            'pieces.*.status' => ['required', Rule::enum(CostumePieceStatus::class)],

        ];
    }
}
