<?php

namespace App\Http\Controllers\Api\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Exceptions\FailException;
use App\Models\Post;

class CommentController extends Controller
{
    public function getComments(Request $request)
    {
        $comments = Comment::where('post_id', $request->id)
            ->orderBy('created_at', 'desc')
            ->paginate($request->page_number ?? 1);

        return CommentResource::collection($comments);
    }

    public function createComment(CommentRequest $request, $id)
    {
        $post = Post::find($id);
        if(!$post) {
            throw new FailException('Không tìm thấy bài viết');
        }
        $comment = Comment::create([
            'content' => $request->content,
            'account_id' => auth('accounts')->user()->id,
            'post_id' => $id
        ]);
        
        return response()->json($comment);
    }

    public function likeComment($id)
    {
        $comment = Comment::find($id);
        $account_id = auth('accounts')->user()->id;
        if(!$comment) {
            abort(404);
        }
        else {
            $isLikeComment = $comment->whereHas('commentAccounts', function($query) use ($account_id, $id) {
                $query->where('account_id', $account_id)
                    ->where('comment_id', $id);
            })->first();
            if($isLikeComment) {
                abort(404);
            }
        }

        $comment->commentAccounts()->attach($account_id);

        return response()->json(true);
    }

    public function unlikeComment($id)
    {
        $comment = Comment::find($id);
        $account_id = auth('accounts')->user()->id;
        if(!$comment) {
            abort(404);
        }
        else {
            $isLikeComment = $comment->whereHas('commentAccounts', function($query) use ($account_id, $id) {
                $query->where('account_id', $account_id)
                    ->where('comment_id', $id);
            })->first();
            if(!$isLikeComment) {
                abort(404);
            }
        }

        $comment->commentAccounts()->detach($account_id);

        return response()->json(true);
    }
}
