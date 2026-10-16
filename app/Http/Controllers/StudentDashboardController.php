<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    /**
     * Student Dashboard — shows ALL notices with filters + pagination.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        /* ─── Per-page ─── */
        if ($request->filled('per_page')) {
            session(['student_per_page' => (int) $request->per_page]);
        }

        $perPage = (int) session('student_per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        /* ─── Base query: ALL active notices ─── */
        $query = Notice::with('author')
            ->where('is_active', true)
            ->latest('published_at');

        /* ─── Search ─── */
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($w) use ($s) {
                $w->where('title', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        /* ─── Category ─── */
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        /* ─── Date range ─── */
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        $notices = $query->paginate($perPage)->withQueryString();

        /* ─── Stats ─── */
        $stats = [
            'total'     => Notice::where('is_active', true)->count(),
            'this_week' => Notice::where('is_active', true)
                ->whereBetween('published_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'urgent'    => Notice::where('is_active', true)
                ->where('priority', 'Urgent')
                ->count(),
            'must_read' => Notice::where('is_active', true)
                ->where('category', 'must_read')
                ->count(),
        ];

        /* ─── Sidebar: urgent notices (top 5) ─── */
        $urgentNotices = Notice::where('is_active', true)
            ->where('priority', 'Urgent')
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('dashboard', [
            'user'          => $user,
            'stats'         => $stats,
            'urgentNotices' => $urgentNotices,
            'notices'       => $notices,
            'categoryMap'   => Notice::categories(),
        ]);
    }
}