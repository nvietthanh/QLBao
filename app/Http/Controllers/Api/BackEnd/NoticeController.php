<?php

namespace App\Http\Controllers\Api\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeResource;
use App\Support\Collection;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function getNotice(Request $request)
    {
        $currentAccount = auth('accounts')->user();

        $notices = (new Collection($currentAccount->notices))->paginate($request->limit ?? 4);;

        return NoticeResource::collection($notices);
    }

    public function getCountNoticeUnread()
    {
        $currentAccount = auth('accounts')->user();
        $notices = $currentAccount->notices;
        $count = 0;

        foreach($notices as $notice) {
            if(!$notice->pivot->read_at) {
                $count++;
            }
        }

        return $count;
    }
}
