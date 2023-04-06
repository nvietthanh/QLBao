<?php

namespace App\Http\Controllers\Api\BackEnd\Creator;

use App\Http\Controllers\Controller;
use App\Models\HagTag;
use Illuminate\Http\Request;

class HagTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hagtag = HagTag::orderBy('creatd_at', 'desc')->all();
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAllHagTag()
    {
        $hagtag = HagTag::select(['id', 'name', 'slug'])->orderBy('created_at', 'desc')->get();

        return response()->json($hagtag);
    }
}
