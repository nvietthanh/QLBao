<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminPostResource extends JsonResource
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
            'description' => $this->description,
            'slug' => $this->slug,
            'content' => $this->content,
            'image' => $this->image,
            'count_view' => $this->count_view,
            'hagtags' => $this->getHagtags(),
            'categoryName' => $this->category->name,
            'categorySlug' => $this->category->slug,
            'is_approved' => $this->is_approved,
            'created_at' => Carbon::create($this->created_at)->format('Y-m-d h:i'),
            'updated_at' => Carbon::create($this->updated_at)->format('Y-m-d h:i'),
            'creator' => $this->creator->accountProfile->getFullName(),
            'updater' => $this->updater->accountProfile->getFullName()           
        ];
    }
    
    public function getHagtags()
    {
        $resultHagtag = [];
        $hagtags = $this->postHasHagtag;

        if($hagtags) {
            foreach($hagtags as $hagtag) {
                array_push($resultHagtag, $hagtag->pivot->hagtag_id);
            }
        }

        return $resultHagtag;
    }
}
