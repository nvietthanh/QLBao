<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminPostResource;
use App\Http\Resources\ReportPostResource;
use App\Models\Post;
use App\Models\ReportPost;
use Illuminate\Http\Request;

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
}
