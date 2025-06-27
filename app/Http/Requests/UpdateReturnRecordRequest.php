<?php

namespace App\Http\Requests;

use App\Enums\ReturnPieceStatus;
use App\Enums\ReturnRecordStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReturnRecordRequest extends FormRequest
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
            'rental_id' => 'required|exists:rentals,id',
            'status' => ['required', Rule::in([ReturnRecordStatus::PENDING_REVIEW->value])],
            'pieces' => 'nullable|array',
            'pieces.*.id' => 'required|exists:pieces,id',
            'pieces.*.quantity' => 'required|integer|min:1',
            'pieces.*.piece_status' => ['required', Rule::enum(ReturnPieceStatus::class)],
        ];
    }
}
