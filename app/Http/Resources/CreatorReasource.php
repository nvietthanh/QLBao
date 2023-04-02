<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatorReasource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'code' => $this->code,
            'first_name' => $this->accountProfile->first_name,
            'last_name' => $this->accountProfile->last_name,
            'image' => $this->accountProfile->image,
            'description' => $this->accountProfile->description,
            'remark' => $this->accountProfile->remark,
            'is_follow' => $this->isFollowing()
        ];
    }

    protected function isFollowing()
    {
        $currentAccount = auth('accounts')->user();
        if(!$currentAccount) {
            return false;
        }
        else {
            $isFolling = $currentAccount->whereHas('follows', function ($query) use ($currentAccount) {
                $query->where('account_id', $currentAccount->id)
                    ->where('follower_id', $this->id);
            })->first();

            return $isFolling  ? true : false;
        }
    }
}
