<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HagtagRequest;
use App\Http\Resources\HagTagResource;
use App\Models\HagTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Ui\Presets\React;

class HagtagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hagtag = HagTag::filter($request->all())
            ->orderBy('created_at', 'desc')
            ->paginate($request->limit ?? 10);

        return HagTagResource::collection($hagtag);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HagtagRequest $request)
    {
        $request->validated();

        HagTag::create([
            'name' => $request->name,
            'slug' => Str::remove('-', Str::slug($request->name))
        ]);

        return response()->json(200);
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
    public function update(HagtagRequest $request, string $id)
    {
        $hagtag = HagTag::find($id);

        if(!$hagtag) {
            abort(404);
        }
        
        $hagtag->update([
            'name' => $request->name,
            'slug' => Str::remove('-', Str::slug($request->name))
        ]);

        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hagtag = HagTag::find($id);

        if($hagtag) {
            $hagtag->delete();
        }

        return response()->json(200);
    }

    public function deleteHagtags(Request $request)
    {
        $hagtags = $request->hagtags;

        foreach($hagtags as $item) {
            $hagtag = HagTag::find($item['id']);
            
            if($hagtag) {
                $hagtag->delete();
            }
        }

        return response()->json(200);
    }
}
