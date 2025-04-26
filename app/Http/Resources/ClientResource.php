<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            'address' => $this->address,
            'national_id' => $this->national_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'health_programs' => $this->when($this->relationLoaded('healthPrograms'), function () {
                return HealthProgramResource::collection($this->healthPrograms);
            }),
        ];
    }
}
