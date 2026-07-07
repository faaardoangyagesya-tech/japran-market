<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'unique_code' => $this->unique_code,
            'price' => (float) $this->price,
            'description' => $this->description,
            'status' => $this->status,
            'game' => new GameResource($this->whenLoaded('game')),
            'created_at' => $this->created_at,
        ];
    }
}
