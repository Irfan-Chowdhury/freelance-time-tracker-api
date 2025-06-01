<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'project_id'  => $this->project_id,
            'project'     => optional($this->project)->title,
            'start_time'  => $this->start_time,
            'end_time'    => $this->end_time,
            'description' => $this->description,
            'hours'       => $this->hours,
            'tags'        => $this->tags,
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
