<?php

namespace App\Http\Controllers\Api\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreatorReasource;
use App\Models\Account;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function listFollow(Request $request)
    {
        $currentAccount = auth('accounts')->user();
        $accountIds = [];

        foreach($currentAccount->follows as $follow)
        {
            $accountIds[] = $follow->id;
        }

        $accountFollows = Account::whereIn('id', $accountIds)
            ->get();

        return CreatorReasource::collection($accountFollows);
    }

    public function follow(Request $request, $code)
    {
        $creator = Account::where('code', $code)->first();
        $currentAccount = auth('accounts')->user();

        if($code == $currentAccount->code) {
            abort(404);
        }
        else {
            $isFolling = $currentAccount->whereHas('follows', function ($query) use ($creator, $currentAccount) {
                $query->where('account_id', $currentAccount->id)
                    ->where('follower_id', $creator->id);
            })->first();
            
            if($isFolling) {
                abort(404);
            }
            else{
                $currentAccount->follows()->attach([
                    $creator->id => ['follow_at' => now()]
                ]);
                
                return response()->json(true);
            }
        }

    }

    public function unfollow(Request $request, $code)
    {
        $creator = Account::where('code', $code)->first();
        $currentAccount = auth('accounts')->user();

        $isFolling = $currentAccount->whereHas('follows', function ($query) use ($creator, $currentAccount) {
            $query->where('account_id', $currentAccount->id)
                ->where('follower_id', $creator->id);
        })->first();
        
        if(!$isFolling) {
            abort(404);
        }
        else{
            $currentAccount->follows()->detach($creator->id);
            
            return response()->json(true);
        }
    }
}
