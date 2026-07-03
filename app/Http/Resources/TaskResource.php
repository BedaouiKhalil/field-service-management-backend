<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,

            'status' => $this->status?->value,
            'status_label' => $this->status?->label(),

            'completed_at' => $this->completed_at,

            'customer' => [
                'id' => $this->customer?->id,
                'name' => $this->customer?->name,
            ],

            'technician' => [
                'id' => $this->technician?->id,
                'full_name' => $this->technician?->full_name,
            ],

            'creator' => [
                'id' => $this->creator?->id,
                'full_name' => $this->creator?->full_name,
            ],

            'updater' => [
                'id' => $this->updater?->id,
                'full_name' => $this->updater?->full_name,
            ],

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
