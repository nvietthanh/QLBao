<?php

namespace App\Http\Resources;

use App\Models\Account;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $creator = Account::find($this->creator_id);
        $post = Post::find($this->post_id);
        
        return [
            'id' => $this->id,
            'content' => $this->content,
            'creator_name' => $creator->accountProfile->first_name . " " . $creator->accountProfile->last_name,
            'creator_image' => $creator->accountProfile->image,
            'post_slug' => $post->slug,
            'notice_id' => $this->pivot->notice_id,
            'is_read' => $this->pivot->read_at ? true : false,
        ];
    }
}
