<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'first_name' => $this->accountProfile->first_name,
            'last_name' => $this->accountProfile->last_name,
            'image' => $this->accountProfile->image,
            'description' => $this->accountProfile->description,
            'remark' => $this->accountProfile->remark,
        ];
    }
}
