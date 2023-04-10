<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Exceptions\FailException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = Account::filter($request->all())
                ->where('userable_type', $request->type ?? 'Reader')
                ->orderBy('created_at', 'desc')
                ->paginate($request->limit ?? 10);

        return AccountResource::collection($users);
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
        $account = Account::find($id);
        
        if(!$account) {
            throw new FailException('Không thể thay đổi trạng thái tài khoản người dùng');
        }

        $account->update([
            'status' => !$account->status
        ]);
        $account->save();

        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $account = Account::find($id);

        if(!$account) {
            throw new FailException('Không thể xóa tài khoản người dùng');
        }

        $account->delete();

        return response()->json(200);
    }

    public function deleteAccounts()
    {

    }
}
