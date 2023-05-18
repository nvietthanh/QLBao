<?php

namespace App\Http\Controllers\Api\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertistRequest;
use App\Http\Resources\AdvertistResource;
use App\Models\Advertist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $advertists = Advertist::filter($request->all())
            ->orderBy('created_at', 'desc')->paginate($request->limit ?? 10);

        return AdvertistResource::collection($advertists);
    }

    public function getAll()
    {
        $advertists = Advertist::where('status', 1)->get();

        return AdvertistResource::collection($advertists);
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
    public function store(AdvertistRequest $request)
    {
        $path = $request->file('image') ? Storage::putFile('public/posts', $request->file('image')) : '';

        Advertist::create([
            'name' => $request->name,
            'image' => Storage::url($path),
            'status' => true
        ]);

        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $advertist = Advertist::find($id);

        if(!$advertist) {
            abort(404);
        }

        return AdvertistResource::make($advertist);
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
    public function update(AdvertistRequest $request, string $id)
    {
        $advertist = Advertist::find($id);

        if(!$advertist) {
            abort(404);
        }

        $path = $request->file('image') ? Storage::putFile('public/posts', $request->file('image')) : '';

        $advertist->update([
            'name' => $request->name,
            'status' => true
        ]);

        if($request->file('image')) {
            $advertist->update([
                'image' => $path ? Storage::url($path) : '',
            ]);
        }

        return response()->json();
    }

    public function changeStatus($id)
    {
        $advertist = Advertist::find($id);

        if(!$advertist) {
            abort(404);
        }

        $advertist->update([
            'status' => !$advertist->status
        ]);

        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $advertist = Advertist::find($id);

        if(!$advertist) {
            abort(4004);
        }
        $advertist->delete();

        return response()->json(true);
    }

    public function deleteAdverts(Request $request)
    {
        $advertists = $request->advertists;

        foreach($advertists as $advertist) {
            $advertist = Advertist::find($advertist['id']);

            if($advertist) {
                $advertist->delete();
            }
        }

        return response()->json(true);
    }
}
