<?php

namespace App\Http\Controllers\Api\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Account;
use App\Models\AccountProfile;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account = Account::find(auth()->user()->id)->accountProfile;

        return ProfileResource::make($account);
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
        DB::beginTransaction();
        try {
            // $request->validated();

            $accountProfile = AccountProfile::find($id);

            
            $accountProfile->update(
                array_merge(
                    $request->only(['first_name', 'last_name', 'male', 'phone', 'description', 'remark']),
                    [
                        'date_of_birth' => $request->date_of_birth ? Carbon::create($request->date_of_birth) : null,
                    ]
                )
            );
            
            if(!($request->image == $accountProfile->image)) {
                $path = $request->file('image') ? Storage::putFile('public/avatars', $request->file('image')) : '';
                $accountProfile->update([
                    'image' => $path ? Storage::url($path) : ''
                ]);
            }

            DB::commit();

            return response()->json($accountProfile);
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
}
