<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VaccineCenterResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->when($request->has('address'), $this->address),
            'daily_limit' => $this->when($request->has('daily_limit'), $this->daily_limit)
        ];
    }
}
