<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'pickup_date' => $this->pickup_date,
            'return_date' => $this->return_date,
            'car_id' => CarResource::make($this->car),
            'user_id' => UserResource::make($this->user)
        ];
    }
}
