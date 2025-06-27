<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PieceResource extends JsonResource
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
            'name' => $this->name,
            'replacement_cost' => $this->replacement_cost,
            'material' => $this->material,
            'color' => $this->color,
            'piece_type_id' => $this->piece_type_id,
            'size_id' => $this->size_id,
        ];
    }
}
