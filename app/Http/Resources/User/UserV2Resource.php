<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserV2Resource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'roles' => $this->getRoleNames(),
            // Add only the attributes you want to expose
            'location_id' => $this->location_id,
            // Conditional relationships
            'location' => $this->when(
                $request->has('include') && str_contains($request->include, 'locations'),
                $this->locations
            ),
        ];
    }
}
