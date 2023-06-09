<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Carbon\Carbon;
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
        $account_id = auth('accounts')->user()->id ?? '';
        $commentId = $request->comment_id;
        $pageNumberChild = 6;

        if($this->id == $commentId) {
            $pageNumberChild = $request->page_number_child;
        }

        $dataChild = $this->getCommentChilds($pageNumberChild);

        return [
            'id' => $this->id,
            'content' => $this->content,
            'comment_child' => $dataChild,
            'is_load_comment_child' => $dataChild->lastPage() == 1 ? false : true,
            'count_comment_child' => $dataChild->total(),
            'page_number_comment_child' => $pageNumberChild,
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

    public function getCommentChilds($pageNumberChild)
    {
        $commentChilds = Comment::where('parent_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->paginate($pageNumberChild);

        return CommentChildResource::collection($commentChilds);
    }
}
