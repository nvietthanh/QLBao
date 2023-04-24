<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportPostTopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $post = Post::find($this->post_id);

        return [
            'post_id' => $post->id,
            'post_title' => $post->title,
            'post_image' => $post->image,
            'post_status' => $post->status ? true : false,
            'count_report' => $this->count_report
        ];
    }
}
