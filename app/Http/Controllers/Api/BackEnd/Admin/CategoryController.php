<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Exceptions\FailException;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        
        if(!$category) {
            throw new FailException('Không thể thay đổi trạng thái chủ đề');
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
        //
    }
}
