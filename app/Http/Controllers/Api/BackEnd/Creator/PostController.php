<?php

namespace App\Http\Controllers\Api\BackEnd\Creator;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Account;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Exceptions\FailException;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::filter($request->all())
            ->where('creator_id', auth('accounts')->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($request->limit ?? '10');
        
        return PostResource::collection($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $request->validated();
        
        $currentAccount = auth('accounts')->user();

        $path = $request->file('image') ? Storage::putFile('public/posts', $request->file('image')) : '';

        $post = Post::create(
            array_merge($request->only(['title', 'description', 'content']),
            [
                'slug' =>  Str::slug($request->title),
                'category_id' => '1',
                'image' => $path ? Storage::url($path) : '',
                'creator_id' => $currentAccount->id,
                'updated_id' => $currentAccount->id
            ])
        );

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);

        return PostResource::make($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            $post = Post::findOrFail($id);
            
            if(!$post) {
                throw new FailException('Không thể cập nhật bài viết');
            }

            $path = $request->file('image') ? Storage::putFile('public/posts', $request->file('image')) : '';

            $post->update(
                array_merge($request->only(['title', 'description', 'content']),
                [
                    'slug' =>  Str::slug($request->title),
                ])
            );
            
            if($request->file('image')) {
                $post->update([
                    'image' => $path ? Storage::url($path) : '',
                ]);
            }

            DB::commit();

            return response()->json($post);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
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
