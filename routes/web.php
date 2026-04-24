<?php

use Illuminate\Support\Facades\Route;

use App\Models\News;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ServiceRequirementController;

Route::get('/', function () {
    $news = News::where('status', true)->latest('publish_date')->take(6)->get();
    return view('pages.home', compact('news'));
})->name('home');

Route::get('/layanan/{service_requirement:slug}', function (App\Models\ServiceRequirement $service_requirement) {
    return view('pages.tour-details', ['service' => $service_requirement]);
})->name('services.details');

Route::get('/news/{news}', function (News $news) {
    if (!session()->has('news_viewed_' . $news->id)) {
        $news->increment('views');
        session()->put('news_viewed_' . $news->id, true);
    }
    $previous = News::where('status', true)
                    ->where('publish_date', '<', $news->publish_date)
                    ->orderBy('publish_date', 'desc')
                    ->first();
    $next = News::where('status', true)
                ->where('publish_date', '>', $news->publish_date)
                ->orderBy('publish_date', 'asc')
                ->first();
    return view('pages.blog-details', compact('news', 'previous', 'next'));
})->name('news.details');

Route::get('/search', function (Request $request) {
    $q = $request->query('q');
    
    $newsResults = News::where('status', true)
        ->where(function ($query) use ($q) {
            $query->where('title', 'like', "%{$q}%")
                  ->orWhere('content', 'like', "%{$q}%")
                  ->orWhereHas('tags', function ($query) use ($q) {
                      $query->where('name', 'like', "%{$q}%");
                  });
        })->latest('publish_date')->get();

    $announcementResults = Announcement::where('title', 'like', "%{$q}%")
        ->orWhere('content', 'like', "%{$q}%")
        ->latest('publish_date')->get();

    return view('pages.search', compact('q', 'newsResults', 'announcementResults'));
})->name('search');

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/struktur-organisasi', function () {
    $rootStructures = \App\Models\OrganizationStructure::whereNull('parent_id')
        ->with('children.children.children') // Eager load a few levels deep
        ->orderBy('sort_order')->get();
    return view('pages.organization-structure', compact('rootStructures'));
})->name('organization.structure');

Route::get('/statistik', [\App\Http\Controllers\StatisticController::class, 'index'])->name('statistik.index');

Route::get('/blog-details', function () {
    return view('pages.blog-details');
});

Route::get('/blog', function (Request $request) {
    $query = News::where('status', true)->with('tags');
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('content', 'like', '%' . $search . '%');
        });
    }

    if ($request->filled('tagline')) {
        $tagline = $request->tagline;
        $query->whereHas('tags', function ($q) use ($tagline) {
            $q->where('name', $tagline);
        });
    }

    $newsList = $query->latest('publish_date')->paginate(9)->withQueryString();
    $tags = \App\Models\Tag::all();

    return view('pages.blog', compact('newsList', 'tags'));
})->name('blog');

Route::get('/booking', function () {
    return view('pages.booking');
});

Route::get('/contact', function () {
    return view('pages.contact');
});

Route::get('/destination-details', function () {
    return view('pages.destination-details');
});

Route::get('/destinations', function () {
    return view('pages.destinations');
});

Route::get('/faq', function () {
    return view('pages.faq');
});

Route::get('/gallery', function () {
    $galleries = \App\Models\Gallery::with('photos')->orderBy('sort_order')->get();
    
    // Get up to 8 random photos from inner album photos
    $randomPhotos = \App\Models\GalleryPhoto::inRandomOrder()->limit(8)->get();
    
    // Fallback to album covers if not enough inner photos
    if ($randomPhotos->count() < 4) {
        $coverPhotos = \App\Models\Gallery::inRandomOrder()->limit(8 - $randomPhotos->count())->get()->map(function($g) {
            $photo = new \App\Models\GalleryPhoto();
            $photo->image_path = $g->image_path;
            $photo->gallery_id = $g->id;
            return $photo;
        });
        $randomPhotos = $randomPhotos->concat($coverPhotos);
    }
    
    return view('pages.gallery', compact('galleries', 'randomPhotos'));
});

Route::get('/privacy', function () {
    return view('pages.privacy');
});

Route::get('/starter-page', function () {
    return view('pages.starter-page');
});

Route::get('/terms', function () {
    return view('pages.terms');
});

Route::get('/testimonials', function () {
    return view('pages.testimonials');
});

Route::get('/tour-details', function () {
    return view('pages.tour-details');
});

Route::get('/tours', function () {
    return view('pages.tours');
});

Route::fallback(function() {
    return view('pages.404');
});

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\TagController;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('news', NewsController::class);
    Route::resource('tags', TagController::class)->except(['show']);
    Route::resource('service_requirements', ServiceRequirementController::class)->except(['show']);
    Route::resource('announcements', AnnouncementController::class);
    Route::get('organization_structures/export', [\App\Http\Controllers\Admin\OrganizationStructureController::class, 'export'])->name('organization_structures.export');
    Route::post('organization_structures/import', [\App\Http\Controllers\Admin\OrganizationStructureController::class, 'import'])->name('organization_structures.import');
    Route::resource('organization_structures', \App\Http\Controllers\Admin\OrganizationStructureController::class);

    // Employee Statistics
    Route::get('employees', [\App\Http\Controllers\Admin\EmployeeController::class, 'index'])->name('employees.index');
    Route::post('employees/import', [\App\Http\Controllers\Admin\EmployeeController::class, 'import'])->name('employees.import');

    // CMS & Settings
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
    
    Route::resource('team_members', \App\Http\Controllers\Admin\TeamMemberController::class);
    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class);
    Route::resource('galleries.photos', \App\Http\Controllers\Admin\GalleryPhotoController::class)->shallow()->except(['show', 'edit', 'update']);
    Route::resource('media', \App\Http\Controllers\Admin\MediaController::class);

    // Super Admin Routes
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });
});
