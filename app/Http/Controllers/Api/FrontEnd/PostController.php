<?php

namespace App\Http\Controllers\Api\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Account;
use App\Models\Category;
use App\Models\HagTag;
use App\Models\Post;
use App\Support\Collection;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getNewPost()
    {
        $newPosts = Post::orderBy('created_at', 'desc')
            ->where('is_approved', 1)
            ->where('status', 1)
            ->take(16)->get();

        return PostResource::collection($newPosts);
    }

    public function getPostInterested()
    {
        $currentAccount = auth('accounts')->user();

        $follows = $currentAccount->follows;
        $followIds = [];

        foreach($follows as $follow) {
            array_push($followIds, $follow->id);
        }

        $posts = Post::whereIn('creator_id', $followIds)
            ->orderBy('created_at', 'desc')->take(16)->get();

        return PostResource::collection($posts);
    }

    public function getListPostRelate(Request $request)
    {
        $id = $request->id;
        $pageNumber = $request->number_data ?? 6;
        $post = Post::find($id);

        if(!$post) {
            abort(404);
        }

        $creator = Account::find($post->creator_id);
        $posts = Post::where('creator_id', $creator->id)
            ->where('id', '<>', $post->id)
            ->orderBy('created_at', 'desc')
            ->paginate($pageNumber);

        return PostResource::collection($posts);
    }

    public function getListPostCategory($category)
    {
        $category = Category::where('slug', $category)
            ->first();

        if(!$category){
            abort(404);
        }

        $listPostCategory = Post::where('category_id', $category->id)
            ->where('is_approved', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')->paginate(10);

        return PostResource::collection($listPostCategory);
    }

    // public function getPost($slugPost)
    // {
    //     dd(auth('accounts')->user());
    //     $post = Post::where('slug', $slugPost)->first();

    //     return PostResource::make($post);
    // }

    public function getListPostCreator($id, Request $request)
    {
        $account = Account::where('code', $id)->first();
        $posts = Post::where('creator_id', $account->id)
            ->where('is_approved', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate($request->number_data ? $request->number_data : 12);

        return PostResource::collection($posts);
    }

    public function getListPostHagtag($slug, Request $request)
    {
        $hagtag = HagTag::where('slug', $slug)->first();

        $posts = $hagtag->hastagHasPost()
            ->where('is_approved', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $postHagtags = (new Collection($posts))->paginate($request->limit ?? 15);

        return PostResource::collection($postHagtags);
    }

    public function getListPostPopular()
    {
        $posts = Post::where('is_popular', 1)
                    ->Where('is_approved', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->take(10)->get();
        
        return PostResource::collection($posts);
    }

    public function getListHagtagPopular(Request $request)
    {
        $hagtags = $request->all();
        $posts = [];

        foreach($hagtags as $item){
            $hastag = HagTag::where('slug', $item['slug'])->first();

            $posts[] = PostResource::collection(
                $hastag->hastagHasPost()->where('is_approved', 1)
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->take(10)->get()
            );
        }

        return $posts;
    }

    public function searchHeader(Request $request)
    {
        $search = $request->search;

        $posts = Post::where('title', 'like', '%'. $search .'%')
            ->where('is_approved', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)->get();

        return PostResource::collection($posts);
    }
}
