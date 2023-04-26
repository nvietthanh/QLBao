<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->accountProfile->first_name  . ' ' . $this->accountProfile->last_name,
            'email' => $this->email,
            'status' => $this->status ? true : false,
            'type' => $this->userable_type == 'Reader' ? 'Reader' : 'Creator',
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i'),
            'status_expires_at' => $this->status_expires_at
        ];
    }
}
