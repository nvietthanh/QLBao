<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'content' => $this->content,
            'image' => $this->image,
            'categoryName' => $this->category->name,
            'categorySlug' => $this->category->slug,
            'creator' => $this->creator->accountProfile->getFullName(),
            'creatorCode' => $this->creator->code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
