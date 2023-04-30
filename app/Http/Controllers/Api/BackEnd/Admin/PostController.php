<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Exceptions\FailException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPostRequest;
use App\Http\Resources\AdminPostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::filter($request->all())
            ->where('is_approved', $request->isApproved ?? 1)
            ->orderBy('created_at', 'desc')
            ->paginate($request->limit ?? 10);

        return AdminPostResource::collection($posts);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        return AdminPostResource::make($post);
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
    public function update(AdminPostRequest $request, string $id)
    {
        $request->validated();
        $hagtags = $request->hagtags ? explode(",", $request->hagtags ) : '';
        $currentUser = auth('web')->user();

        DB::beginTransaction();
        try {
            $post = Post::where('id', $id)
                    ->first();
            
            if(!$post) {
                throw new FailException('Không thể cập nhật bài viết');
            }

            $path = $request->file('image') ? Storage::putFile('public/posts', $request->file('image')) : '';

            $post->update(
                array_merge($request->only(['title', 'description', 'content']),
                [
                    'slug' =>  Str::slug($request->title),
                    'category_id' => Category::where('slug', $request->categorySlug)->first()->id,
                    'updaterable' => User::class,
                    'updater_id' => $currentUser->id,
                    'updated_at' => now()
                ])
            );
            
            if($request->file('image')) {
                $post->update([
                    'image' => $path ? Storage::url($path) : '',
                ]);
            }

            $post->postHasHagtag()->detach();
            if($hagtags) {
                foreach($hagtags as $hagtag) {
                    $post->postHasHagtag()->attach([
                        $hagtag => ['created_at' => now()]
                    ]);
                }
            }

            DB::commit();

            return response()->json(200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function changeApproved($id)
    {
        $post = Post::find($id);

        if($post) {
            $post->update([
                'is_approved' => !$post->is_approved
            ]);
        }

        return response()->json(200);
    }

    public function changestatus($id)
    {
        $post = Post::find($id);

        if($post) {
            $post->update([
                'status' => !$post->status
            ]);
        }

        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if($post) {
            $post->delete();
        }

        return response()->json(200);
    }

    public function deletePosts(Request $request)
    {
        $posts = $request->posts;

        foreach($posts as $item) {
            $post = Post::find($item['id']);
            
            if($post) {
                $post->delete();
            }
        }

        return response()->json(200);
    }
}
