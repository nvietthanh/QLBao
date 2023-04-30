<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getChartAccount(Request $request)
    {
        $startDate = $request->daterange ? Carbon::parse($request->daterange[0]) : Carbon::now();
        $endDate = $request->daterange  ? Carbon::parse($request->daterange[1]) : Carbon::now();
        
        $period = CarbonPeriod::create($startDate, $endDate);

        $account_readers = Account::where('userable_type', 'Reader')
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate->format('Y/m/d'), $endDate->format('Y/m/d')])
                ->orderBy('created_at', 'ASC')
                ->get();
        $account_creators = Account::where('userable_type', 'Creator')
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate->format('Y/m/d'), $endDate->format('Y/m/d')])
                ->orderBy('created_at', 'ASC')
                ->get();
        
        $readers = Account::getAccountByChart($period, $account_readers, 'created_at');
        $creators = Account::getAccountByChart($period, $account_creators, 'created_at');

        // $maxData = $readers ? collect([max($readers['dataPeriod']), max($creators['dataPeriod'])])->max() : json_encode([]);

        $numberReader = Account::where('userable_type', 'Reader')->count();
        $numberCreator = Account::where('userable_type', 'Creator')->count();

        $count_data = [
            'sum' => $numberReader + $numberCreator,
            'readers' => $numberReader,
            'creators' => $numberCreator,
        ];

        return [
            'readers' => $readers,
            'creators' => $creators,
            'count_data' => $count_data
        ];
    }

    public function getChartPost(Request $request)
    {
        $startDate = $request->daterange ? Carbon::parse($request->daterange[0]) : Carbon::now();
        $endDate = $request->daterange  ? Carbon::parse($request->daterange[1]) : Carbon::now();
        
        $period = CarbonPeriod::create($startDate, $endDate);

        $post_approveds = Post::where('is_approved', 1)
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate->format('Y/m/d'), $endDate->format('Y/m/d')])
                ->orderBy('created_at', 'ASC')
                ->get();
        $post_unapproved = Post::where('is_approved', 0)
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate->format('Y/m/d'), $endDate->format('Y/m/d')])
                ->orderBy('created_at', 'ASC')
                ->get();
        
        $post_approved = Post::getPostByChart($period, $post_approveds, 'created_at');
        $post_unapproved = Post::getPostByChart($period, $post_unapproved, 'created_at');

        $numberApproved = Post::where('is_approved', 1)->count();
        $numberUnapproved = Post::where('is_approved', 0)->count();

        $count_data = [
            'sum' => $numberApproved + $numberUnapproved,
            'post_approved' => $numberApproved,
            'post_unapproved' => $numberUnapproved,
        ];

        return [
            'post_approved' => $post_approved,
            'post_unapproved' => $post_unapproved,
            'count_data' => $count_data
        ];
    }

    public function getChartCategory(Request $request)
    {
        $startDate = $request->daterange ? Carbon::parse($request->daterange[0]) : Carbon::now();
        $endDate = $request->daterange  ? Carbon::parse($request->daterange[1]) : Carbon::now();
        $date = [$startDate, $endDate];
        
        $categories = Category::orderBy('created_at', 'ASC')
                ->get();

        $dataResult = Post::getCategoryByChart($categories, $date, 'created_at');

        return $dataResult;
    }
}
