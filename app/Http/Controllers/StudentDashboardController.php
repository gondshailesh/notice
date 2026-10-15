<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        $user = Auth::user();

        // Latest 5 notices for the sidebar
        $latestNotices = Notice::latest()->take(5)->get();

        // Urgent + must-read highlighted notices
        $urgentNotices = Notice::where('priority', 'Urgent')
            ->latest()->take(3)->get();

        // Stats
        $stats = [
            'total'      => Notice::count(),
            'this_week'  => Notice::where('created_at', '>=', now()->subDays(7))->count(),
            'urgent'     => Notice::where('priority', 'Urgent')->count(),
            'must_read'  => Notice::where('category', 'must_read')->count(),
        ];

        // Category counts for the mini-chart
        $categoryCounts = Notice::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        return view('student.dashboard', compact(
            'user','latestNotices','urgentNotices','stats','categoryCounts'
        ));
    }
}