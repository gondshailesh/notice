<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Notice Board — visible to any verified user after login.
     */
    public function index(Request $request)
    {
        /* ─── Per-page selector ─── */
        if ($request->filled('per_page')) {
            session(['home_per_page' => (int) $request->per_page]);
        }

        $perPage = (int) session('home_per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        /* ─── Base query: only active notices ─── */
        $query = Notice::where('is_active', true)->latest('published_at');

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

        /* ─── ✅ Priority (NEW) ─── */
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        /* ─── Date range ─── */
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        $notices = $query->paginate($perPage)->withQueryString();

        /* ─── Hero: newest must_read / urgent ─── */
        $hero = Notice::where('is_active', true)
            ->whereIn('category', ['must_read', 'urgent'])
            ->latest('published_at')
            ->first()
            ?? Notice::where('is_active', true)
                ->latest('published_at')
                ->first();

        /* ─── Small stats ─── */
        $stats = [
            'total'     => Notice::where('is_active', true)->count(),
            'this_week' => Notice::where('is_active', true)
                ->whereBetween('published_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'urgent'    => Notice::where('is_active', true)->where('priority', 'Urgent')->count(),
            'must_read' => Notice::where('is_active', true)->where('category', 'must_read')->count(),
        ];

        return view('home', [
            'notices'     => $notices,
            'hero'        => $hero,
            'stats'       => $stats,
            'categoryMap' => Notice::categories(),
        ]);
    }
}