<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportAccountResource;
use App\Http\Resources\ReportAccountTopResource;
use App\Models\ReportAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class ReportAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reports = ReportAccount::filter($request->all())
            ->orderBy('created_at', 'desc')
            ->paginate($request->limit ?? 10);

        return ReportAccountResource::collection($reports);
    }

    public function deleteAccounts(Request $request)
    {
        $reports = $request->reportAccounts;

        foreach($reports as $item) {
            $report = ReportAccount::find($item['id']);

            if($report) {
                $report->delete();
            }
        }

        return response()->json(true);
    }

    public function showReport($id)
    {
        $report = ReportAccount::find($id);

        return ReportAccountResource::make($report);
    }

    public function listTop(Request $request)
    {
        $search = $request->search;
        $date = $request->date;
        $dateMouth = $date ? Carbon::parse($date)->format('m') : '';
        $dateYear = $date ? Carbon::parse($date)->format('Y') : '';        

        $reports = ReportAccount::select('account_id', DB::raw("count(*) as count_report"))
            ->when($date, function ($query) use ($dateMouth, $dateYear) {
                $query->WhereMonth('created_at', $dateMouth)
                    ->whereYear('created_at', $dateYear);
            })
            ->when($search, function($query) use ($search) {
                $query->whereHas('account', function ($q) use ($search) {
                    $q->where('email', 'like', '%'.$search.'%');
                });
            })
            ->groupBy('account_id')
            ->orderBy('count_report', 'desc')
            ->paginate($request->limit ?? 10);

        return ReportAccountTopResource::collection($reports);
    }
}
