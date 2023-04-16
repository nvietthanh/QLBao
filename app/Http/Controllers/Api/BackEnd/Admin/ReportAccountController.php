<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportAccountResource;
use App\Models\ReportAccount;
use Illuminate\Http\Request;

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
}
