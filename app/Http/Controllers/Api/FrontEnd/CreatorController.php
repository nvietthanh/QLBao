<?php

namespace App\Http\Controllers\Api\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreatorReasource;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreatorController extends Controller
{
    public function getInfor($id)
    {
        $account = Account::where('code', $id)->first();

        return CreatorReasource::make($account);
    }

    public function getListPopular($id = null)
    {
        $creators = Account::where('userable_type', 'Creator')
            ->where('code', '<>', $id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return CreatorReasource::collection($creators);
    }
}
