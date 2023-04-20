<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentChildResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $account_id = auth('accounts')->user()->id ?? '';
        
        return [
            'id' => $this->id,
            'content' => $this->content,
            'commentator' => $this->account->accountProfile->getFullName(),
            'commentator_code' => $this->account->code,
            'commentator_image' => $this->account->accountProfile->image,
            'is_creator' => $this->account->userable_type == 'Creator',
            'created_at' => Carbon::create($this->created_at)->format('Y-m-d H:i'),
            'is_like_comment' => $this->whereHas('commentsHasLikeAccounts', function($query) use ($account_id) {
                    $query->where('account_id', $account_id)
                        ->where('comment_id', $this->id);
                })->first() ? true : false,
            'count_like_comment' => $this->commentsHasLikeAccounts()->count(),
        ];
    }
}
