<?php

namespace App\Http\Controllers\Api\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Account;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getNewPost()
    {
        $newPosts = Post::orderBy('created_at', 'desc')->take(10)->get();

        return PostResource::collection($newPosts);
    }

    public function getListPostCategory($category)
    {
        $categoryId = Category::where('slug', $category)->first()->id;
        $listPostCategory = Post::where('category_id', $categoryId)
            ->orderBy('created_at', 'desc')->paginate(10);

        return PostResource::collection($listPostCategory);
    }

    public function getPost($slugPost)
    {
        $post = Post::where('slug', $slugPost)->first();

        return PostResource::make($post);
    }

    public function getListPostCreator($id, Request $request)
    {
        $account = Account::where('code', $id)->first();
        $posts = Post::where('creator_id', $account->id)
            ->orderBy('created_at', 'desc')
            ->paginate($request->number_data ? $request->number_data : 12);

        return PostResource::collection($posts);
    }

    public function searchHeader(Request $request)
    {
        $search = $request->search;

        $posts = Post::where('title', 'like', '%'. $search .'%')
            ->orderBy('created_at', 'desc')
            ->take(6)->get();

        return PostResource::collection($posts);
    }
}
