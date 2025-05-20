<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnicianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => optional($this->technician->user)->name,
            'email' => optional($this->technician->user)->email,
            'phone' => optional($this->technician->user->employee)->phone,

           
        ];
    }
}


