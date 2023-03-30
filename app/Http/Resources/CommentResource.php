<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $account_id = auth('accounts')->user()->id;
        return [
            'id' => $this->id,
            'content' => $this->content,
            'creator' => $this->account->accountProfile->getFullName(),
            'creator_code' => $this->account->code,
            'creator_image' => $this->account->accountProfile->image,
            'created_at' => $this->created_at,
            'is_like_comment' => $this->whereHas('commentsHasLikeAccounts', function($query) use ($account_id) {
                    $query->where('account_id', $account_id)
                        ->where('comment_id', $this->id);
                })->first() ? true : false,
            'count_like_comment' => $this->commentsHasLikeAccounts()->count(),
        ];
    }
}
