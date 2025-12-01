<?php

namespace App\Http\Controllers;

use App\Models\CalendarSource;
use App\Models\Feed;
use App\Models\Group;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sources' => CalendarSource::count(),
            'protected_sources' => CalendarSource::where('is_protected', true)->count(),
            'hidden_sources' => CalendarSource::whereNotNull('access_token')->count(),
            'total_groups' => Group::count(),
            'total_feeds' => Feed::count(),
            'protected_feeds' => Feed::whereNotNull('password_hash')->count(),
        ];

        $recent_sources = CalendarSource::latest()->take(5)->get();
        $recent_feeds = Feed::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recent_sources', 'recent_feeds'));
    }
}
