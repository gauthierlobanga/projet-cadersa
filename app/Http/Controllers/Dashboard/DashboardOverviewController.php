<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Post;
use App\Models\Project;
use App\Models\Report;
use Illuminate\Contracts\View\View;

class DashboardOverviewController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'statistics' => [
                'projects' => Project::active()->count(),
                'formations' => Formation::published()->count(),
                'posts' => Post::published()->count(),
                'reports' => Report::published()->count(),
            ],
            'recentPosts' => Post::published()
                ->select(['id', 'title', 'slug', 'published_at'])
                ->latest('published_at')
                ->limit(4)
                ->get(),
            'recentReports' => Report::published()
                ->select(['id', 'title', 'period_type', 'report_year', 'period_number', 'published_at'])
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
