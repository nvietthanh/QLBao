<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminPostResource;
use App\Http\Resources\ReportPostResource;
use App\Http\Resources\ReportPostTopResource;
use App\Models\Post;
use App\Models\ReportPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reports = ReportPost::filter($request->all())
            ->orderBy('created_at', 'desc')
            ->paginate($request->limit ?? 10);

        return ReportPostResource::collection($reports);
    }

    public function deletePosts(Request $request)
    {
        $reports = $request->reportPosts;

        foreach($reports as $item) {
            $report = ReportPost::find($item['id']);

            if($report) {
                $report->delete();
            }
        }

        return response()->json(true);
    }

    public function showPost($id)
    {
        $post = Post::find($id);

        if(!$post) {
            abort(404);
        }

        return AdminPostResource::make($post);
    }

    public function showReport($id)
    {
        $report = ReportPost::find($id);

        return ReportPostResource::make($report);
    }
    
    public function listTop(Request $request)
    {
        $search = $request->search;
        $date = $request->date;
        $dateMouth = $date ? Carbon::parse($date)->format('m') : '';
        $dateYear = $date ? Carbon::parse($date)->format('Y') : '';        

        $reports = ReportPost::select('post_id', DB::raw("count(*) as count_report"))
            ->when($date, function ($query) use ($dateMouth, $dateYear) {
                $query->WhereMonth('created_at', $dateMouth)
                    ->whereYear('created_at', $dateYear);
            })
            ->when($search, function($query) use ($search) {
                $query->whereHas('account', function ($q) use ($search) {
                    $q->where('email', 'like', '%'.$search.'%');
                });
            })
            ->groupBy('post_id')
            ->orderBy('count_report', 'desc')
            ->paginate($request->limit ?? 10);

        return ReportPostTopResource::collection($reports);
    }
}
