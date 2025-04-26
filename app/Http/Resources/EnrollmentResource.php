<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
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
            'client_id' => $this->client_id,
            'health_program_id' => $this->health_program_id,
            'enrollment_date' => $this->enrollment_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'client' => $this->when($this->relationLoaded('client'), function () {
                return new ClientResource($this->client);
            }),
            'health_program' => $this->when($this->relationLoaded('healthProgram'), function () {
                return new HealthProgramResource($this->healthProgram);
            }),
        ];
    }
}
