<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'code' => $this->code,
            'price' => $this->price,
            'unit' => $this->unit,
            'quantity' => $this->quantity ?? 0,
            'description' => $this->description,
            'status' => $this->status,
            'image' => $this->image,
            'created_at' => $this->created_at->format('Y-m-d h:i:s'),
        ];
    }
}
