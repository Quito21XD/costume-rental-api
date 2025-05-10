<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CostumeResource extends JsonResource
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
            'description' => $this->description,
            'image' => $this->image_path ? Storage::url($this->image_path) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg',
            'gender' => $this->gender,
            'rental_price' => $this->rental_price,
            'status' => $this->status,
            'category_ids' => $this->whenLoaded('categories', fn() => $this->categories->pluck('id')), // envio solo los ids de las categorías
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
