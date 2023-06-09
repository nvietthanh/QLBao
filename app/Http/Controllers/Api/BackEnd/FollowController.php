<?php

namespace App\Http\Controllers\Api\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreatorReasource;
use App\Http\Resources\FollowerResource;
use App\Models\Account;
use App\Support\Collection;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function listFollow(Request $request)
    {
        $currentAccount = auth('accounts')->user();

        $follows = (new Collection($currentAccount->follows))->paginate($request->limit ?? 10);

        return CreatorReasource::collection($follows);
    }

    public function listFollower(Request $request)
    {
        $currentAccount = auth('accounts')->user();

        $followers = (new Collection($currentAccount->hasFollows))->paginate($request->limit ?? 10);

        return FollowerResource::collection($followers);
    }

    public function deleteFollow($code)
    {
        $account = Account::where('code', $code)->first();

        $currentAccount = auth('accounts')->user();

        $currentAccount->hasFollows()->detach($account->id);

        return response()->json(true);
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
