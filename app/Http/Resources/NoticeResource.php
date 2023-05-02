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
            'creator_name' => $this->type == 0 ? $creator->accountProfile->first_name . " " . $creator->accountProfile->last_name : '',
            'creator_image' => $this->type == 0 ? $creator->accountProfile->image : '',
            'post_slug' => $this->type == 0 ? $post->slug : '',
            'notice_id' => $this->pivot->notice_id,
            'notice_type' => $this->type == 1 ? $this->notice_type : '',
            'type' => $this->type,
            'is_read' => $this->pivot->read_at ? true : false,
        ];
    }
}
