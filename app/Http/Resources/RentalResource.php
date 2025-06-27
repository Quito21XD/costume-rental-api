<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'warranty_value' => $this->warranty_value,
            'rental_date' => $this->rental_date,
            'return_date' => $this->return_date,
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'status' => 'rented',
            'costumes' => CostumeResource::collection($this->whenLoaded('costumes')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
