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
            ->take(10)->get();

        return PostResource::collection($newPosts);
    }

    public function getListPostCategory($category)
    {
        $categoryId = Category::where('slug', $category)->first()->id;
        $listPostCategory = Post::where('category_id', $categoryId)
            ->where('is_approved', 1)
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
            ->orderBy('created_at', 'desc')
            ->paginate($request->number_data ? $request->number_data : 12);

        return PostResource::collection($posts);
    }

    public function getListPostHagtag($slug, Request $request)
    {
        $hagtag = HagTag::where('slug', $slug)->first();

        $posts = $hagtag->hastagHasPost()->where('is_approved', 1)->get();

        $postHagtags = (new Collection($posts))->paginate($request->limit ?? 15);

        return PostResource::collection($postHagtags);
    }

    public function getListPostPopular()
    {
        $posts = Post::where('is_popular', 1)
                    ->Where('is_approved', 1)
                    ->take(7)->get();
        
        return PostResource::collection($posts);
    }

    public function searchHeader(Request $request)
    {
        $search = $request->search;

        $posts = Post::where('title', 'like', '%'. $search .'%')
            ->where('is_approved', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)->get();

        return PostResource::collection($posts);
    }
}
