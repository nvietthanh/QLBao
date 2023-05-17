<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Exceptions\FailException;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountController extends Controller
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

    /**
     * Remove the specified resource from storage.
     */

    public function getStatus($id)
    {
        $account = Account::find($id);

        return AccountResource::make($account);
    }

    public function changeStatus(Request $request, $id)
    {
        $account = Account::find($id);
        
        if(!$account) {
            throw new FailException('Không thể thay đổi trạng thái tài khoản người dùng');
        }

        $account->update([
            'status' => $request->status,
            'status_expires_at' =>  $request->status_expires_at ? Carbon::create($request->status_expires_at) : null
        ]);
        $account->save();

        return response()->json(200);
    }

    public function changeToCreator($id)
    {
        $account = Account::find($id);

        if(!$account) {
            throw new FailException('Không thể thay đổi trạng thái tài khoản người dùng');
        }

        $account->update([
            'userable_type' => 'Creator'
        ]);
        
        $account->assignRole('Creator');

        return response()->json(200);
    }

    public function changeToReader($id)
    {
        $account = Account::find($id);

        if(!$account) {
            throw new FailException('Không thể thay đổi trạng thái tài khoản người dùng');
        }

        $account->update([
            'userable_type' => 'Reader'
        ]);

        $account->assignRole('Reader');

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

    public function deleteAccounts(Request $request)
    {
        $accounts = $request->accounts;
        foreach ($accounts as $item) {
            $account = Account::find($item['id']);

            if($account) {
                $account->delete();
            }
        }

        return response()->json(200);
    }
}
