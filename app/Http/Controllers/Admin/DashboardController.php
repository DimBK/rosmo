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
        // 1. News & Regulation (Blog) Stats
        $newsCount = News::count();
        $activeNews = News::where('status', true)->count();
        $draftNews = News::where('status', false)->count();
        $totalNewsViews = News::sum('views');
        $announcementsCount = Announcement::count();

        // 2. Gallery Stats
        $totalAlbums = \App\Models\Gallery::count();
        $totalPhotos = \App\Models\GalleryPhoto::count();

        // 3. Service Requirement & Regulations
        $totalServices = \App\Models\ServiceRequirement::count();
        $mainServices = \App\Models\ServiceRequirement::whereNull('parent_id')->count();
        $subServices = \App\Models\ServiceRequirement::whereNotNull('parent_id')->count();
        $servicesWithRegulation = \App\Models\ServiceRequirement::whereNotNull('regulation_source')
            ->where('regulation_source', '!=', '')
            ->count();

        // 4. Employee Stats
        $totalEmployees = \App\Models\Employee::count();
        $totalPns = \App\Models\Employee::where('status_pegawai', 'PNS')->count();
        $totalCpns = \App\Models\Employee::where('status_pegawai', 'CPNS')->count();
        $totalPppk = \App\Models\Employee::where('status_pegawai', 'PPPK')->count();
        $totalPppkParuhWaktu = \App\Models\Employee::where('status_pegawai', 'PPPK Paruh Waktu')->count();
        $employeesMale = \App\Models\Employee::where('jenis_kelamin', 'Laki-laki')->count();
        $employeesFemale = \App\Models\Employee::where('jenis_kelamin', 'Perempuan')->count();

        // 5. Organization Structure Stats
        $totalStructures = \App\Models\OrganizationStructure::count();
        $mainStructures = \App\Models\OrganizationStructure::whereNull('parent_id')->count();
        $subStructures = \App\Models\OrganizationStructure::whereNotNull('parent_id')->count();
        $echelonStats = DB::table('organization_structures')
            ->select('echelon', DB::raw('count(*) as total'))
            ->whereNotNull('echelon')
            ->where('echelon', '!=', '')
            ->groupBy('echelon')
            ->orderBy('total', 'desc')
            ->get();

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

        // 6. Province & Island Distribution Stats for Interactive Map
        $statisticController = new \App\Http\Controllers\StatisticController();
        $geoStats = $statisticController->computeProvinceDistribution();
        $provinceStats = $geoStats['provinces'];
        $islandStats = $geoStats['islands'];

        return view('admin.dashboard', compact(
            'newsCount', 'activeNews', 'draftNews', 'totalNewsViews', 'announcementsCount',
            'totalAlbums', 'totalPhotos',
            'totalServices', 'mainServices', 'subServices', 'servicesWithRegulation',
            'totalEmployees', 'totalPns', 'totalCpns', 'totalPppk', 'totalPppkParuhWaktu', 'employeesMale', 'employeesFemale',
            'totalStructures', 'mainStructures', 'subStructures', 'echelonStats',
            'chartData', 'monthlyVisitorsCount', 'todayVisitorsCount', 'activityLogs',
            'provinceStats', 'islandStats'
        ));
    }
}
