<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProfileResource extends JsonResource
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
            'code' => $this->account->code,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth ? Carbon::create($this->date_of_birth)->format('d-m-Y') : '',
            'male' => $this->male,
            'phone' => $this->phone,
            'image' => $this->image,
            'description' => $this->description,
            'remark' => $this->remark
        ];
    }
}
