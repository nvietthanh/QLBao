<?php

namespace App\Http\Resources;

use App\Models\AccountSavePost;
use App\Models\HagTag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'content' => $this->content,
            'image' => $this->image,
            'categoryName' => $this->category->name,
            'categorySlug' => $this->category->slug,
            'is_save' => $this->checkSavePost(),
            'creator' => $this->creator->accountProfile->getFullName(),
            'hagtags' => $this->getHagtags(),
            'hagtagNames' => $this->getHagtagNames(),
            'creatorCode' => $this->creator->code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function checkSavePost()
    {
        $currentAccount = auth('accounts')->user();

        if(!$currentAccount) {
            return false;
        }

        $savePost = AccountSavePost::where('account_id', $currentAccount->id)
            ->where('post_id', $this->id)
            ->first();
        if($savePost) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getHagtags()
    {
        $resultHagtag = [];
        $hagtags = $this->postHasHagtag;

        if($hagtags) {
            foreach($hagtags as $hagtag) {
                array_push($resultHagtag, $hagtag->pivot->hagtag_id);
            }
        }

        return $resultHagtag;
    }

    public function getHagtagNames()
    {
        $resultHagtagName = [];
        $hagtagIds = $this->getHagtags();

        if($hagtagIds) {
            $resultHagtagName = HagTag::select(['id', 'name', 'slug'])->whereIn('id', $hagtagIds)
                ->orderBy('name', 'asc')->get();
        }
        
        return $resultHagtagName;
    }
}
