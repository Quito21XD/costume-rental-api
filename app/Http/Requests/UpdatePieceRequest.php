<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePieceRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'replacement_cost' => 'required|decimal:0,2|min:0',
            'material' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'piece_type_id' => 'required|exists:piece_types,id',
            'size_id' => 'required|exists:sizes,id',
        ];
    }
}
