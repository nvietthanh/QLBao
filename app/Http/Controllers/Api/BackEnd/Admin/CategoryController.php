<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Exceptions\FailException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::filter($request->all())
            ->orderBy('created_at', 'desc')
            ->paginate($request->limit ?? 10);

        return CategoryResource::collection($categories);
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
    public function store(CategoryRequest $request)
    {
        $request->validated();

        do {
            $slug = Str::slug($request->name);
            $isSlug = Category::where('slug', $slug)->first();

            if($isSlug) {
                $slug .= '-' . (string)rand(1, 10000);
            }
        }
        while(Category::where('slug', $slug)->first());


        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response()->json($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        return CategoryResource::make($category);
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
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);

        if(!$category) {
            throw new FailException('Không thể cập nhật chủ đề');
        }

        $slug = Str::slug($request->name);

        while(Category::where('slug', $slug)->where('id', '<>'. $id)->first()){
            $slug .= '-' . (string)rand(1, 10000);
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response()->json($category);
    }

    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        
        if(!$category) {
            abort(404);
        }

        $category->update([
            'status' => !$category->status
        ]);
        $category->save();

        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        
        if(!$category) {
            abort(404);
        }

        $category->delete();
        
        return response()->json(200);
    }
}
