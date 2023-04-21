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
            ->where('parent_id', 0)
            ->orderBy('created_at', 'desc')
            ->paginate($request->page_number ?? 6);

        return CommentResource::collection($comments);
    }

    public function getComment($id)
    {
        $comment = Comment::find($id);

        return CommentResource::make($comment);
    }

    public function updateComment($id, Request $request)
    {
        $account_id = auth('accounts')->user();
        $comment = Comment::where('id', $id)->where('account_id', $account_id)->first();

        if(!$comment) {
            throw new FailException('Không thể cập nhật bình luận');
        }

        $comment->update([
            'content' => $request->content,
            'is_change' => 1
        ]);

        return response()->json(200);
    }

    public function createComment(CommentRequest $request, $id)
    {
        $post = Post::where('id', $id)
            ->where('is_approved', 1)
            ->first();
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

    public function createCommentChild(CommentRequest $request, $id)
    {
        $commentChild = Comment::where('id', $id)->where('parent_id', 0)->first();

        if(!$commentChild) {
            throw new FailException('Không tìm thấy bài viết');
        }

        $comment = Comment::create([
            'content' => $request->content,
            'account_id' => auth('accounts')->user()->id,
            'post_id' => $commentChild->post_id,
            'parent_id' => $commentChild->id
        ]);

        return response()->json($comment);
    }

    public function likeComment($id)
    {
        $comment = Comment::find($id);
        $account_id = auth('accounts')->user()->id;
        if(!$comment) {
            throw new FailException('Không thả được tương tác cho bình luận');
        }
        else {
            $isLikeComment = $comment->whereHas('commentsHasLikeAccounts', function($query) use ($account_id, $id) {
                $query->where('account_id', $account_id)
                    ->where('comment_id', $id);
            })->first();
            if($isLikeComment) {
                abort(404);
            }
        }

        $comment->commentsHasLikeAccounts()->attach($account_id);

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
            $isLikeComment = $comment->whereHas('commentsHasLikeAccounts', function($query) use ($account_id, $id) {
                $query->where('account_id', $account_id)
                    ->where('comment_id', $id);
            })->first();
            if(!$isLikeComment) {
                throw new FailException('Không thả được tương tác cho bình luận');
            }
        }

        $comment->commentsHasLikeAccounts()->detach($account_id);

        return response()->json(true);
    }

    public function deleteComment($id)
    {
        $account_id = auth('accounts')->user()->id;
        $comment = Comment::where('id', $id)->where('account_id', $account_id)->first();

        if(!$comment) {
            throw new FailException('Không xóa được bình luận');
        }

        $comment->delete();

        return response()->json(true);
    }

    public function editComment(Request $request, $id)
    {
        dd(1);
    }
}
