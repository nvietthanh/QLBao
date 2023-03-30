<?php

namespace App\Http\Controllers\BackEnd\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResgisterRequest;
use App\Models\Account;
use App\Models\AccountProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ResgisterController extends Controller
{
    use AuthenticatesUsers;

    public function resgister(ResgisterRequest $request)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            $account = Account::create(
                [
                    'code' => rand(10000000, 99999999),
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'userable_type' => 'Reader'
                ]
            );
            AccountProfile::create(array_merge(
                $request->only(['first_name', 'last_name', 'phone', 'male']),
                [
                    'account_id' => $account->id,
                    'date_of_birth' => $request->date_of_birth ? Carbon::create($request->date_of_birth) : null
                ]
            ));

            DB::commit();

            Auth::guard('accounts')->login($account);

            return response()->json(true);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
