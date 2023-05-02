<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermOfUseRequest;
use App\Models\Account;
use App\Models\Notice;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TermOfUseController extends Controller
{
    public function index()
    {
        $termOfUse = Page::select(['title', 'content'])->where('type', 'term-of-use')->first();

        return response()->json($termOfUse);
    }

    public function update(TermOfUseRequest $request)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            
            $termOfUse = Page::where('type', 'term-of-use')->first();

            if($termOfUse) {
                $termOfUse->update([
                    'title' => $request->title,
                    'content' => $request->content
                ]);
            }
            else {
                Page::create([
                    'type' => 'term-of-use',
                    'title' => $request->title,
                    'content' => $request->content
                ]);
            }

            $notice = Notice::create([
                'content' => 'cập nhật thông tin điều khoản sử dụng',
                'notice_type' => 'term-of-use',
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
