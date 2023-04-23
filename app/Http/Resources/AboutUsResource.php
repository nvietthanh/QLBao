<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'title' => $this->title,
            'content' => $this->content,
            'images' => $this->images,
            'is_reply' => $this->is_reply ? true : false,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i')
        ];
    }
}
