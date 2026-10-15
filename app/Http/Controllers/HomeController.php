<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index(Request $request)
    {
        // Base query
        $query = Notice::query()->latest();

        // ---- Category filter (array of selected categories) ----
        $selectedCategories = (array) $request->input('categories', []);
        if (!empty($selectedCategories)) {
            $query->whereIn('category', $selectedCategories);
        }

        // ---- Search filter (title + description) ----
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($b) use ($q) {
                $b->where('title', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // ---- Priority filter ----
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // ---- Date range filter ----
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // ---- Get filtered results ----
        $filtered = (clone $query)->get();

        // ---- Banner = latest must_read OR latest urgent OR latest overall ----
        $banner = $filtered->firstWhere('category', 'must_read')
                ?? $filtered->firstWhere('priority', 'Urgent')
                ?? $filtered->first();

        // ---- Top 3 featured cards (excluding banner) ----
        $topCards = $filtered->where('id', '!=', optional($banner)->id)->take(3);

        // ---- Paginated list (10 per page, keeps query string) ----
        $notices = $query->paginate(10)->withQueryString();

        // ---- Active filter summary (for UI) ----
        $activeFilters = [
            'categories' => $selectedCategories,
            'q'          => $request->q,
            'priority'   => $request->priority,
            'from'       => $request->from,
            'to'         => $request->to,
        ];

        return view('home', compact('banner','topCards','notices','activeFilters'));
    }
}