<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrivatePolicyRequest;
use App\Models\Account;
use App\Models\Notice;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrivatePolicyController extends Controller
{
    public function index()
    {
        $privatePolicy = Page::select(['title', 'content'])->where('type', 'private-policy')->first();

        return response()->json($privatePolicy);
    }

    public function update(PrivatePolicyRequest $request)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            
            $privatePolicy = Page::where('type', 'private-policy')->first();

            if($privatePolicy) {
                $privatePolicy->update([
                    'title' => $request->title,
                    'content' => $request->content
                ]);
            }
            else {
                Page::create([
                    'type' => 'private-policy',
                    'title' => $request->title,
                    'content' => $request->content
                ]);
            }

            $notice = Notice::create([
                'content' => 'cập nhật thông tin chính sách bảo mật',
                'notice_type' => 'private-policy',
                'status' => 0,
                'type' => 1
            ]);

            $accounts = Account::all();

            foreach($accounts as $account) {
                $notice->noticeAccount()->attach($account->id);
            }

            DB::commit();

            return response()->json(200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
