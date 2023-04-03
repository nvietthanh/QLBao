<?php

namespace App\Http\Controllers\Api\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\AccountSavePost;
use App\Models\Post;
use App\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class HomeController extends Controller
{
    public function getPost($slugPost)
    {
        $currentAccount = auth('accounts')->user();
        $post = Post::where('slug', $slugPost)
            ->where('is_approved', 1)
            ->first();

        if(!$post) {
            abort(404);
        }

        $post->count_view++;
        $post->save();

        if($currentAccount) {
            $isSaveRead =  $post->whereHas('postHasAccountReads', function ($query) use ($currentAccount, $post) {
                $query->where('account_id', $currentAccount->id)
                    ->where('post_id', $post->id);
            })->first();

            if(!$isSaveRead) {
                $post->postHasAccountReads()->attach([
                    $currentAccount->id => ['read_at' => now()]
                ]);
            }
            else {
                $post->postHasAccountReads()->first()->pivot->update([
                    'read_at' => now()
                ]);
            }
        }

        return PostResource::make($post);
    }
    
    public function getListRead(Request $request)
    {
        $currentAccount = auth('accounts')->user();
        $accountReadPosts = $currentAccount->accountHasReadPosts;

        $readPosts = (new Collection($accountReadPosts))->paginate($request->limit ?? 18);

        return PostResource::collection($readPosts);
    }

    public function getListSave(Request $request)
    {
        $currentAccount = auth('accounts')->user();

        $posts = Post::whereHas('postHasAccountReads', function ($query) use ($currentAccount) {
                $query->where('account_id', $currentAccount->id)
                    ->orderBy('id', 'asc');
        })->get()->reverse();

        $posts = (new Collection($posts))->paginate($request->limit ?? 15);

        return PostResource::collection($posts);
    }

    public function savePost($id)
    {
        $post = Post::find($id);
        $currentAccount = auth('accounts')->user();
        
        if(!$post) {
            abort(404);
        }
        else {
            $savePosts = AccountSavePost::where('account_id', $currentAccount->id)
                ->where('post_id', $post->id)
                ->first();
            
            if($savePosts) {
                abort(404);
            }
            else {
                AccountSavePost::create([
                    'account_id' => $currentAccount->id,
                    'post_id' => $post->id
                ]);
                
                return response()->json(true);
            }
        }
    }

    public function unsavePost($id)
    {
        $post = Post::find($id);
        $currentAccount = auth('accounts')->user();
        
        if(!$post) {
            abort(404);
        }
        else {
            $savePosts = AccountSavePost::where('account_id', $currentAccount->id)
                ->where('post_id', $post->id)
                ->first();
            
            if(!$savePosts) {
                abort(404);
            }
            else {
                $savePosts->delete();
                
                return response()->json(true);
            }
        }
    }

    public function unsaveAllPost()
    {
        DB::beginTransaction();
        try {
            $currentAccount = auth('accounts')->user();
        
            $savePosts = AccountSavePost::where('account_id', $currentAccount->id)->get();
    
            foreach($savePosts as $post) {
                $post->delete();
            }

            DB::commit();

            return response()->json(true);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
