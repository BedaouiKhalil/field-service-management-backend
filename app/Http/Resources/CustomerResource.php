<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'contact_name' => $this->contact_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'nif' => $this->nif,
            'wilaya_id' => $this->wilaya_id,
            'commune_id' => $this->commune_id,
            'address' => $this->address,
            'creator' => [
                'id' => $this->crested_by,
                'name' => $this->creator?->name,
            ],
        ];
    }
}
