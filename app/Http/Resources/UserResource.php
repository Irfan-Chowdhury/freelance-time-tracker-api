<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\VaccineCenterResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'nid' => $this->nid,
            'vaccine_status' => $this->vaccine_status,
            'scheduled_date' => $this->scheduled_date,

            // 'vaccineCenter' => $this->when($request->has('vaccineCenter'), function(){
            //     return new VaccineCenterResource($this->vaccineCenter);
            // }),

            'vaccineCenter' => $this->whenLoaded('vaccineCenter', new VaccineCenterResource($this->vaccineCenter)),

        ];
    }
}
