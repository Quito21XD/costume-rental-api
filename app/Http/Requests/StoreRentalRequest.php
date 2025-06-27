<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
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
            'warranty_value' => 'required|numeric',
            'rental_date' => 'required|date',
            'return_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'customer_id' => 'required|exists:customers,id',
            'costumes.*' => 'required|array',
            'costumes.*.id' => 'required|exists:costumes,id',
            'costumes.*.rental_price' => 'required|numeric',
            'costumes.*.quantity' => 'required|integer|min:1',
            'costumes.*.notes' => 'nullable|string',
        ];
    }
}
