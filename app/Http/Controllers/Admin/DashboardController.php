<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Visitor;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $newsCount = News::count();
        $announcementsCount = Announcement::count();

        // Daily Visitors (last 7 days)
        $dailyVisitors = Visitor::select('visited_date', DB::raw('count(*) as total'))
                                ->where('visited_date', '>=', Carbon::now()->subDays(6))
                                ->groupBy('visited_date')
                                ->orderBy('visited_date', 'asc')
                                ->get()
                                ->pluck('total', 'visited_date')
                                ->toArray();
        
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('D, d M');
            $data[] = $dailyVisitors[$date] ?? 0;
        }

        $chartData = [
            'labels' => $labels,
            'data' => $data,
        ];

        // Monthly Visitors count (just total this month)
        $monthlyVisitorsCount = Visitor::whereYear('visited_date', Carbon::now()->year)
                                       ->whereMonth('visited_date', Carbon::now()->month)
                                       ->count();

        $todayVisitorsCount = Visitor::where('visited_date', Carbon::today()->toDateString())->count();

        // 10 latest activity logs
        $activityLogs = ActivityLog::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('newsCount', 'announcementsCount', 'chartData', 'monthlyVisitorsCount', 'todayVisitorsCount', 'activityLogs'));
    }
}
